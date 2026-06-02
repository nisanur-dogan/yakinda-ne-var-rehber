<?php
session_start();
require_once 'kullanici/db_connect.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
    header("Location: admin/panel.php");
    exit;
}

$hata = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici = trim($_POST['username']);
    $sifre = trim($_POST['password']);

    if ($kullanici === 'admin' && $sifre === '2026') {
        $_SESSION['admin_login'] = true;
        header("Location: admin/panel.php");
        exit;
    } else {
        $hata = "Geçersiz kullanıcı adı veya şifre girdiniz.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Girişi - Yakında Ne Var?</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #fafafa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ynv-login-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.02);
            border-radius: 32px;
            box-shadow: 0 40px 90px rgba(99, 11, 38, 0.05);
            width: 100%;
            max-width: 420px;
            padding: 45px;
            animation: ynvFadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
    </style>
</head>
<body>

<div class="ynv-login-card">
    <div class="text-center mb-4">
        <h2 style="font-family: 'Cinzel', serif !important; color: var(--bordo-luxe); font-weight: 700; font-size: 24px; letter-spacing: 2px; text-transform: uppercase; margin: 0;">
            Yönetim Girişi
        </h2>
        <p class="text-muted small mt-2 m-0">Güvenli erişim için giriş yapın.</p>
    </div>

    <?php if (!empty($hata)): ?>
        <div class="alert p-3 mb-3 small fw-semibold text-center rounded-3" style="background-color: #fff1f2; color: var(--bordo-luxe); border: 1px solid #ffe4e6;">
            <?php echo $hata; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label class="ynv-label">Yönetici Adı</label>
            <input type="text" name="username" class="form-control ynv-input" required autocomplete="off" placeholder="Kullanıcı adı">
        </div>

        <div class="mb-4">
            <label class="ynv-label">Erişim Şifresi</label>
            <input type="password" name="password" class="form-control ynv-input" required placeholder="••••••">
        </div>

        <button type="submit" class="ynv-btn w-100 py-3" style="border-radius: 14px;">Giriş Yap</button>
    </form>
</div>
</body>
</html>