# Yakında Ne Var? - Dijital İşletme & Esnaf Rehberi Platformu 

Sektör esnaflarının ve kurumsal işletmelerin; şehir, ilçe ve kategori bazlı ilişkisel veritabanı algoritmalarıyla filtrelenmesini, listelenmesini ve idari olarak yönetimini sağlayan dinamik bir PHP & MySQL (Full-Stack) web platformudur.

##  Öne Çıkan Teknik Özellikler

- **İlişkisel Arama ve Filtreleme Motoru:** Kullanıcıların esnaf sorgularını hafifletmek ve performansı artırmak amacıyla kurgulanmış, şehir ve kategori parametrelerine bağlı dinamik SQL sorgu mimarisi.
- **Modüler Kullanıcı Arayüzü (`kullanici/`):** İşletmelerin harita konum verilerini, çalışma saatlerini, detaylı hizmet tanımlarını ve iletişim kanallarını listeleyen modüler detay sayfası (`detay.php`).
- **Güvenli Yönetim (Admin) Paneli (`admin/`):** Yetkilendirilmiş admin girişi (`login.php`) aracılığıyla sisteme yeni işletme ekleme, hatalı bilgileri revize etme, silme ve onay bekleyen esnaf başvurularını veritabanı seviyesinde yönetme (CRUD).
- **Responsive Arayüz:** CSS mimarisi ve Bootstrap grid sistemi kullanılarak tamamen mobil uyumlu (responsive) olarak geliştirilmiş premium koyu tema tasarımı.

##  Proje Klasör Yapısı

- `/admin` - Yönetici kimlik doğrulama, işletme onaylama ve rehber CRUD işlemlerini barındıran idari kontrol paneli.
- `/kullanici` - Şehir/kategori filtreleme arayüzü ve işletme detay modüllerinin yer aldığı müşteri katmanı.
- `/includes` - Veritabanı PDO bağlantı mimarisini (`config.php`) ve global yardımcı fonksiyonları (`functions.php`) içeren çekirdek dizin.
- `/assets` - Portfolyo genel tasarımıyla uyumlu pastel kırmızı, bordo ve beyaz tonlarındaki CSS stilleri ile özel font yapılandırmaları.
- `/uploads` & `/php2_proje_resim` - İşletmelere ait logoların ve kapak görsellerinin dinamik olarak saklandığı medya klasörleri.

##  Teknolojik Stack

- **Backend:** PHP (Oturum Yönetimi, PDO Güvenli SQL Mimarisi)
- **Veritabanı:** MySQL / phpMyAdmin (İlişkisel Veritabanı Tasarımı)
- **Frontend:** HTML5, CSS3, JavaScript (ES6+), Bootstrap 5.3
- **Tasarım & UI/UX:** Adobe Illustrator (Özel Vektörel İkon ve Logo Tasarımları)



1. Proje ana klasörünü yerel PHP sunucunuzun (XAMPP / WampServer / Laragon) `htdocs` veya `www` kök dizinine aktarın:
   ```bash
   git clone [https://github.com/nisanur-dogan/yakinda-ne-var-rehber.git](https://github.com/nisanur-dogan/yakinda-ne-var-rehber.git)
