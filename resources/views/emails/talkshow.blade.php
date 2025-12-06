<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pendaftaran</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #4C3DBF; text-align: center;">Selamat! Pendaftaran Berhasil</h2>
        
        <p>Halo <strong>{{ $data['nama_lengkap'] }}</strong>,</p>
        
        <p>Terima kasih telah mendaftar di acara <strong>Talkshow Inspiratif Gateway To PTN</strong>.</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>Jenis Tiket:</strong> {{ $data['jenis_tiket'] }}</p>
            <p style="margin: 5px 0;"><strong>Kode Tiket:</strong> {{ $data['kode_tiket'] }}</p>
            <p style="margin: 5px 0;"><strong>Tanggal:</strong> 4 Oktober 2025</p>
            <p style="margin: 5px 0;"><strong>Lokasi:</strong> {{ $data['jenis_tiket'] == 'Talkshow Offline' ? 'Gedung Sate Bandung' : 'Zoom Meeting (Link menyusul)' }}</p>
        </div>

        <p>Harap simpan email ini sebagai bukti pendaftaran ulang di lokasi.</p>
        
        <br>
        <p>Salam Sukses,<br>Panitia Gateway to PTN</p>
    </div>
</body>
</html>