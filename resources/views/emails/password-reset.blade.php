<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #4C3DBF 0%, #7B68EE 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            margin: 0;
            font-weight: 700;
        }
        .email-body {
            padding: 40px 30px;
            color: #333333;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        .message {
            font-size: 15px;
            line-height: 1.8;
            color: #666666;
            margin-bottom: 30px;
        }
        .code-box {
            background: linear-gradient(135deg, #4C3DBF 0%, #7B68EE 100%);
            padding: 30px;
            text-align: center;
            border-radius: 12px;
            margin: 30px 0;
        }
        .code {
            font-size: 48px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 8px;
            margin: 0;
        }
        .code-label {
            color: #ffffff;
            font-size: 14px;
            margin-top: 10px;
            opacity: 0.9;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px 20px;
            border-radius: 5px;
            margin: 30px 0;
        }
        .warning-text {
            font-size: 13px;
            color: #856404;
            margin: 0;
            line-height: 1.6;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }
        .info-text {
            font-size: 14px;
            color: #666666;
            margin: 5px 0;
            line-height: 1.8;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .footer-text {
            font-size: 13px;
            color: #999999;
            line-height: 1.6;
            margin: 5px 0;
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            .code {
                font-size: 36px;
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container"> 
        <div class="email-header"> 
            <h1>Gateway to PTN</h1>
        </div>
 
        <div class="email-body">
            <div class="greeting">Halo, {{ $userName }}!</div>
            
            <div class="message">
                Kami menerima permintaan untuk mereset password akun Anda. Gunakan kode verifikasi di bawah ini untuk melanjutkan proses reset password:
            </div>

            <div class="code-box">
                <div class="code">{{ $code }}</div>
                <div class="code-label">Kode Verifikasi Anda</div>
            </div>

            <div class="warning-box">
                <p class="warning-text">
                    ⚠️ <strong>Penting:</strong> Kode ini hanya berlaku selama {{ $expiresIn }} menit. Jangan bagikan kode ini kepada siapapun!
                </p>
            </div>

            <div class="info-box">
                <p class="info-text"><strong>Jika Anda tidak merasa melakukan permintaan ini:</strong></p>
                <p class="info-text">• Abaikan email ini</p>
                <p class="info-text">• Password Anda tetap aman</p>
                <p class="info-text">• Pertimbangkan untuk mengubah password jika Anda merasa akun terancam</p>
            </div>

            <div class="message" style="font-size: 13px; color: #999; margin-top: 30px;">
                Email ini dikirim secara otomatis dari sistem Gateway to PTN. Untuk keamanan akun Anda, jangan membalas email ini atau membagikan kode verifikasi kepada siapapun.
            </div>
        </div>
 
        <div class="email-footer">
            <p class="footer-text"><strong>Gateway to PTN</strong></p>
            <p class="footer-text">by Indomie Enak</p>
            <p class="footer-text" style="margin-top: 20px;">
                © 2025 Gateway to PTN. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>