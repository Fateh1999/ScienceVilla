<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Quick Inquiry</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { background: white; padding: 10px; border-radius: 4px; margin-top: 5px; border-left: 4px solid #3b82f6; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
        .priority { background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 New Quick Inquiry</h1>
            <p>ScienceVilla - Free Demo Request</p>
        </div>
        
        <div class="content">
            <div class="priority">
                <strong>⚡ Priority:</strong> This is a quick inquiry for a free demo session. Please respond within 24 hours!
            </div>
            
            <p>A potential student has submitted a quick inquiry form and is interested in booking a free demo session.</p>
            
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
            
            @if(!empty($data['message']))
            <div class="field">
                <div class="label">💬 Additional Message:</div>
                <div class="value">{{ $data['message'] }}</div>
            </div>
            @endif
            
            <div class="field">
                <div class="label">🕒 Submitted At:</div>
                <div class="value">{{ now()->format('F j, Y \a\t g:i A') }}</div>
            </div>
            
            <div class="field">
                <div class="label">📋 Next Steps:</div>
                <div class="value">
                    • Contact the student within 24 hours<br>
                    • Schedule a free demo session<br>
                    • Provide personalized study plan<br>
                    • Explain 24×7 doubt support
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was automatically generated from the ScienceVilla quick inquiry form.</p>
            <p><strong>Remember:</strong> Quick response leads to higher conversion rates!</p>
        </div>
    </div>
</body>
</html>
