<?php
try {
    $db = new SQLite3('database.sqlite');
    $db->exec('CREATE TABLE IF NOT EXISTS confirmations (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        phone TEXT, 
        name TEXT, 
        payment_ref TEXT, 
        status TEXT, 
        is_downloaded INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )');
    
    // Check if column exists, add if not
    $cols = $db->query("PRAGMA table_info(confirmations)");
    $hasDownloaded = false;
    while ($col = $cols->fetchArray()) {
        if ($col['name'] == 'is_downloaded') {
            $hasDownloaded = true;
            break;
        }
    }
    if (!$hasDownloaded) {
        $db->exec('ALTER TABLE confirmations ADD COLUMN is_downloaded INTEGER DEFAULT 0');
    }

    echo "Database initialized successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
