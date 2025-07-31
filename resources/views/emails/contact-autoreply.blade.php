<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank you for contacting ScienceVilla</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;line-height:1.6;color:#333}
        .container{max-width:600px;margin:0 auto;padding:20px}
        .header{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;padding:25px 20px;text-align:center;border-radius:8px 8px 0 0}
        .content{background:#f8f9fa;padding:30px;border-radius:0 0 8px 8px}
        .footer{text-align:center;margin-top:25px;font-size:12px;color:#666}
        .btn{display:inline-block;background:#4f46e5;color:#fff;padding:10px 22px;border-radius:5px;text-decoration:none;margin-top:15px}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🤝 We Received Your Message!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $data['name'] ?? 'there' }},</p>
            <p>Thanks for reaching out to <strong>ScienceVilla</strong>. Our support team has received your message and will get back to you via email or WhatsApp within the next 24 hours.</p>
            <p>Meanwhile, feel free to explore our <a href="{{ url('/'.$data['country'].'/courses') }}">latest courses</a> or follow us on our social channels for updates.</p>
            <p>If your query is urgent, you can also call us at <strong>+91&nbsp;8146327155</strong>.</p>
            <a class="btn" href="{{ url('/'.$data['country'].'/home') }}">Visit ScienceVilla</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} ScienceVilla • All rights reserved</p>
        </div>
    </div>
</body>
</html>
