<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Login | Luxenet</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy-deep: #0a1118;
            --navy-card: #111b27;
            --gold-primary: #b8962a;
            --gold-glow: rgba(184, 150, 42, 0.2);
        }
        body { 
            font-family: 'Outfit', sans-serif;
            background-color: var(--navy-deep); 
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
            background: linear-gradient(135deg, rgba(10, 17, 24, 0.8), rgba(184, 150, 42, 0.1)), url('{{ asset('images/cloud-shaped-heads-collage.jpg') }}');
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
            background: radial-gradient(circle at center, transparent, var(--navy-deep));
        }
        .visual-content {
            position: relative;
            z-index: 10;
            max-width: 500px;
        }
        .auth-form-side {
            width: 550px;
            background: var(--navy-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border-left: 1px solid rgba(255, 255, 255, 0.05);
        }
        .form-container {
            width: 100%;
            max-width: 380px;
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
            border-color: var(--gold-primary);
            background: rgba(184, 150, 42, 0.05);
            box-shadow: 0 0 0 4px var(--gold-glow);
        }
        .input-field:focus + i {
            color: var(--gold-primary);
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
            background: var(--gold-primary);
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
            color: var(--gold-primary);
            text-decoration: none;
            font-weight: 700;
        }
        .error-hint {
            color: #ff5f5f;
            font-size: 12px;
            margin-top: 6px;
            margin-left: 4px;
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
                <div style="background: var(--gold-glow); border: 1px solid var(--gold-primary); padding: 4px 12px; border-radius: 6px; font-size: 10px; font-weight: 800; display: inline-block; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold-primary);">Secure Access</div>
                <h2 style="font-size: 48px; font-weight: 800; line-height: 1.1; margin-bottom: 20px;">Welcome Back to the Network.</h2>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; line-height: 1.6;">Access your ISP command center and manage your micro-nodes from anywhere in the world.</p>
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
                    <h2>Sign In</h2>
                    <p>Enter your credentials to access the portal.</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <input type="email" name="email" class="input-field" placeholder="admin@isp.com" required value="{{ old('email') }}">
                        <i class="fas fa-envelope"></i>
                        @error('email') <div class="error-hint">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <label class="input-label">Password</label>
                            <a href="#" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--gold-primary); margin-bottom: 8px;">Forgot?</a>
                        </div>
                        <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                        <i class="fas fa-lock"></i>
                        @error('password') <div class="error-hint">{{ $message }}</div> @enderror
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px;">
                        <input type="checkbox" name="remember" id="remember" style="accent-color: var(--gold-primary);">
                        <label for="remember" style="font-size: 13px; color: rgba(255,255,255,0.6); cursor: pointer;">Remember this session</label>
                    </div>

                    <button type="submit" class="submit-btn">Authorize Session</button>
                </form>

                <div class="footer-link">
                    New to the network? <a href="{{ route('register') }}">Initialize Account</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
