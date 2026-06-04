<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket: <?= esc($booking['title']); ?> - Elevate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; color: #1f2937; }
        .ticket-wrapper { width: 100%; max-width: 850px; }
        .ticket-container { display: flex; background: white; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); position: relative; overflow: hidden; flex-direction: row; }
        .ticket-left { padding: 40px; flex: 1; position: relative; }
        .brand { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
        .brand h2 { margin: 0; background: linear-gradient(to right, #2563eb, #9333ea); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 900; font-size: 24px; display: flex; align-items: center; gap: 8px; }
        .badge { background: #eff6ff; color: #1d4ed8; padding: 6px 16px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border: 1px solid #bfdbfe; }
        .event-title { margin-bottom: 30px; }
        .event-title label { display: block; color: #9ca3af; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .event-title h1 { margin: 0; font-size: 36px; font-weight: 900; color: #111827; line-height: 1.2; }
        .grid-info { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; background: #f8fafc; padding: 24px; border-radius: 16px; border: 1px solid #f1f5f9; margin-bottom: 24px; }
        .info-item label { display: block; color: #9ca3af; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .info-item p { margin: 0; font-weight: 700; color: #1f2937; font-size: 15px; display: flex; align-items: center; gap: 8px; }
        .footer-note { font-size: 12px; color: #9ca3af; display: flex; align-items: center; gap: 8px; font-weight: 600; }
        .ticket-right { width: 280px; background-color: #eff6ff; padding: 40px 24px; display: flex; flex-direction: column; align-items: center; justify-content: center; border-left: 2px dashed #cbd5e1; position: relative; }
        .qr-section { text-align: center; }
        .qr-section label { display: block; color: #6b7280; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; }
        .qr-box { background: white; padding: 12px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); display: inline-block; margin-bottom: 16px; border: 1px solid #e2e8f0; }
        .qr-box img { width: 140px; height: 140px; object-fit: contain; }
        .booking-id-label { display: block; color: #9ca3af; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;}
        .booking-id { font-family: monospace; font-size: 24px; font-weight: 900; color: #111827; margin: 0; letter-spacing: 2px;}
        .notch { position: absolute; width: 40px; height: 40px; background-color: #f9fafb; border-radius: 50%; top: 50%; transform: translateY(-50%); z-index: 10; }
        .notch-left { left: -20px; box-shadow: inset -3px 0 5px rgba(0,0,0,0.05); }
        .notch-right { right: -20px; box-shadow: inset 3px 0 5px rgba(0,0,0,0.05); }
        @media (max-width: 768px) {
            .ticket-container { flex-direction: column; }
            .ticket-right { width: 100%; border-left: none; border-top: 2px dashed #cbd5e1; padding: 30px 20px; }
            .notch-left, .notch-right { display: none; }
            .grid-info { grid-template-columns: 1fr; gap: 16px; }
        }
        @media print {
            body { background: white !important; margin: 0; padding: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .ticket-wrapper { max-width: 100%; }
            .ticket-container { box-shadow: none !important; border: 1px solid #e5e7eb; border-radius: 0; }
            .notch { display: none !important; }
            .ticket-right { background-color: white !important; }
            .grid-info { background: white !important; border-color: #e5e7eb !important; }
            .badge { border-color: #93c5fd !important; }
        }
    </style>
</head>
<body>

    <div class="ticket-wrapper">
        <div class="ticket-container">
            <div class="notch notch-left"></div>

            <div class="ticket-left">
                <div class="brand">
                    <h2><i class="fa-solid fa-ticket"></i> Elevate</h2>
                    <span class="badge">E-Ticket Resmi</span>
                </div>
                <div class="event-title">
                    <label>Nama Acara</label>
                    <h1><?= esc($booking['title']); ?></h1>
                </div>
                <div class="grid-info">
                    <div class="info-item">
                        <label>Nama Pemesan</label>
                        <p><i class="fa-regular fa-user" style="color: #6b7280;"></i> <?= esc($booking['name']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Email Pemesan</label>
                        <p><i class="fa-regular fa-envelope" style="color: #6b7280;"></i> <?= esc($booking['email']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Acara</label>
                        <p><i class="fa-regular fa-calendar" style="color: #2563eb;"></i> <?= esc($booking['date']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Lokasi Acara</label>
                        <p><i class="fa-solid fa-location-dot" style="color: #e11d48;"></i> <?= esc($booking['location']); ?></p>
                    </div>
                </div>
                <div class="footer-note">
                    <i class="fa-solid fa-circle-check" style="color: #10b981;"></i>
                    Tiket ini sah dan diterbitkan oleh sistem Elevate. Harap tunjukkan kode QR saat masuk.
                </div>
            </div>

            <div class="ticket-right">
                <div class="notch notch-right"></div>
                <div class="qr-section">
                    <label>Pindai di Pintu Masuk</label>
                    <div class="qr-box">
                        <img src="data:image/png;base64,<?= $qrImage; ?>" alt="QR Code Tiket">
                    </div>
                    <span class="booking-id-label">Booking ID</span>
                    <p class="booking-id">#<?= str_pad($booking['id'], 6, '0', STR_PAD_LEFT); ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if(session()->getFlashdata('success')): ?>
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '<?= session()->getFlashdata('success'); ?>', showConfirmButton: false, timer: 3000 });
        <?php endif; ?>
    </script>
</body>
</html>