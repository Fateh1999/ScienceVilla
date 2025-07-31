<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { background: white; padding: 10px; border-radius: 4px; margin-top: 5px; border-left: 4px solid #667eea; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 New Contact Form Submission</h1>
            <p>ScienceVilla - Educational Platform</p>
        </div>
        
        <div class="content">
            <p>You have received a new message through the contact form on your website.</p>
            
            <div class="field">
                <div class="label">👤 Full Name:</div>
                <div class="value">{{ $data['name'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">📧 Email:</div>
                <div class="value">{{ $data['email'] }}</div>
            </div>
            
            @if(!empty($data['phone']))
            <div class="field">
                <div class="label">📞 Phone:</div>
                <div class="value">{{ $data['phone'] }}</div>
            </div>
            @endif
            
            <div class="field">
                <div class="label">💬 Message:</div>
                <div class="value">{{ $data['message'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">🕒 Submitted At:</div>
                <div class="value">{{ now()->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was automatically generated from the ScienceVilla contact form.</p>
            <p>Please respond to the customer within 24 hours for the best experience.</p>
        </div>
    </div>
</body>
</html>
