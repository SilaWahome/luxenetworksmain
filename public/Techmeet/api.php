<?php
header('Content-Type: application/json');
session_start();

$db_file = 'database.sqlite';
$google_script_url = 'https://script.google.com/macros/s/AKfycbxSdnWqeEGCIPGGRVMwr6jVKvJ3aVU38XKlql5jKKJ4o_cga8MleaDMqsMmm6CfJB4/exec';
$cache_file = 'registrations_cache.json';
$cache_expiry = 3600; // 1 hour

function getDatabaseConnection() {
    $envPath = dirname(__DIR__, 2) . '/.env';
    if (!file_exists($envPath)) {
        throw new Exception("Environment file not found.");
    }
    
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $config = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = explode('=', $line, 2);
        $config[trim($name)] = trim($value, ' "');
    }

    $dbConnection = $config['DB_CONNECTION'] ?? 'mysql';
    if ($dbConnection === 'sqlite') {
        $dbPath = dirname(__DIR__, 2) . '/database/' . ($config['DB_DATABASE'] ?? 'database.sqlite');
        return new PDO("sqlite:" . $dbPath);
    }

    $host = $config['DB_HOST'] ?? '127.0.0.1';
    $port = $config['DB_PORT'] ?? '3306';
    $db = $config['DB_DATABASE'] ?? 'luxenet';
    $user = $config['DB_USERNAME'] ?? 'root';
    $pass = $config['DB_PASSWORD'] ?? '';

    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function fetchRegistrations() {
    global $google_script_url, $cache_file, $cache_expiry;

    // Check cache
    if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_expiry)) {
        return json_decode(file_get_contents($cache_file), true);
    }

    // Fetch from Google Script
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $google_script_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ['error' => $error_msg];
    }
    curl_close($ch);

    if ($response) {
        file_put_contents($cache_file, $response);
        return json_decode($response, true);
    }

    // Fallback to cache if request fails
    if (file_exists($cache_file)) {
        return json_decode(file_get_contents($cache_file), true);
    }

    return null;
}

function normalizePhone($phone) {
    // Remove all non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // If it starts with 256, convert it to 0
    if (strpos($phone, '256') === 0) {
        $phone = '0' . substr($phone, 3);
    }
    
    // If it's 9 digits and doesn't start with 0, add 0
    if (strlen($phone) == 9 && $phone[0] != '0') {
        $phone = '0' . $phone;
    }
    
    return $phone;
}

$action = $_GET['action'] ?? '';

if ($action == 'verify_phone') {
    $phone = $_GET['phone'] ?? '';
    if (!$phone) {
        echo json_encode(['success' => false, 'message' => 'Phone number is required.']);
        exit;
    }

    $normalized = normalizePhone($phone);

    // 1. Check local database for existing confirmation
    try {
        $db = new SQLite3($db_file);
        $stmt = $db->prepare('SELECT id, name, status FROM confirmations WHERE phone = :phone LIMIT 1');
        $stmt->bindValue(':phone', $normalized, SQLITE3_TEXT);
        $res = $stmt->execute();
        $existing = $res->fetchArray(SQLITE3_ASSOC);
        
        if ($existing) {
            echo json_encode([
                'success' => true, 
                'already_confirmed' => true,
                'name' => $existing['name'],
                'phone' => $normalized,
                'ticket_id' => '#TM2026-' . str_pad($existing['id'], 3, '0', STR_PAD_LEFT)
            ]);
            exit;
        }
    } catch (Exception $e) {
        // Continue to Google Sheets check if DB fails
    }

    // 2. Not confirmed yet, check Laravel application registration
    try {
        $laravelDb = getDatabaseConnection();
        $stmt = $laravelDb->prepare('SELECT name, phone, status FROM meet_greet_applications');
        $stmt->execute();
        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $found = null;
        foreach ($applications as $app) {
            $regPhone = normalizePhone($app['phone'] ?? '');
            if ($regPhone == $normalized) {
                $found = $app;
                break;
            }
        }

        if ($found) {
            if ($found['status'] === 'approved') {
                echo json_encode([
                    'success' => true, 
                    'name' => $found['name'],
                    'phone' => $normalized
                ]);
            } elseif ($found['status'] === 'declined') {
                echo json_encode(['success' => false, 'message' => 'Your registration request has been declined.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Your registration is currently pending approval. Please check back later.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phone number not found in registration list. Please register on the homepage first.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database connection error: ' . $e->getMessage()]);
    }
} 

elseif ($action == 'confirm_attendance') {
    $phone = $_POST['phone'] ?? '';
    $name = $_POST['name'] ?? '';
    $payment_ref = $_POST['payment_ref'] ?? '';

    if (!$phone || !$name || !$payment_ref) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    $normalized = normalizePhone($phone);

    // Save to SQLite
    try {
        $db = new SQLite3($db_file);
        
        // Double check for duplicate before inserting
        $check = $db->prepare('SELECT id FROM confirmations WHERE phone = :phone LIMIT 1');
        $check->bindValue(':phone', $normalized, SQLITE3_TEXT);
        $res = $check->execute();
        if ($res->fetchArray()) {
            echo json_encode(['success' => false, 'message' => 'Attendance already confirmed for this phone number.']);
            exit;
        }

        $stmt = $db->prepare('INSERT INTO confirmations (phone, name, payment_ref, status) VALUES (:phone, :name, :payment_ref, "confirmed")');
        $stmt->bindValue(':phone', $normalized, SQLITE3_TEXT);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':payment_ref', $payment_ref, SQLITE3_TEXT);
        $stmt->execute();
        
        $new_id = $db->lastInsertRowID();
        
        echo json_encode([
            'success' => true, 
            'message' => 'Confirmation saved successfully.',
            'ticket_id' => '#TM2026-' . str_pad($new_id, 3, '0', STR_PAD_LEFT)
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

elseif ($action == 'mark_downloaded') {
    $phone = $_POST['phone'] ?? '';
    if (!$phone) {
        echo json_encode(['success' => false, 'message' => 'Phone is required.']);
        exit;
    }

    $normalized = normalizePhone($phone);
    try {
        $db = new SQLite3($db_file);
        $stmt = $db->prepare('UPDATE confirmations SET is_downloaded = 1 WHERE phone = :phone');
        $stmt->bindValue(':phone', $normalized, SQLITE3_TEXT);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

elseif ($action == 'admin_login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email === 'silaswahomeg@gmail.com' && $password === '12345') {
        $_SESSION['admin_auth'] = true;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    }
}

elseif ($action == 'admin_logout') {
    session_destroy();
    echo json_encode(['success' => true]);
}

elseif ($action == 'get_admin_data') {
    if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
        exit;
    }

    try {
        $db = new SQLite3($db_file);
        
        // Get Stats
        $total = $db->querySingle('SELECT COUNT(*) FROM confirmations');
        $downloaded = $db->querySingle('SELECT COUNT(*) FROM confirmations WHERE is_downloaded = 1');
        
        // Get Attendees
        $results = $db->query('SELECT * FROM confirmations ORDER BY created_at DESC');
        $attendees = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $attendees[] = $row;
        }

        echo json_encode([
            'success' => true,
            'stats' => [
                'total' => $total,
                'downloaded' => $downloaded
            ],
            'attendees' => $attendees
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

elseif ($action == 'get_ticket_details') {
    $id = $_GET['id'] ?? '';
    // Optional: lookup confirmation by ID for the ticket page
}

else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}
?>
