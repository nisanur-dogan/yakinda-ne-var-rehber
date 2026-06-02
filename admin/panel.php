<?php
session_start();
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: ../login.php");
    exit;
}
require_once '../kullanici/db_connect.php';

// CRUD: Silme
if (isset($_GET['sil_id'])) {
    $sil_id = intval($_GET['sil_id']);
    $db->prepare("DELETE FROM isletmeler WHERE id = ?")->execute([$sil_id]);
    header("Location: panel.php"); exit;
}

// CRUD: Ekleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['isletme_ekle'])) {
    $ad = trim($_POST['ad']);
    $kat_id = intval($_POST['kategori_id']);
    $mah_id = intval($_POST['mahalle_id']);
    $hizmet = trim($_POST['hizmet_turu']);
    $saat = trim($_POST['calisma_saatleri']);
    $tel = trim($_POST['telefon']);
    $adres = trim($_POST['adres']);

    $ekle = $db->prepare("INSERT INTO isletmeler (ad, kategori_id, mahalle_id, hizmet_turu, calisma_saatleri, telefon, adres) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $ekle->execute([$ad, $kat_id, $mah_id, $hizmet, $saat, $tel, $adres]);
    header("Location: panel.php"); exit;
}

$kategoriler = $db->query("SELECT * FROM kategoriler")->fetchAll(PDO::FETCH_ASSOC);
$mahalleler_all = $db->query("SELECT m.*, ilc.ad as ilce_ad FROM mahalleler m JOIN ilceler ilc ON m.ilce_id = ilc.id ORDER BY m.ad ASC")->fetchAll(PDO::FETCH_ASSOC);

// Analiz Verileri
$analiz_raporu = $db->query("SELECT a.aranan_kelime, i.ad as il_ad, ilc.ad as ilce_ad, COUNT(a.id) as arama_sayisi FROM arama_istatistikleri a JOIN iller i ON a.il_id = i.id JOIN ilceler ilc ON a.ilce_id = ilc.id WHERE a.bulunan_isletme_sayisi = 0 GROUP BY a.aranan_kelime, a.il_id, a.ilce_id ORDER BY arama_sayisi DESC")->fetchAll(PDO::FETCH_ASSOC);

// Şehir bilgisini de analiz tablosuna çekebilmek için sorguyu INNER JOIN ile genişlettik
$isletmeler = $db->query("SELECT i.id, i.ad, i.hizmet_turu, i.tiklanma_sayisi, ill.ad as sehir_ad 
                          FROM isletmeler i 
                          JOIN mahalleler m ON i.mahalle_id = m.id 
                          JOIN ilceler ilc ON m.ilce_id = ilc.id 
                          JOIN iller ill ON ilc.il_id = ill.id 
                          ORDER BY i.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetim Konsolu - Yakında Ne Var?</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        body { background-color: #fafafa; }
        .ynv-admin-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.03);
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(99, 11, 38, 0.02);
        }
        .ynv-admin-header {
            background-color: var(--bordo-luxe) !important;
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            border-radius: 24px 24px 0 0 !important;
            padding: 16px 24px;
            border: none;
        }
        .ynv-table {
            font-size: 14px;
            color: var(--text-heading);
        }
        .ynv-table th {
            font-weight: 700;
            color: var(--text-heading);
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.8px;
            border-bottom: 2px solid #f1f5f9;
            padding: 14px 20px;
        }
        .ynv-table td {
            padding: 14px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .badge-tık {
            background-color: var(--bordo-bg);
            color: var(--bordo-luxe);
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
        }
        .ynv-admin-btn-danger {
            background-color: var(--bordo-luxe);
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 24px;
            border: none;
            transition: all 0.2s ease;
        }
        .ynv-admin-btn-danger:hover {
            background-color: var(--bordo-hover);
            color: white;
        }
    </style>
</head>
<body>
<div class="container my-5 ynv-animate">
    
    <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom" style="border-color: #f1f5f9 !important;">
        <h2 class="fw-bold text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; letter-spacing: -1px;">Yönetim Paneli</h2>
        <a href="logout.php" class="ynv-admin-btn-danger text-decoration-none">Oturumu Kapat</a>
    </div>

    <div class="row g-4">
        <!-- Sol Panel: Yeni Esnaf Kayıt Formu (CRUD) -->
        <div class="col-md-4">
            <div class="card ynv-admin-card border-0">
                <div class="card-header ynv-admin-header">Yeni Esnaf Kaydı</div>
                <div class="card-body p-4">
                    <form method="POST" action="panel.php">
                        <input type="hidden" name="isletme_ekle" value="1">
                        
                        <div class="mb-3">
                            <label class="ynv-label">İşletme Adı</label>
                            <input type="text" name="ad" class="form-control ynv-input w-100" required placeholder="Örn: Elite Çiçekçilik">
                        </div>
                        
                        <div class="mb-3">
                            <label class="ynv-label">Sektör Kategorisi</label>
                            <select name="kategori_id" class="form-select ynv-input" required>
                                <?php foreach($kategoriler as $k): ?>
                                    <option value="<?php echo $k['id']; ?>"><?php echo $k['ad']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="ynv-label">Mahalle / İlçe Konumu</label>
                            <select name="mahalle_id" class="form-select ynv-input" required>
                                <?php foreach($mahalleler_all as $m): ?>
                                    <option value="<?php echo $m['id']; ?>"><?php echo $m['ad'] . " / " . $m['ilce_ad']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="ynv-label">Hizmet Grubu</label>
                            <select name="hizmet_turu" class="form-select ynv-input">
                                <option value="Tamirat">Tamirat</option>
                                <option value="Çiçekçi">Çiçekçi</option>
                                <option value="Gıda">Gıda</option>
                                <option value="Kişisel Bakım">Kişisel Bakım</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="ynv-label">Çalışma Saatleri</label>
                            <input type="text" name="calisma_saatleri" class="form-control ynv-input" value="09:00 - 18:00">
                        </div>
                        
                        <div class="mb-3">
                            <label class="ynv-label">Telefon Numarası</label>
                            <input type="text" name="telefon" class="form-control ynv-input">
                        </div>
                        
                        <div class="mb-4">
                            <label class="ynv-label">Açık Adres</label>
                            <textarea name="adres" class="form-control ynv-input" rows="2" placeholder="Sokak, kapı numarası..."></textarea>
                        </div>
                        
                        <button type="submit" class="ynv-btn w-100 py-3" style="border-radius: 14px;">Esnafı Sisteme Tanımla</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sağ Panel: Analiz Tabloları -->
        <div class="col-md-8">
            <!-- Talep Analiz Raporu -->
            <div class="card ynv-admin-card border-0 mb-4">
                <div class="card-header ynv-admin-header" style="background-color: #475569 !important;">Bölgesel Talep & İşletme Genişletme Analizi</div>
                <div class="card-body p-0">
                    <table class="table ynv-table m-0">
                        <thead>
                            <tr>
                                <th>Aranan Terim</th>
                                <th>Bölge</th>
                                <th>Arama Frekansı</th>
                                <th>Durum Analizi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($analiz_raporu as $an): ?>
                                <tr>
                                    <td class="fw-semibold" style="color: var(--bordo-luxe);"><?php echo htmlspecialchars($an['aranan_kelime']); ?></td>
                                    <td><?php echo htmlspecialchars($an['il_ad']); ?> / <?php echo htmlspecialchars($an['ilce_ad']); ?></td>
                                    <td class="fw-medium"><?php echo $an['arama_sayisi']; ?> Kez</td>
                                    <td class="text-danger fw-semibold" style="font-size: 13px;">Bölgede veri eksik!</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Popülerlik & Yönetim Tablosu (Şehir Sütunu Eklendi) -->
            <div class="card ynv-admin-card border-0">
                <div class="card-header ynv-admin-header">Popülerlik ve Ziyaret Analizi</div>
                <div class="card-body p-0">
                    <table class="table ynv-table m-0">
                        <thead>
                            <tr>
                                <th>Esnaf Adı</th>
                                <th>Şehir</th>
                                <th>Sektör Türü</th>
                                <th>İnceleme Sayısı</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($isletmeler as $is): ?>
                                <tr>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($is['ad']); ?></td>
                                    <!-- Yeni Şehir Kategorisi Sütun Verisi -->
                                    <td class="fw-medium text-secondary" style="font-size: 13.5px;"><?php echo htmlspecialchars($is['sehir_ad']); ?></td>
                                    <td><span class="text-secondary small fw-medium"><?php echo htmlspecialchars($is['hizmet_turu']); ?></span></td>
                                    <td><span class="badge-tık"><?php echo $is['tiklanma_sayisi']; ?> Tık</span></td>
                                    <td>
                                        <a href="panel.php?sil_id=<?php echo $is['id']; ?>" class="text-danger small text-decoration-none fw-bold" onclick="return confirm('Bu esnaf kaydını sistemden kalıcı olarak düşürmek istediğinize emin misiniz?')">Kaydı Sil</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-5 pt-3 border-top" style="border-color: #f1f5f9 !important;">
        <a href="../index.php" class="text-decoration-none small text-secondary fw-medium">← Canlı Platform Arayüzünü Gör</a>
    </div>
</div>
</body>
</html>