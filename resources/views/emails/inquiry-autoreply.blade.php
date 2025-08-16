<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank you for your inquiry</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;line-height:1.6;color:#333}
        .container{max-width:600px;margin:0 auto;padding:20px}
        .header{background:linear-gradient(135deg,#3b82f6 0%,#8b5cf6 100%);color:#fff;padding:25px 20px;text-align:center;border-radius:8px 8px 0 0}
        .content{background:#f8f9fa;padding:30px;border-radius:0 0 8px 8px}
        .footer{text-align:center;margin-top:25px;font-size:12px;color:#666}
        .btn{display:inline-block;background:#3b82f6;color:#fff;padding:10px 22px;border-radius:5px;text-decoration:none;margin-top:15px}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Thanks for reaching out!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $data['name'] ?? 'there' }},</p>
            <p>We appreciate your interest in booking a free demo session with <strong>Fateh Science Villa</strong>. Our counsellor will connect with you soon via email and WhatsApp to confirm details and schedule the session.</p>
            <p>In the meantime, you can explore our popular courses or chat with us on WhatsApp for any quick questions.</p>
            <a class="btn" href="{{ url('/'.$data['country'].'/courses') }}">View Courses</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Fateh Science Villa • All rights reserved</p>
        </div>
    </div>
</body>
</html>
