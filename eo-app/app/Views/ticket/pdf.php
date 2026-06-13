<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket: <?= esc($booking['title']); ?> - Elevate</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); 
            margin: 0; 
            padding: 30px 20px; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .ticket-wrapper { width: 100%; max-width: 900px; filter: drop-shadow(0 25px 30px rgba(15, 23, 42, 0.08)); }
        .ticket-container { 
            display: flex; 
            background: white; 
            border-radius: 28px; 
            position: relative; 
            overflow: hidden; 
            flex-direction: row; 
        }
        .ticket-left { padding: 48px; flex: 1; position: relative; display: flex; flex-direction: column; justify-content: space-between; }
        .brand { display: flex; justify-content: space-between; align-items: center; margin-bottom: 36px; }
        .brand h2 { 
            margin: 0; 
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700; 
            font-size: 26px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .badge { 
            background: #f0fdf4; 
            color: #166534; 
            padding: 8px 16px; 
            border-radius: 12px; 
            font-size: 11px; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            border: 1px solid #dcfce7; 
            display: inline-flex;
            align-items: center;
        }
        .event-title { margin-bottom: 36px; }
        .event-title label { display: block; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px; }
        .event-title h1 { margin: 0; font-size: 34px; font-weight: 800; color: #0f172a; line-height: 1.25; letter-spacing: -0.5px; }
        .grid-info { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 24px; 
            background: #f8fafc; 
            padding: 28px; 
            border-radius: 20px; 
            border: 1px solid #e2e8f0; 
            margin-bottom: 32px; 
        }
        .info-item label { display: block; color: #64748b; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px; }
        .info-item p { margin: 0; font-weight: 600; color: #1e293b; font-size: 15px; display: flex; align-items: center; gap: 10px; }
        .info-item p i { font-size: 16px; width: 20px; text-align: center; }
        .footer-note { font-size: 12px; color: #64748b; display: flex; align-items: flex-start; gap: 10px; font-weight: 500; line-height: 1.5; }
        .footer-note i { font-size: 14px; margin-top: 2px; shrink-0; }
        
        .ticket-right { 
            width: 290px; 
            background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%); 
            padding: 48px 32px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            border-left: 2px dashed #cbd5e1; 
            position: relative; 
        }
        .qr-section { text-align: center; width: 100%; }
        .qr-section label { display: block; color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 20px; }
        .qr-box { 
            background: white; 
            padding: 20px; 
            border-radius: 24px; 
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.04); 
            display: inline-block; 
            margin-bottom: 24px; 
            border: 1px solid #e2e8f0; 
        }
        .qr-box img { width: 150px; height: 150px; object-fit: contain; display: block; }
        .booking-id-label { display: block; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px;}
        .booking-id { font-family: 'Space Grotesk', monospace; font-size: 26px; font-weight: 700; color: #0f172a; margin: 0; letter-spacing: 1px;}
        
        .notch { position: absolute; width: 36px; height: 36px; background-color: #cbd5e1; border-radius: 50%; top: 50%; transform: translateY(-50%); z-index: 10; }
        .notch-left { left: -18px; }
        .notch-right { right: -18px; }
        
        @media (max-width: 768px) {
            body { padding: 16px; }
            .ticket-container { flex-direction: column; border-radius: 24px; }
            .ticket-left { padding: 32px; }
            .ticket-right { width: 100%; box-sizing: border-box; border-left: none; border-top: 2px dashed #cbd5e1; padding: 40px 32px; }
            .notch-left, .notch-right { display: none; }
            .grid-info { grid-template-columns: 1fr; gap: 24px; padding: 24px; }
            .event-title h1 { font-size: 28px; }
        }
        
        @media print {
            body { background: white !important; margin: 0; padding: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .ticket-wrapper { max-width: 100%; filter: none; }
            .ticket-container { box-shadow: none !important; border: 1px solid #cbd5e1; border-radius: 0; }
            .notch { display: none !important; }
            .ticket-right { background: white !important; }
            .grid-info { background: white !important; border-color: #cbd5e1 !important; }
            .badge { border-color: #166534 !important; }
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
                    <span class="badge"><i class="fa-solid fa-shield-check" style="margin-right: 6px;"></i>E-Ticket Resmi</span>
                </div>
                <div class="event-title">
                    <label>Nama Acara</label>
                    <h1><?= esc($booking['title']); ?></h1>
                </div>
                <div class="grid-info">
                    <div class="info-item">
                        <label>Nama Pemesan</label>
                        <p><i class="fa-regular fa-user" style="color: #64748b;"></i> <?= esc($booking['name']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Email Pemesan</label>
                        <p><i class="fa-regular fa-envelope" style="color: #64748b;"></i> <?= esc($booking['email']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Acara</label>
                        <p><i class="fa-regular fa-calendar" style="color: #334155;"></i> <?= esc($booking['date']); ?></p>
                    </div>
                    <div class="info-item">
                        <label>Lokasi Acara</label>
                        <p><i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> <?= esc($booking['location']); ?></p>
                    </div>
                </div>
                <div class="footer-note">
                    <i class="fa-solid fa-circle-check" style="color: #22c55e;"></i>
                    <span>Tiket ini sah dan diterbitkan oleh sistem Elevate. Harap tunjukkan kode QR saat masuk.</span>
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