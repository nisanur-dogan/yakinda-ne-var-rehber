<?php
// PHP kod bloğu (veritabanı bağlantısı, sayaç artırma ve esnaf çekme) en üstte aynen kalıyor.
require_once 'kullanici/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$isletme = false;

if ($id > 0) {
    $sayac = $db->prepare("UPDATE isletmeler SET tiklanma_sayisi = tiklanma_sayisi + 1 WHERE id = ?");
    $sayac->execute(array($id));

    $stmt = $db->prepare("SELECT i.*, ilc.ad as ilce_ad, m.ad as mah_ad, ill.ad as il_ad FROM isletmeler i JOIN mahalleler m ON i.mahalle_id = m.id JOIN ilceler ilc ON m.ilce_id = ilc.id JOIN iller ill ON ilc.il_id = ill.id WHERE i.id = ?");
    $stmt->execute(array($id));
    $isletme = $stmt->fetch(PDO::FETCH_ASSOC);
}
if (!$isletme) { die("Kayıt bulunamadı."); }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($isletme['ad']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body style="background-color: #fafafa;">

<div class="container ynv-detail-container ynv-animate">
    <!-- Eski Hizalanmış Düzgün Div Yapısı Geri Getirildi -->
    <div class="ynv-detail-card">
        
        <!-- Esnaf Adı ve Sektör Rozeti -->
        <h2 class="fw-bold text-dark mb-2" style="font-size: 32px; letter-spacing: -1px !important;">
            <?php echo htmlspecialchars($isletme['ad']); ?>
        </h2>
        <div class="ynv-card-badge mb-4">
            <?php echo htmlspecialchars($isletme['hizmet_turu']); ?>
        </div>
        
        <!-- Hizalanmış Bilgi Listesi -->
        <div class="ynv-detail-item">
            <span class="ynv-detail-label">İletişim Hattı</span>
            <span class="ynv-detail-value fw-bold text-dark"><?php echo htmlspecialchars($isletme['telefon']); ?></span>
        </div>
        
        <div class="ynv-detail-item">
            <span class="ynv-detail-label">Mesai Saatleri</span>
            <span class="ynv-detail-value"><?php echo htmlspecialchars($isletme['calisma_saatleri']); ?></span>
        </div>
        
        <div class="ynv-detail-item">
            <span class="ynv-detail-label">Bölge Bilgisi</span>
            <span class="ynv-detail-value">
                <?php echo htmlspecialchars($isletme['il_ad']); ?> / 
                <?php echo htmlspecialchars($isletme['ilce_ad']); ?> / 
                <?php echo htmlspecialchars($isletme['mah_ad']); ?>
            </span>
        </div>
        
        <div class="ynv-detail-item">
            <span class="ynv-detail-label">Adres</span>
            <span class="ynv-detail-value text-secondary" style="max-width: 320px;">
                <?php echo htmlspecialchars($isletme['adres']); ?>
            </span>
        </div>
        
        <div class="ynv-detail-item bg-light p-3 rounded-4 mt-3" style="border-bottom: none;">
            <span class="ynv-detail-label text-dark fw-semibold" style="opacity:0.7;">Sistem Popülerlik Skoru</span>
            <span class="ynv-detail-value text-dark fw-bold">
                <?php echo $isletme['tiklanma_sayisi']; ?> Görüntülenme
            </span>
        </div>
        
        <!-- Beğendiğin Derin Bordo Renkteki "Arama Ekranına Dön" Butonu -->
        <div class="mt-4 pt-2">
            <a href="index.php" class="ynv-btn d-block text-center text-decoration-none shadow-sm">
                Arama Ekranına Dön
            </a>
        </div>
        
    </div>
</div>

</body>
</html>