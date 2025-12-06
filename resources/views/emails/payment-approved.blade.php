<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Disetujui</title>
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
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #4C3DBF;
            padding: 20px;
            margin: 30px 0;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666666;
            font-size: 14px;
        }
        .info-value {
            font-weight: 700;
            color: #1a1a1a;
            font-size: 14px;
        }
        .success-badge {
            background-color: #E8F5E9;
            color: #2E7D32;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 0;
            font-weight: 600;
        }
        .success-icon {
            font-size: 30px;
            margin-bottom: 10px;
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
        .footer-links {
            margin-top: 15px;
        }
        .footer-link {
            color: #4C3DBF;
            text-decoration: none;
            font-size: 13px;
            margin: 0 10px;
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            .info-row {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>


<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Gateway to PTN</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">Halo, {{ $userName }}!</div>
            
            <div class="message">
                Kabar baik! 🎉 Pembayaran Anda telah <strong>diverifikasi dan disetujui</strong> oleh tim kami.
            </div>

            <div class="success-badge">
                <div class="success-icon">✓</div>
                Pembayaran Berhasil Disetujui
            </div>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Order ID : </span>
                    <span class="info-value">{{ $payment->order_id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Bundle : </span>
                    <span class="info-value">{{ ucfirst($payment->bundle_type) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jumlah Dibayar : </span>
                    <span class="info-value">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status : </span>
                    <span class="info-value" style="color: #2E7D32;">Disetujui</span>
                </div>
            </div>

            <div class="message">
                <strong>Langkah Selanjutnya:</strong><br>
                • Tiket Anda sudah aktif dan siap digunakan<br>
                • Simpan email ini sebagai bukti pembelian<br>
                • Tunjukkan Order ID di atas saat check-in acara<br>
                • Jika ada pertanyaan, hubungi kami melalui kontak di bawah
            </div>

            <div class="message">
                Kami tunggu kehadiran Anda di acara Gateway to PTN! 🚀
            </div>

            <div class="message" style="font-size: 13px; color: #999;">
                Terima kasih telah mempercayai Gateway to PTN sebagai langkah awal menuju perguruan tinggi impian Anda.
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p class="footer-text"><strong>Gateway to PTN</strong></p>
            <p class="footer-text">by Indomie Enak</p>
            <div class="footer-links">
                <a href="#" class="footer-link">Website</a>
                <a href="https://instagram.com/fathanary" class="footer-link">Instagram</a>
                <a href="https://wa.me/6289521241213" class="footer-link">Contact Us</a>
            </div>
            <p class="footer-text" style="margin-top: 20px;">
                Email ini dikirim otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>