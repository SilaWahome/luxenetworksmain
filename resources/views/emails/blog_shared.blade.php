<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Blog Post from Luxenet</title>
    <style>
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            background-color: #f4f4f5;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .email-header {
            background-color: #000080; /* Navy */
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            color: #FFD700; /* Gold */
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h2 {
            color: #000080;
            font-size: 22px;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .email-body p {
            line-height: 1.6;
            color: #555;
            font-size: 16px;
        }
        .blog-image {
            width: 100%;
            height: auto;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .cta-container {
            text-align: center;
            margin: 30px 0;
        }
        .cta-button {
            display: inline-block;
            background-color: #FFD700; /* Gold */
            color: #000080 !important; /* Navy */
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            background-color: #e6c200;
        }
        .email-footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #888;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>LUXENET</h1>
        </div>
        
        <div class="email-body">
            <h2>{{ $blog->title }}</h2>
            
            @if($blog->image)
                <img src="{{ url('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="blog-image">
            @endif
            
            <p>
                Hi there,
            </p>
            <p>
                We have just published a new article that we think you'll love. Click the button below to read the full story on our platform.
            </p>
            
            <div class="cta-container">
                @php
                    $url = route('blogs.show', $blog->slug ?? $blog->id);
                    if(isset($subscriberId) && $subscriberId) {
                        $url .= '?sub=' . $subscriberId;
                    }
                @endphp
                <a href="{{ $url }}" class="cta-button">Read Full Article</a>
            </div>
            
            <p>
                Best regards,<br>
                <strong>The Luxenet Team</strong>
            </p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Luxenet. All rights reserved.</p>
            <p>You are receiving this email because you registered on our platform via Google.</p>
        </div>
    </div>
</body>
</html>
