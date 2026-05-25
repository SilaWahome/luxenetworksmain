<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration | Tech Meet & Greet</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --event-bg: #060d14;
            --event-accent: #b8962a;
            --event-accent-glow: rgba(184, 150, 42, 0.2);
        }
        body { 
            font-family: 'Outfit', sans-serif;
            background-color: var(--event-bg); 
            color: white;
            overflow-x: hidden;
        }
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            position: relative;
        }
        .auth-visual {
            flex: 1;
            background: linear-gradient(135deg, rgba(6, 13, 20, 0.9), rgba(184, 150, 42, 0.15)), url('{{ asset('images/cloud-shaped-heads-collage.jpg') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
        }
        .auth-visual::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, transparent, var(--event-bg));
        }
        .visual-content {
            position: relative;
            z-index: 10;
            max-width: 500px;
        }
        .auth-form-side {
            width: 550px;
            background: var(--event-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border-left: 1px solid rgba(255, 255, 255, 0.05);
        }
        .form-container {
            width: 100%;
            max-width: 420px;
        }
        .brand-logo {
            margin-bottom: 40px;
        }
        .form-header h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }
        .form-header p {
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 40px;
            font-size: 15px;
        }
        .input-group {
            margin-bottom: 24px;
            position: relative;
        }
        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            font-size: 14px;
            transition: all 0.3s;
        }
        .input-field {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 14px 14px 14px 48px;
            color: white;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: var(--event-accent);
            background: rgba(184, 150, 42, 0.05);
            box-shadow: 0 0 0 4px var(--event-accent-glow);
        }
        .input-field:focus + i {
            color: var(--event-accent);
        }
        .input-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 8px;
            margin-left: 4px;
        }
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: var(--event-accent);
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            box-shadow: 0 10px 30px rgba(184, 150, 42, 0.2);
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 15px 35px rgba(184, 150, 42, 0.3);
        }
        .footer-link {
            text-align: center;
            margin-top: 32px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.4);
        }
        .footer-link a {
            color: var(--event-accent);
            text-decoration: none;
            font-weight: 700;
        }

        @media (max-width: 1024px) {
            .auth-visual { display: none; }
            .auth-form-side { width: 100%; border: none; }
        }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <!-- Visual Side -->
        <div class="auth-visual">
            <div class="visual-content">
                <div style="background: var(--event-accent-glow); border: 1px solid var(--event-accent); padding: 4px 12px; border-radius: 6px; font-size: 10px; font-weight: 800; display: inline-block; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--event-accent);">Community Event</div>
                <h2 style="font-size: 48px; font-weight: 800; line-height: 1.1; margin-bottom: 20px;">Connect with Tech Visionaries.</h2>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; line-height: 1.6;">Secure your spot at the next Luxenet Tech Meet & Greet. Networking, Innovation, and Growth.</p>
            </div>
        </div>

        <!-- Form Side -->
        <div class="auth-form-side">
            <div class="form-container">
                <div class="brand-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo-light.png') }}" alt="Luxenet" style="height: 36px;">
                    </a>
                </div>

                <div class="form-header">
                    <h2>Event Registration</h2>
                    <p>Tell us a bit about yourself to join.</p>
                </div>

                @if(session('success'))
                    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 16px; border-radius: 14px; margin-bottom: 30px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-check-circle mr-2"></i> {!! session('success') !!}
                    </div>
                @endif

                <div style="background: rgba(184, 150, 42, 0.15); border: 1px solid var(--event-accent); padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 24px; text-align: center; box-shadow: 0 0 15px rgba(184, 150, 42, 0.2); line-height: 1.4;" class="animate-pulse">
                    <span style="color: var(--event-accent); font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; display: block; margin-bottom: 4px;"><i class="fas fa-satellite-dish mr-1"></i> Live Registration Instance</span>
                    {{ $activeInstance }}
                </div>

                <form action="{{ route('meet-greet.apply') }}" method="POST">
                    @csrf
                    
                    <div class="input-group">
                        <label class="input-label">Full Name</label>
                        <input type="text" name="name" class="input-field" placeholder="John Doe" required value="{{ old('name') }}">
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <input type="email" name="email" class="input-field" placeholder="john@example.com" required value="{{ old('email') }}">
                        <i class="fas fa-envelope"></i>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Phone Number</label>
                        <input type="text" name="phone" class="input-field" placeholder="+254 700 000 000" required value="{{ old('phone') }}">
                        <i class="fas fa-phone-alt"></i>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Target Event Instance</label>
                        <input type="text" class="input-field" style="background: rgba(184, 150, 42, 0.05); color: var(--event-accent); font-weight: 700; border-color: rgba(184, 150, 42, 0.3);" value="{{ $activeInstance }}" readonly>
                        <input type="hidden" name="event" value="{{ $activeInstance }}">
                        <i class="fas fa-calendar-check" style="color: var(--event-accent);"></i>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Organization (Optional)</label>
                        <input type="text" name="organization" class="input-field" placeholder="Company or Institution" value="{{ old('organization') }}">
                        <i class="fas fa-building"></i>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Why do you want to join?</label>
                        <textarea name="motivation" class="input-field" style="height: 100px; resize: none; padding-top: 14px;" placeholder="Share your motivation...">{{ old('motivation') }}</textarea>
                        <i class="fas fa-comment-alt" style="top: 24px;"></i>
                    </div>

                    <button type="submit" class="submit-btn">Request Invitation</button>
                </form>

                <div class="footer-link" style="margin-top: 40px; padding-top: 24px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                    <p style="margin-bottom: 12px; font-weight: 500;">Already registered?</p>
                    <a href="{{ url('Techmeet/index.php') }}" class="submit-btn" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: none; display: block; text-decoration: none; text-align: center;">
                        <i class="fas fa-ticket-alt mr-2"></i> Get My Ticket
                    </a>
                </div>

                <div class="footer-link">
                    Back to <a href="{{ route('meet-greet') }}">Event Page</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
