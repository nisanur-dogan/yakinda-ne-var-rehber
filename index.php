<?php
session_start(); 
require_once 'kullanici/db_connect.php';

$aranan = isset($_GET['arama']) ? trim($_GET['arama']) : '';
$il_id = isset($_GET['il_id']) ? intval($_GET['il_id']) : 0;
$ilce_id = isset($_GET['ilce_id']) ? intval($_GET['ilce_id']) : 0;
$mahalle_id = isset($_GET['mahalle_id']) ? intval($_GET['mahalle_id']) : 0;
$hizmet_turu = isset($_GET['hizmet_turu']) ? trim($_GET['hizmet_turu']) : '';

$isletmeler = array();
$oneriler = array();
$uyari_mesaji = "";
$arama_koku = $aranan;
$ek_arama_terimleri = array();

if (!empty($aranan)) {
    $aranan_lc = mb_strtolower($aranan, 'UTF-8');
    
    // Akıllı Sektörel Eş anlamlı Sözlüğü
    if (strpos($aranan_lc, 'lokanta') !== false || strpos($aranan_lc, 'restoran') !== false || strpos($aranan_lc, 'kebap') !== false || strpos($aranan_lc, 'kafe') !== false || strpos($aranan_lc, 'kahve') !== false || strpos($aranan_lc, 'yemek') !== false) {
        $ek_arama_terimleri[] = 'Gıda';
    }
    if (strpos($aranan_lc, 'berber') !== false || strpos($aranan_lc, 'kuaför') !== false || strpos($aranan_lc, 'güzellik') !== false || strpos($aranan_lc, 'makas') !== false) {
        $ek_arama_terimleri[] = 'Kişisel Bakım';
    }
    if (strpos($aranan_lc, 'çiçek') !== false || strpos($aranan_lc, 'peyzaj') !== false || strpos($aranan_lc, 'gül') !== false) {
        $ek_arama_terimleri[] = 'Çiçekçi';
    }
    if (strpos($aranan_lc, 'kundura') !== false || strpos($aranan_lc, 'ayakkabı') !== false || strpos($aranan_lc, 'terzi') !== false || strpos($aranan_lc, 'tamir') !== false) {
        $ek_arama_terimleri[] = 'Tamirat';
    }
    if (strpos($aranan_lc, 'anahtar') !== false || strpos($aranan_lc, 'çilingir') !== false) {
        $ek_arama_terimleri[] = 'Anahtarcı';
    }

    $ekler = array('cı', 'ci', 'cu', 'cü', 'çı', 'çi', 'çu', 'çü', 'luk', 'lük', 'lık', 'lik', 'cısı', 'cisi', 'çi', 'çisi');
    foreach ($ekler as $ek) {
        $aranan_len = mb_strlen($aranan, 'UTF-8');
        $ek_len = mb_strlen($ek, 'UTF-8');
        if ($aranan_len > $ek_len && mb_substr($aranan_lc, -$ek_len, null, 'UTF-8') === $ek) {
            $arama_koku = mb_substr($aranan, 0, $aranan_len - $ek_len, 'UTF-8');
            break;
        }
    }
}

// --- ŞEHİRLERİN YANINDAKİ DÜKKAN SAYILARINI PHP İLE HESAPLAMA ---
$sehirler_query = $db->query("SELECT * FROM iller ORDER BY ad ASC")->fetchAll(PDO::FETCH_ASSOC);
$sehirler = array();

foreach ($sehirler_query as $sehir) {
    $count_sql = "SELECT COUNT(i.id) as toplam FROM isletmeler i JOIN mahalleler m ON i.mahalle_id = m.id JOIN ilceler ilc ON m.ilce_id = ilc.id WHERE ilc.il_id = ?";
    $count_params = array($sehir['id']);
    
    if (!empty($aranan)) {
        $count_sql .= " AND (i.ad LIKE ? OR i.hizmet_turu LIKE ? OR i.ad LIKE ? OR i.hizmet_turu LIKE ?";
        $count_params[] = "%$aranan%"; $count_params[] = "%$aranan%";
        $count_params[] = "%$arama_koku%"; $count_params[] = "%$arama_koku%";
        foreach ($ek_arama_terimleri as $terim) {
            $count_sql .= " OR i.hizmet_turu LIKE ? OR i.ad LIKE ?";
            $count_params[] = "%$terim%"; $count_params[] = "%$terim%";
        }
        $count_sql .= ")";
    }
    if (!empty($hizmet_turu)) {
        $count_sql .= " AND i.hizmet_turu = ?";
        $count_params[] = $hizmet_turu;
    }
    
    $count_stmt = $db->prepare($count_sql);
    $count_stmt->execute($count_params);
    $count_res = $count_stmt->fetch(PDO::FETCH_ASSOC);
    
    $sehir['display_ad'] = $sehir['ad'] . " (" . $count_res['toplam'] . ")";
    $sehirler[] = $sehir;
}

// --- ANA ARAMA SORGUSU ---
if (!empty($aranan) || $il_id > 0) {
    $sql = "SELECT i.*, k.ad as kat_ad, m.ad as mah_ad, ilc.ad as ilce_ad, ilc.il_id 
            FROM isletmeler i 
            JOIN kategoriler k ON i.kategori_id = k.id
            JOIN mahalleler m ON i.mahalle_id = m.id
            JOIN ilceler ilc ON m.ilce_id = ilc.id
            WHERE 1=1";
    
    $query_params = array();
    
    if (!empty($aranan)) {
        $sql .= " AND (i.ad LIKE ? OR i.hizmet_turu LIKE ? OR i.ad LIKE ? OR i.hizmet_turu LIKE ?";
        $query_params[] = "%$aranan%"; $query_params[] = "%$aranan%";
        $query_params[] = "%$arama_koku%"; $query_params[] = "%$arama_koku%";
        foreach ($ek_arama_terimleri as $terim) {
            $sql .= " OR i.hizmet_turu LIKE ? OR i.ad LIKE ?";
            $query_params[] = "%$terim%"; $query_params[] = "%$terim%";
        }
        $sql .= ")";
    }
    
    if ($il_id > 0) { $sql .= " AND ilc.il_id = ?"; $query_params[] = $il_id; }
    if ($ilce_id > 0) { $sql .= " AND m.ilce_id = ?"; $query_params[] = $ilce_id; }
    if ($mahalle_id > 0) { $sql .= " AND i.mahalle_id = ?"; $query_params[] = $mahalle_id; }
    if (!empty($hizmet_turu)) { $sql .= " AND i.hizmet_turu = ?"; $query_params[] = $hizmet_turu; }

    $stmt = $db->prepare($sql);
    $stmt->execute($query_params);
    $isletmeler = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $sonuc_sayisi = count($isletmeler);

if (!empty($aranan) && $il_id > 0 && $ilce_id > 0) {
    $istatistik_stmt = $db->prepare("INSERT INTO arama_istatistikleri (aranan_kelime, il_id, ilce_id, bulunan_isletme_sayisi) VALUES (?, ?, ?, ?)");
    $istatistik_stmt->execute(array($aranan, $il_id, $ilce_id, $sonuc_sayisi));
}
    if ($sonuc_sayisi == 0 && $ilce_id > 0) {
        $uyari_mesaji = "Aradığınız kriterlere uygun esnaf tam bu lokasyonda bulunamadı. Şehrinizdeki en yakın alternatif esnaflar listeleniyor:";
        
        $oneri_sql = "SELECT i.*, k.ad as kat_ad, m.ad as mah_ad, ilc.ad as ilce_ad 
                      FROM isletmeler i 
                      JOIN kategoriler k ON i.kategori_id = k.id
                      JOIN mahalleler m ON i.mahalle_id = m.id
                      JOIN ilceler ilc ON m.ilce_id = ilc.id
                      WHERE ilc.il_id = ? AND ilc.id != ? AND (i.ad LIKE ? OR i.hizmet_turu LIKE ? OR i.ad LIKE ?)";
        
        $oneri_stmt = $db->prepare($oneri_sql);
        $oneri_stmt->execute(array($il_id, $ilce_id, "%$aranan%", "%$aranan%", "%$arama_koku%"));
        $oneriler = $oneri_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$ilceler_all = $db->query("SELECT * FROM ilceler ORDER BY ad ASC")->fetchAll(PDO::FETCH_ASSOC);
$mahalleler_all = $db->query("SELECT * FROM mahalleler ORDER BY ad ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yakında Ne Var? - Yerel İşletme Rehberi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>



<div class="ynv-hero">
    <div class="container">
        <h1>Yakında Ne Var?</h1>
        <p>Aradığınız yerel hizmetler, dükkanlar ve tüm esnaflar tek bir konsolda.</p>
    </div>
</div>

<div class="container">
    <div class="card ynv-search-box">
        <form method="GET" action="index.php" class="row g-3">
            <div class="col-md-3">
                <label class="ynv-label">Hizmet veya Esnaf</label>
                <!-- autocomplete="off" ekleyerek tarayıcı geçmişinin açılmasını kodla engelledik -->
<input type="text" name="arama" class="form-control ynv-input" value="<?php echo htmlspecialchars($aranan); ?>" placeholder="Örn: Çiçekçi, Kundura..." autocomplete="off">
            </div>
            
            <div class="col-md-2">
                <label class="ynv-label">Şehir</label>
                <select name="il_id" id="il_select" class="form-select ynv-input" required>
                    <option value="">Seçiniz...</option>
                    <?php foreach($sehirler as $s): ?>
                        <option value="<?php echo $s['id']; ?>" <?php echo $il_id == $s['id'] ? 'selected' : ''; ?>>
                            <?php echo $s['display_ad']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="ynv-label">İlçe</label>
                <select name="ilce_id" id="ilce_select" class="form-select ynv-input" disabled>
                    <option value="0">Tüm İlçeler</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="ynv-label">Mahalle</label>
                <select name="mahalle_id" id="mahalle_select" class="form-select ynv-input" disabled>
                    <option value="0">Tüm Mahalleler</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="ynv-label">Sektörel Kategori</label>
                <select name="hizmet_turu" class="form-select ynv-input">
                    <option value="">Tüm Sektörler</option>
                    <option value="Tamirat" <?php echo $hizmet_turu == 'Tamirat' ? 'selected' : ''; ?>>Tamirat / Onarım</option>
                    <option value="Çiçekçi" <?php echo $hizmet_turu == 'Çiçekçi' ? 'selected' : ''; ?>>Çiçekçi / Peyzaj</option>
                    <option value="Gıda" <?php echo $hizmet_turu == 'Gıda' ? 'selected' : ''; ?>>Gıda / Restoran</option>
                    <option value="Kişisel Bakım" <?php echo $hizmet_turu == 'Kişisel Bakım' ? 'selected' : ''; ?>>Kişisel Bakım</option>
                </select>
            </div>

            <div class="col-12 text-end mt-4">
                <button type="submit" class="ynv-btn">Kayıtları Listele</button>
            </div>
        </form>
        
        <div class="mt-4 pt-2 border-top text-center" style="border-color: #f1f5f9 !important;">
            <span class="small fw-semibold text-secondary me-2">Popüler Aramalar:</span>
            <a href="index.php?arama=çiçekçi&il_id=1" class="ynv-quick-tag">Çiçekçi</a>
            <a href="index.php?arama=kundura&il_id=1" class="ynv-quick-tag">Ayakkabı Tamiri</a>
            <a href="index.php?arama=berber&il_id=1" class="ynv-quick-tag">Berber & Kuaför</a>
            <a href="index.php?arama=lokanta&il_id=1" class="ynv-quick-tag">Restoran & Kafe</a>
            <a href="index.php?arama=çilingir&il_id=1" class="ynv-quick-tag">Anahtarcı</a>
        </div>
    </div>

    <!-- Sonuç Kartları Paneli -->
    <div class="row mt-4">
        
        <?php if (count($isletmeler) == 0 && (!empty($aranan) || $il_id > 0)): ?>
            <div class="col-12 text-center py-4 ynv-animate">
                <p class="fw-semibold fs-5" style="color: var(--bordo-luxe) !important;">Seçilen kriterlere ve lokasyona uygun kayıtlı doğrudan esnaf bulunamadı.</p>
            </div>
        <?php endif; ?>

       <?php if (!empty($uyari_mesaji)): ?>
            <div class="col-12 ynv-animate mb-4">
                <div class="ynv-alert-luxe p-3 bg-white shadow-sm rounded-3">
                    <span> <?php echo $uyari_mesaji; ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Ana Bölge İşletmeleri Listesi -->
        <?php foreach ($isletmeler as $index => $is): ?>
            <div class="col-md-4 mb-4 ynv-animate" style="animation-delay: <?php echo $index * 0.04; ?>s;">
                <div class="ynv-card">
                    <div>
                        <div class="ynv-card-badge"><?php echo htmlspecialchars($is['hizmet_turu']); ?></div>
                        <div class="ynv-card-title"><?php echo htmlspecialchars($is['ad']); ?></div>
                        <div class="ynv-card-text">Saatler:  <?php echo htmlspecialchars($is['calisma_saatleri']); ?></div>
                        <div class="ynv-card-text">Konum:  <?php echo htmlspecialchars($is['ilce_ad']); ?> / <?php echo htmlspecialchars($is['mah_ad']); ?></div>
                    </div>
                    <a href="detay.php?id=<?php echo $is['id']; ?>" class="ynv-card-btn">İletişim & Detayları İncele</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Önerilen Çevre Esnaflar -->
        <?php foreach ($oneriler as $index => $on): ?>
            <div class="col-md-4 mb-4 ynv-animate" style="animation-delay: <?php echo $index * 0.04; ?>s;">
                <div class="ynv-card ynv-card-oneri">
                    <div>
                        <div class="ynv-card-badge">Çevre Bölge Alternatifi</div>
                        <div class="ynv-card-title"><?php echo htmlspecialchars($on['ad']); ?></div>
                        <div class="ynv-card-text"> Saatler: <?php echo htmlspecialchars($on['calisma_saatleri']); ?></div>
                        <div class="ynv-card-text"> Konum: <?php echo htmlspecialchars($on['ilce_ad']); ?> / <?php echo htmlspecialchars($on['mah_ad']); ?></div>
                    </div>
                    <a href="detay.php?id=<?php echo $on['id']; ?>" class="ynv-card-btn">İletişim & Detayları İncele</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Tanıtım Adımları -->
    <div class="row ynv-steps-section">
        <div class="col-12 text-center mb-5">
            <h3 class="fw-bold text-dark" style="font-size:26px;">Çevrenizdeki Esnaflara Ulaşmak Çok Kolay</h3>
            <p class="text-muted small">Rehberimiz tamamen yerel işletmelerin dijital görünürlüğünü artırmak için tasarlandı.</p>
        </div>
        <div class="col-md-4 mb-3">
            <div class="ynv-step-box">
                <div class="ynv-step-number">I</div>
                <h5 class="fw-bold text-dark fs-6">Konum Seçimi Yapın</h5>
                <p class="text-muted small m-0">Şehir, ilçe và mahalle hiyerarşisini kullanarak tam olarak aradığınız bölgeyi işaretleyin.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="ynv-step-box">
                <div class="ynv-step-number">II</div>
                <h5 class="fw-bold text-dark fs-6">Hizmeti Filtreleyin</h5>
                <p class="text-muted small m-0">Akıllı sözlük altyapımız sayesinde ne yazarsanız yazın doğru sektörü anında eşleştirelim.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="ynv-step-box">
                <div class="ynv-step-number">III</div>
                <h5 class="fw-bold text-dark fs-6">Esnafla İletişime Geçin</h5>
                <p class="text-muted small m-0">Çalışma saatlerini ve iletişim numaralarını inceleyerek doğrudan dükkana ulaşın.</p>
            </div>
        </div>
    </div>
</div>

<script>
const ilceler = <?php echo json_encode($ilceler_all); ?>;
const mahalleler = <?php echo json_encode($mahalleler_all); ?>;
const isletmeler_listesi = <?php echo json_encode($db->query("SELECT i.*, ilc.il_id FROM isletmeler i JOIN mahalleler m ON i.mahalle_id = m.id JOIN ilceler ilc ON m.ilce_id = ilc.id")->fetchAll(PDO::FETCH_ASSOC)); ?>;

const ilSelect = document.getElementById('il_select');
const ilceSelect = document.getElementById('ilce_select');
const mahalleSelect = document.getElementById('mahalle_select');
const aramaInput = document.querySelector('input[name="arama"]');
const kategoriSelect = document.querySelector('select[name="hizmet_turu"]');

const urlParams = new URLSearchParams(window.location.search);
const selectedIlce = urlParams.get('ilce_id') || 0;
const selectedMahalle = urlParams.get('mahalle_id') || 0;

function sehirSayilariniGuncelle() {
    const arananKelime = aramaInput.value.trim().toLowerCase();
    const secilenKategori = kategoriSelect.value;
    let aramaKoku = arananKelime;
    const ekler = ['cı', 'ci', 'cu', 'cü', 'çı', 'çi', 'çu', 'çü', 'luk', 'lük', 'lık', 'lik', 'çi'];
    for (let ek of ekler) {
        if (arananKelime.endsWith(ek) && arananKelime.length > ek.length) {
            aramaKoku = arananKelime.substring(0, arananKelime.length - ek.length);
            break;
        }
    }

    Array.from(ilSelect.options).forEach(option => {
        if (!option.value) return;
        const ilId = option.value;
        const orijinalSehirAdi = option.textContent.split('(')[0].trim();
        const uyanIsletmeler = isletmeler_listesi.filter(is => {
            if (is.il_id != ilId) return false;
            if (secilenKategori && is.hizmet_turu !== secilenKategori) return false;
            if (arananKelime) {
                const isim = is.ad.toLowerCase();
                const tur = is.hizmet_turu.toLowerCase();
                let ekSektor = "";
                if (arananKelime.includes("lokanta") || arananKelime.includes("restoran") || arananKelime.includes("kafe") || arananKelime.includes("kahve")) ekSektor = "gıda";
                if (arananKelime.includes("berber") || arananKelime.includes("kuaför")) ekSektor = "kişisel bakım";
                if (arananKelime.includes("çiçek")) ekSektor = "çiçekçi";
                if (arananKelime.includes("kundura") || arananKelime.includes("ayakkabı") || arananKelime.includes("tamir")) ekSektor = "tamirat";
                if (arananKelime.includes("anahtar") || arananKelime.includes("çilingir")) ekSektor = "anahtarcı";
                return isim.includes(arananKelime) || tur.includes(arananKelime) || isim.includes(aramaKoku) || tur.includes(aramaKoku) || (ekSektor && tur.includes(ekSektor));
            }
            return true;
        });
        option.textContent = orijinalSehirAdi + " (" + uyanIsletmeler.length + ")";
    });
}

aramaInput.addEventListener('input', sehirSayilariniGuncelle);
kategoriSelect.addEventListener('change', sehirSayilariniGuncelle);

function updateIlce() {
    const ilId = ilSelect.value;
    ilceSelect.innerHTML = '<option value="0">Tüm İlçeler</option>';
    mahalleSelect.innerHTML = '<option value="0">Tüm Mahalleler</option>';
    mahalleSelect.disabled = true;
    if (ilId) {
        const filtered = ilceler.filter(i => i.il_id == ilId);
        filtered.forEach(i => {
            const opt = document.createElement('option'); opt.value = i.id; opt.textContent = i.ad;
            if(i.id == selectedIlce) opt.selected = true;
            ilceSelect.appendChild(opt);
        });
        ilceSelect.disabled = false;
        if(selectedIlce > 0) updateMahalle();
    } else { ilceSelect.disabled = true; }
}

function updateMahalle() {
    const ilceId = ilceSelect.value;
    mahalleSelect.innerHTML = '<option value="0">Tüm Mahalleler</option>';
    if (ilceId && ilceId != 0) {
        const filtered = mahalleler.filter(m => m.ilce_id == ilceId);
        filtered.forEach(m => {
            const opt = document.createElement('option'); opt.value = m.id; opt.textContent = m.ad;
            if(m.id == selectedMahalle) opt.selected = true;
            mahalleSelect.appendChild(opt);
        });
        mahalleSelect.disabled = false;
    } else { mahalleSelect.disabled = true; }
}

ilSelect.addEventListener('change', updateIlce);
ilceSelect.addEventListener('change', updateMahalle);
if(ilSelect.value) { updateIlce(); }
sehirSayilariniGuncelle();
window.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.shiftKey && e.keyCode === 88) { 
        e.preventDefault();
        window.location.href = 'admin/panel.php';
    }
});

window.addEventListener('beforeunload', function() {
    localStorage.setItem('scrollPosition', window.scrollY);
});

window.addEventListener('load', function() {
    if (localStorage.getItem('scrollPosition') !== null) {
        window.scrollTo({
            top: parseInt(localStorage.getItem('scrollPosition')),
            behavior: 'instant' 
        });
        localStorage.removeItem('scrollPosition');
    }
});
</script>
</body>
</html>