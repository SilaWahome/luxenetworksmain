<?php
$configPath = 'config.json';
$config = file_exists($configPath) ? json_decode(file_get_contents($configPath), true) : [];
$eventDate = $config['event_date'] ?? 'APR 06, 2026';
$eventTime = $config['event_time'] ?? '2:30 PM';
$eventLocation = $config['event_location'] ?? 'SILVERBACK LOUNGE';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leading with AI - Techmeet Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h1 class="hero-title">Leading with AI</h1>
        <p class="subtitle">Confirm your attendance for the Techmeet 2026</p>

        <!-- Step 1: Phone Number -->
        <div id="step-1" class="step active">
            <div class="form-group">
                <label for="phone">Enter WhatsApp Phone Number</label>
                <input type="tel" id="phone" placeholder="e.g. 770123456" autocomplete="tel">
            </div>
            <button onclick="verifyPhone()">Verify Registration</button>
            <div id="error-1" style="color: #ff4d4d; margin-top: 1rem; text-align: center; font-size: 0.9rem;"></div>
        </div>

        <!-- Step 2: Name Confirmation -->
        <div id="step-2" class="step">
            <div class="form-group">
                <label>Found Registration for:</label>
                <div id="display-name" style="font-size: 1.5rem; font-weight: 700; margin: 1rem 0; color: #fff;"></div>
                <p style="color: var(--text-secondary); margin-bottom: 2rem;">Is this you? If yes, please provide your payment confirmation details.</p>
            </div>
            <div class="form-group">
                <label for="payment_ref">Payment Confirmation Message / ID</label>
                <textarea id="payment_ref" placeholder="Paste your mobile money message here" rows="4"></textarea>
            </div>
            <button onclick="confirmAttendance()">Confirm & Generate Ticket</button>
            <button onclick="prevStep(1)" style="background: transparent; border: 1px solid var(--glass-border); margin-top: 0.5rem;">Go Back</button>
            <div id="error-2" style="color: #ff4d4d; margin-top: 1rem; text-align: center; font-size: 0.9rem;"></div>
        </div>

        <!-- Step 3: Ticket -->
        <div id="step-3" class="step">
            <div class="ticket-container">
                <div class="ticket" id="ticket-content">
                    <div class="ticket-header">
                        <div class="pattern-overlay"></div>
                        <div class="header-content">
                            <div class="event-caps">TECHMEET 2026</div>
                            <div class="event-title">LEADING WITH AI</div>
                        </div>
                        <div class="ticket-type">VIP ADMIT ONE</div>
                    </div>
                    <div class="ticket-body">
                        <div class="ticket-details">
                            <div class="detail-group">
                                <label>GUEST NAME</label>
                                <div class="value" id="ticket-name">---</div>
                            </div>
                            <div class="detail-group">
                                <label>TICKET ID</label>
                                <div class="value accent" id="ticket-id">#TM2026-000</div>
                            </div>
                            <div class="detail-group">
                                <label>DATE & TIME</label>
                                <div class="value"><?php echo $eventDate; ?> | <?php echo $eventTime; ?></div>
                            </div>
                            <div class="detail-group">
                                <label>LOCATION</label>
                                <div class="value"><?php echo $eventLocation; ?></div>
                            </div>
                        </div>
                        <div class="ticket-qr">
                            <img id="qr-code-img" src="" alt="QR Code">
                            <div class="qr-label">SCAN AT ENTRANCE</div>
                        </div>
                    </div>
                    <div class="ticket-footer">
                        <div class="footer-msg">"The future is built by those who lead with AI."</div>
                        <div class="arrival-note">Arrival: 2:00 PM (Sharp)</div>
                    </div>
                </div>
            </div>
            <button onclick="handleDownload()" style="margin-top: 2rem; background: var(--secondary); color: #000; border: none;">Download / Print Ticket</button>
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-secondary);">Please take a screenshot of this ticket.</p>
        </div>
    </div>
</div>

<script>
let userData = {
    phone: '',
    name: '',
    payment_ref: ''
};

function normalizePhone(phone) {
    phone = phone.replace(/[^0-9]/g, '');
    if (phone.startsWith('256')) {
        phone = '0' + phone.substring(3);
    }
    if (phone.length === 9 && phone[0] !== '0') {
        phone = '0' + phone;
    }
    return phone;
}

async function verifyPhone() {
    const phoneInput = document.getElementById('phone').value;
    const errorDiv = document.getElementById('error-1');
    const btn = document.querySelector('#step-1 button');
    
    errorDiv.innerText = '';

    if (!phoneInput) {
        errorDiv.innerText = 'Please enter your phone number.';
        return;
    }

    const normalized = normalizePhone(phoneInput);
    
    btn.disabled = true;
    btn.innerText = 'Verifying...';

    try {
        const response = await fetch(`api.php?action=verify_phone&phone=${normalized}`);
        const result = await response.json();

        if (result.success) {
            userData.phone = result.phone;
            userData.name = result.name;
            
            if (result.already_confirmed) {
                // Skip to ticket
                document.getElementById('ticket-name').innerText = result.name;
                document.getElementById('ticket-id').innerText = result.ticket_id;
                // Generate QR
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(result.ticket_id + ' | ' + result.name)}`;
                document.getElementById('qr-code-img').src = qrUrl;
                nextStep(3);
            } else {
                document.getElementById('display-name').innerText = result.name;
                nextStep(2);
            }
        } else {
            errorDiv.innerText = result.message;
        }
    } catch (e) {
        errorDiv.innerText = 'Error connecting to server. Please try again.';
    } finally {
        btn.disabled = false;
        btn.innerText = 'Verify Registration';
    }
}

async function markAsDownloaded() {
    try {
        const formData = new FormData();
        formData.append('phone', userData.phone);
        await fetch('api.php?action=mark_downloaded', {
            method: 'POST',
            body: formData
        });
    } catch (e) {
        console.error('Failed to mark as downloaded');
    }
}

function handleDownload() {
    markAsDownloaded();
    window.print();
}

async function confirmAttendance() {
    const payRef = document.getElementById('payment_ref').value;
    const errorDiv = document.getElementById('error-2');
    const btn = document.querySelector('#step-2 button:first-of-type');
    
    errorDiv.innerText = '';

    if (!payRef) {
        errorDiv.innerText = 'Payment confirmation is required.';
        return;
    }

    userData.payment_ref = payRef;
    btn.disabled = true;
    btn.innerText = 'Confirming...';

    const formData = new FormData();
    formData.append('phone', userData.phone);
    formData.append('name', userData.name);
    formData.append('payment_ref', userData.payment_ref);

    try {
        const response = await fetch(`api.php?action=confirm_attendance`, {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            document.getElementById('ticket-name').innerText = userData.name;
            document.getElementById('ticket-id').innerText = result.ticket_id;
            
            // Generate QR
            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(result.ticket_id + ' | ' + userData.name)}`;
            document.getElementById('qr-code-img').src = qrUrl;
            
            nextStep(3);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            errorDiv.innerText = result.message;
        }
    } catch (e) {
        errorDiv.innerText = 'Error saving confirmation. Please try again.';
    } finally {
        btn.disabled = false;
        btn.innerText = 'Confirm & Generate Ticket';
    }
}

function nextStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
    document.getElementById(`step-${step}`).classList.add('active');
}

function prevStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
    document.getElementById(`step-${step}`).classList.add('active');
}
</script>

</body>
</html>
