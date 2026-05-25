<?php
session_start();
$is_logged_in = isset($_SESSION['admin_auth']) && $_SESSION['admin_auth'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Techmeet 2026</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 1000px;
            width: 95%;
            margin: 2rem auto;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 1.5rem;
            border-radius: 20px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }
        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
        }
        .admin-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2rem;
            backdrop-filter: blur(15px);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            color: #fff;
        }
        th {
            text-align: left;
            padding: 1rem;
            border-bottom: 1px solid var(--glass-border);
            color: var(--secondary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            font-size: 0.9rem;
        }
        .badge {
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-success { background: rgba(0, 128, 128, 0.2); color: #00cccc; border: 1px solid rgba(0, 128, 128, 0.3); }
        .badge-warning { background: rgba(227, 36, 43, 0.1); color: #ff4d4d; border: 1px solid rgba(227, 36, 43, 0.2); }
        
        .login-box {
            max-width: 400px;
            margin: 10vh auto;
        }
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .logout-btn {
            background: transparent;
            border: 1px solid var(--glass-border);
            padding: 0.5rem 1rem;
            width: auto;
            margin-top: 0;
            font-size: 0.8rem;
        }
        
        @media (max-width: 768px) {
            th:nth-child(3), td:nth-child(3) { display: none; } /* Hide Payment Ref on mobile */
        }
    </style>
</head>
<body>

<div class="admin-container">
    <?php if (!$is_logged_in): ?>
        <div class="card login-box">
            <h1 class="hero-title" style="font-size: 2rem;">Admin Login</h1>
            <p class="subtitle">Secure access for Techmeet 2026</p>
            <form id="login-form">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="email" required placeholder="silaswahomeg@gmail.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" required placeholder="•••••">
                </div>
                <button type="submit">Unlock Dashboard</button>
                <div id="login-error" style="color: #ff4d4d; margin-top: 1rem; text-align: center; font-size: 0.9rem;"></div>
            </form>
        </div>
    <?php else: ?>
        <div class="header-flex">
            <div>
                <h1 class="hero-title" style="text-align: left; font-size: 2rem; margin: 0;">Command Center</h1>
                <p style="color: var(--text-secondary);">Real-time attendee monitoring</p>
            </div>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value" id="stat-total">0</div>
                <div class="stat-label">Confirmed Guests</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="stat-downloaded">0</div>
                <div class="stat-label">Tickets Downloaded</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="stat-conversion">0%</div>
                <div class="stat-label">Download Rate</div>
            </div>
        </div>

        <div class="admin-card">
            <table>
                <thead>
                    <tr>
                        <th>Guest Name</th>
                        <th>WhatsApp Phone</th>
                        <th>Payment Message/ID</th>
                        <th>Status</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody id="attendee-list">
                    <!-- Loaded via JS -->
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
async function logout() {
    await fetch('api.php?action=admin_logout');
    location.reload();
}

if (document.getElementById('login-form')) {
    document.getElementById('login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorDiv = document.getElementById('login-error');
        
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        
        try {
            const response = await fetch('api.php?action=admin_login', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                location.reload();
            } else {
                errorDiv.innerText = result.message;
            }
        } catch (err) {
            errorDiv.innerText = 'Server error. Try again.';
        }
    });
}

async function loadData() {
    if (!document.getElementById('attendee-list')) return;

    try {
        const response = await fetch('api.php?action=get_admin_data');
        const result = await response.json();
        
        if (result.success) {
            // Update Stats
            document.getElementById('stat-total').innerText = result.stats.total;
            document.getElementById('stat-downloaded').innerText = result.stats.downloaded;
            const rate = result.stats.total > 0 ? Math.round((result.stats.downloaded / result.stats.total) * 100) : 0;
            document.getElementById('stat-conversion').innerText = rate + '%';
            
            // Render Table
            const tbody = document.getElementById('attendee-list');
            tbody.innerHTML = result.attendees.map(a => `
                <tr>
                    <td style="font-weight: 700;">${a.name}</td>
                    <td>${a.phone}</td>
                    <td style="max-width: 300px; font-size: 0.8rem; color: #ccc;">${a.payment_ref}</td>
                    <td>
                        <span class="badge ${a.is_downloaded ? 'badge-success' : 'badge-warning'}">
                            ${a.is_downloaded ? 'Downloaded' : 'Not Downloaded'}
                        </span>
                    </td>
                    <td style="color: var(--text-secondary); font-size: 0.75rem;">
                        ${new Date(a.created_at).toLocaleDateString()} ${new Date(a.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                    </td>
                </tr>
            `).join('');
        }
    } catch (err) {
        console.error('Failed to load admin data');
    }
}

<?php if ($is_logged_in): ?>
loadData();
setInterval(loadData, 30000); // Polling every 30s
<?php endif; ?>
</script>

</body>
</html>
