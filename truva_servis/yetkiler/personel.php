<?php 
class personel extends ortak {
    public function anasayfa() {
        FONK->goruntu("personel", "anasayfa", ["title"=>"Ana Sayfa"]);
    }
    public function ayarlar() {
        FONK->goruntu("personel", "ayarlar", ["title"=>"Ayarlar"]);
    }
    public function musteriKaydet() {
        FONK->goruntu("personel", "musteriKaydet", ["title"=>"Müşteri Kaydet"]);
    }
    public function yeniRandevuOlustur() {
        FONK->goruntu("personel", "yeniRandevuOlustur", ["title"=>"Yeni Randevu Oluştur"]);
    }
    public function yeniServisKaydiAc() {
        FONK->goruntu("personel", "yeniServisKaydiAc", ["title"=>"Yeni Servis Kaydı Ac"]);
    }
    public function servisKayitlari() {
        FONK->goruntu("personel", "servisKayitlari", ["title"=>"Servis Kayıtları"]);
    }
    public function gelenRandevu() {
        FONK->goruntu("personel", "gelenRandevu", ["title"=>"Gelen Randevu"]);
    }
    public function yeniStokEkle() {
        FONK->goruntu("personel","yeniStokEkle", ["title"=>"Yeni Stok Ekle"]);
    }
    public function post_personel_ayarlar_guncelle(){
        $sonuc = [];
        $ulke = $_POST["ulke"] ?? "";
        $cadde = $_POST["cadde"] ?? "";
        $sokak = $_POST["sokak"] ?? ""; 
        $daire  = $_POST["daire"] ?? "";
        $ad = $_POST["ad"] ?? "";
        $soyad = $_POST["soyad"] ?? "";
        $telefon = $_POST["telefon"] ?? "";
        $email = $_POST["email"] ?? "";
        $sifre = $_POST["sifre"] ?? "";
        $sifre_tekrar = $_POST["sifre_tekrar"] ?? "";
        $ilce = $_POST["ilce"] ?? "";
        $mahalle = $_POST["mahalle"] ?? "";
        $sehir = $_POST["sehir"] ?? "";


        if ($sifre !== $sifre_tekrar) {
            $sonuc["islem"] = "error";
            $sonuc["mesaj"] = "Şifreler uyuşmuyor!";
            echo json_encode($sonuc);
            return;
        }

        $kullanici_id = $_SESSION["id"]; // Oturumdan kullanıcı ID'si alınır

        // E-posta başka bir kullanıcıya ait mi? 
        if (!empty($email)) {
            $$email_kontrol = DB->row("SELECT * FROM kullanicilar WHERE email = :email AND id != :id", [
            "email" => $email,
            "id" => $kullanici_id
        ]);
    
            if ($email_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu e-posta adresi başka bir kullanıcıya ait!";
                echo json_encode($sonuc);
                return;
            }
        }

        if (!empty($telefon)) {
            $telefon_kontrol = DB->row("SELECT * FROM kullanicilar WHERE telefon = :telefon AND id != :id", [
            "telefon" => $telefon,
            "id" => $kullanici_id
        ]);

            if ($telefon_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu telefon numarası başka bir kullanıcıya ait!";
                echo json_encode($sonuc);
                return;
            }
        }
        // Mevcut veriyi çek
        $mevcutVeri = DB->row("
             SELECT 
                a.id, a.sehir, a.ilce, a.mahalle, a.cadde, a.sokak, a.daire, a.ulke
             FROM 
                kullanicilar k
             INNER JOIN 
                adresler a ON a.id = k.adres_id
             WHERE 
                k.id = :id
                 ", ["id" => $kullanici_id]       
        );


        $adresVeriler = [
            "ulke" => !empty($ulke) ? $ulke : ($mevcutVeri["ulke"] ?? ""),
            "sehir" => !empty($sehir) ? $sehir : ($mevcutVeri["sehir"] ?? ""),
            "ilce" => !empty($ilce) ? $ilce : ($mevcutVeri["ilce"] ?? ""),
            "mahalle" => !empty($mahalle) ? $mahalle : ($mevcutVeri["mahalle"] ?? ""),
            "cadde" => !empty($cadde) ? $cadde : ($mevcutVeri["cadde"] ?? ""),
            "sokak" => !empty($sokak) ? $sokak : ($mevcutVeri["sokak"] ?? ""),
            "daire" => !empty($daire) ? $daire : ($mevcutVeri["daire"] ?? "")
        ];
        


        if ($mevcutVeri && isset($mevcutVeri["id"])) {
            // Güncelleme işlemi
            $adresVeriler["id"] = $mevcutVeri["id"];
            $adres_sorgu = "UPDATE adresler SET 
                ulke = :ulke, 
                sehir = :sehir, 
                ilce = :ilce, 
                mahalle = :mahalle, 
                cadde = :cadde, 
                sokak = :sokak, 
                daire = :daire 
                WHERE id = :id";
            DB->query($adres_sorgu, $adresVeriler);
        } else {
            // Yeni kayıt işlemi
            $adres_sorgu = "INSERT INTO adresler 
            (ulke, sehir, ilce, mahalle, cadde, sokak, daire)
            VALUES
            (:ulke, :sehir, :ilce, :mahalle, :cadde, :sokak, :daire)";
            DB->query($adres_sorgu, $adresVeriler);
    
            // Yeni adresin ID'sini al
            $adres_id = DB->lastInsertId();

            // Kullanıcıya bu adresi bağla
            DB->query("UPDATE kullanicilar SET adres_id = :adres_id WHERE id = :id", [
                "adres_id" => $adres_id,
                "id" => $kullanici_id
            ]);
        }

        $mevcut = DB->row("SELECT ad, soyad, telefon, email, sifre FROM kullanicilar WHERE id = :id", ["id" => $kullanici_id]);
        $guncel_ad = !empty($ad) ? $ad : $mevcut["ad"];
        $guncel_soyad = !empty($soyad) ? $soyad : $mevcut["soyad"];
        $guncel_telefon = !empty($telefon) ? $telefon : $mevcut["telefon"];
        $guncel_email = !empty($email) ? $email : $mevcut["email"];
        $guncel_sifre = !empty($sifre) ? $sifre : $mevcut["sifre"];

        $veriler = [
            "ad" => $guncel_ad,
            "soyad" => $guncel_soyad,
            "telefon" => $guncel_telefon,
            "email" => $guncel_email,
            "sifre" => $guncel_sifre,
            "id" => $kullanici_id
        ];

        $kullanici_sorgu = "UPDATE kullanicilar SET 
                    ad = :ad, 
                    soyad = :soyad, 
                    telefon = :telefon, 
                    email = :email, 
                    sifre = :sifre 
                    WHERE id = :id";

        DB->query($kullanici_sorgu, $veriler);

        $_SESSION["adsoyad"] = $guncel_ad . " " . $guncel_soyad;

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);

    }
    public function post_personel_musteri_kaydet(){
        DB->query("SET time_zone = '+03:00'");
        $sonuc = [];

        $ad = $_POST["ad"];
        $soyad = $_POST["soyad"];
        $email = $_POST["email"];
        $telefon = $_POST["telefon"];
        $tc_no = $_POST["tc_no"];
        $sifre = $_POST["sifre"];
        $sifre_tekrar = $_POST["sifre_tekrar"];

        if (!empty($email)) {
            $email_kontrol = DB->row("SELECT * FROM kullanicilar WHERE email = :email", [
                "email" => $email,
            ]);
    
            if ($email_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu e-posta adresi başka bir kullanıcıya ait!";
                echo json_encode($sonuc);
                return;
            }
        }
        if (!empty($tc_no)) {
            $tc_kontrol = DB->row("SELECT * FROM kullanicilar WHERE tc_no = :tc_no", [
                "tc_no" => $tc_no,
            ]);
    
            if ($tc_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu T.C. Kimlik No başka bir kullanıcıya ait!";
                echo json_encode($sonuc);
                return;
            }
        }
        if (!$this->tc_kimlik_dogrula($tc_no)) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Geçerli bir T.C. Kimlik No giriniz!";
                echo json_encode($sonuc);
                return;
            }

            
        if (!empty($telefon)) {
            $telefon_kontrol = DB->row("SELECT * FROM kullanicilar WHERE telefon = :telefon", [
                "telefon" => $telefon,
            ]);

            if ($telefon_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu telefon numarası başka bir kullanıcıya ait!";
                echo json_encode($sonuc);
                return;
            }
        }

        $kullaniciVerileri = [
            "ad" => $ad,
            "soyad" => $soyad,
            "email" => $email,
            "telefon" => $telefon,
            "sifre" => $sifre,
            "rol" => "musteri",
            "tc_no" => $tc_no
        ];

        $kullaniciSorgu = "INSERT INTO kullanicilar (
        ad, soyad, email, telefon, sifre, rol, tc_no
        ) VALUES (
        :ad, :soyad, :email, :telefon, :sifre, :rol, :tc_no)";
        DB->query($kullaniciSorgu, $kullaniciVerileri);

        // kullanici ID'sini al
        $kullanici_id = DB->lastInsertId();

        $musteriVerileri = [
            "kullanici_id" => $kullanici_id
        ];

         $musteriSorgu = "INSERT INTO musteriler (
        kullanici_id
        ) VALUES (
        :kullanici_id)";
        DB->query($musteriSorgu, $musteriVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);
    }
    public function post_urun_bilgisi() {
        DB->query("SET time_zone = '+03:00'");
        $seri_no = $_POST["seri_no"] ?? "";

        // Gruptaki bilgileri çekiyoruz ve toplam adet hesaplıyoruz
        $urun = DB->row("SELECT seri_no, stok_kategori, yedek_parca_ad, marka, SUM(adet) AS toplam_adet, birim_fiyat, kdv_orani, satis_fiyati 
            FROM stoklar 
            WHERE seri_no = :seri_no 
            GROUP BY seri_no, stok_kategori, yedek_parca_ad, marka, birim_fiyat, kdv_orani, satis_fiyati", 
            [
                "seri_no" => $seri_no
            ]
        );

        if ($urun) {
            echo json_encode([
                "islem" => "success",
                "veri" => $urun
            ]);
        } else {
            echo json_encode([
                "islem" => "error",
                "mesaj" => "Ürün bulunamadı"
            ]);
        }
    }
    public function post_stok_dusur() {
        DB->query("SET time_zone = '+03:00'");
        $seri_no = $_POST["seri_no"] ?? "";

        // İçinde adet olan ilk kaydı bul
        $urun = DB->row("SELECT id FROM stoklar WHERE seri_no = :seri_no AND adet > 0 ORDER BY id ASC LIMIT 1", [
            "seri_no" => $seri_no
        ]);

        if (!$urun) {
            echo json_encode(["islem" => "warning", "mesaj" => "Stokta ürün kalmadı veya kayıt bulunamadı"]);
            return;
        }

        DB->query("UPDATE stoklar SET adet = adet - 1, guncellenme_tarihi = NOW() WHERE id = :id", [
            "id" => $urun["id"]
        ]);

        echo json_encode(["islem" => "success", "mesaj" => "Stoktan 1 adet düşüldü"]);
    }
    public function post_personel_randevu_al() {
        DB->query("SET time_zone = '+03:00'");
        $sonuc = [];

        $musteri_id = $_POST["musteri_id"];
        $traktor_id = $_POST["traktor_id"];
        $sorun_tanimi = $_POST["sorun_tanimi"];
        $randevu_tarih = $_POST["randevu_tarih"];
        $randevu_saat = $_POST["randevu_saat"];

        // 1. Müşterinin kullanıcı_id'sini bul
        $kullanici = DB->row("SELECT kullanici_id FROM musteriler WHERE id = :id", [
            "id" => $musteri_id
        ]);

        if (!$kullanici) {
            $sonuc["islem"] = "error";
            $sonuc["mesaj"] = "Müşteri bulunamadı.";
            echo json_encode($sonuc);
            return;
        }

        $kullanici_id = $kullanici["kullanici_id"];

        // 2. Kullanıcının adres_id'si var mı kontrol et
        $kullaniciBilgi = DB->row("SELECT adres_id FROM kullanicilar WHERE id = :id", [
            "id" => $kullanici_id
        ]);

        if (!$kullaniciBilgi || empty($kullaniciBilgi["adres_id"])) {
            $sonuc["islem"] = "error";
            $sonuc["mesaj"] = "Bu müşterinin kullanıcı hesabına ait adres bilgisi bulunamadı. Önce adres kaydedin.";
            echo json_encode($sonuc);
            return;
        }

        if (!empty($randevu_saat)) {
            $randevu_kontrol = DB->row("SELECT * FROM randevular WHERE randevu_saat = :randevu_saat", [
                "randevu_saat" => $randevu_saat,
            ]);
    
            if ($randevu_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Randevu Saati Dolu!";
                echo json_encode($sonuc);
                return;
            }
        }

        // Adres varsa randevu kaydını yap
        $randevuVerileri = [
            "traktor_id" => $traktor_id,
            "sorun_tanimi" => $sorun_tanimi,
            "randevu_tarih" => $randevu_tarih,
            "randevu_saat" => $randevu_saat,
            "musteri_id" => $musteri_id,
            "durum" => "Onaylandı"
        ];

        $randevuSorgu = "INSERT INTO randevular (
            traktor_id, sorun_tanimi, randevu_tarih, randevu_saat, musteri_id, durum
        ) VALUES (
            :traktor_id, :sorun_tanimi, :randevu_tarih, :randevu_saat, :musteri_id, :durum
        )";

        DB->query($randevuSorgu, $randevuVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Randevu başarıyla alındı.";
        echo json_encode($sonuc);
    }
    public function post_personel_servis_kaydi_ekle(){
        DB->query("SET time_zone = '+03:00'");
        $sonuc = [];

        $musteri_id = $_POST["musteri_id"];
        $traktor_id = $_POST["traktor_id"];
        $servis_turu = $_POST["servis_turu"];
        $gelis_tarihi = $_POST["gelis_tarihi"];
        $aciklama = $_POST["aciklama"];
        $garanti = $_POST["garanti"];

        $servisVerileri = [
            "musteri_id" => $musteri_id,
            "traktor_id" => $traktor_id,
            "servis_turu" => $servis_turu,
            "gelis_tarihi" => $gelis_tarihi,
            "aciklama" => $aciklama,
            "garanti" => $garanti
        ];

        $servisSorgu = "INSERT INTO ariza_kayitlari (
        musteri_id, traktor_id, servis_turu, gelis_tarihi, aciklama, garanti
        ) VALUES (
        :musteri_id, :traktor_id, :servis_turu, :gelis_tarihi, :aciklama, :garanti)";
        DB->query($servisSorgu, $servisVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);

    }
    public function post_servis_kaydi_stok_ekle() {
        DB->query("SET time_zone = '+03:00'");
        $sonuc = [];

        if ($_POST["islem"] == "stok_bul") {
            $seri_no = trim($_POST["seri_no"]);
            $adet = intval($_POST["adet"]);

            $sorgu = DB->row("
                SELECT 
                s.id,
                s.seri_no,
                s.marka,
                SUM(s.adet) AS toplam_adet,
                s.satis_fiyati,
                k.kategoriler_adi AS kategori_adi,
                ak.alt_kategoriler_adi AS alt_kategori_adi
            FROM 
                stoklar s
            LEFT JOIN 
                kategoriler k ON k.id = s.kategoriler_id
            LEFT JOIN 
                alt_kategoriler ak ON ak.id = s.alt_kategoriler_id
            WHERE 
                s.seri_no = :seri_no
            GROUP BY 
                s.seri_no, s.marka, s.satis_fiyati, k.kategoriler_adi, ak.alt_kategoriler_adi
            ", [
                "seri_no" => $seri_no,
            ]);
            if (!$sorgu || empty($sorgu["id"])) {
                echo json_encode(["hata" => "bulunamadi"]);
                return;
            }
            if ($adet > $sorgu["toplam_adet"]) {
                echo json_encode(["hata" => "Stokta yeterli ürün yok. Mevcut: {$sorgu['toplam_adet']} adet."]);
                return;
            }
            $sonuc["id"] = $sorgu["id"];
            $sonuc["kategori"] = $sorgu["kategori_adi"];
            $sonuc["yedek_parca_ad"] = $sorgu["alt_kategori_adi"];
            $sonuc["marka"] = $sorgu["marka"];
            $sonuc["satis_fiyati"] = $sorgu["satis_fiyati"];
            $sonuc["seri_no"] = $sorgu["seri_no"];

            echo json_encode($sonuc);
        }
    }
    public function post_personel_stok_ekle() {
        DB->query("SET time_zone = '+03:00'");
        $sonuc = [];

        // Verileri al
        $seri_no = $_POST["seri_no"];
        $kategoriler_id = $_POST["kategori_id"];
        $alt_kategoriler_id = $_POST["alt_kategori_id"];
        $marka = $_POST["marka"];
        $tedarikci_id = $_POST["tedarikci_id"];
        $kritik_seviye = $_POST["kritik_seviye"];
        $alis_tarihi = $_POST["alis_tarihi"];
        $garanti_suresi = $_POST["garanti_suresi"];
        $adet = $_POST["adet"];
        $birim_fiyat = $_POST["birim_fiyat"];
        $kdvDurumu = $_POST["kdvDurumu"];
        $kdv_orani = $_POST["kdv_orani"];

        // Aynı seri_no varsa ama kategori, alt kategori veya marka farklıysa engelle
        $kontrol = DB->row("
            SELECT * FROM stoklar 
            WHERE seri_no = :seri_no 
            AND (kategoriler_id != :kategoriler_id OR alt_kategoriler_id != :alt_kategoriler_id OR marka != :marka)", 
            [
                "seri_no" => $seri_no,
                "kategoriler_id" => $kategoriler_id,
                "alt_kategoriler_id" => $alt_kategoriler_id,
                "marka" => $marka
            ]
        );

        if ($kontrol) {
            $sonuc["islem"] = "error";
            $sonuc["mesaj"] = "Aynı seri numarası başka bir ürün için kullanılmış!";
            echo json_encode($sonuc);
            return;
        }

        // Verileri hazırla
        $stokVerileri = [
            "seri_no" => $seri_no,
            "kategoriler_id" => $kategoriler_id,
            "alt_kategoriler_id" => $alt_kategoriler_id,
            "marka" => $marka,
            "tedarikci_id" => $tedarikci_id,
            "kritik_seviye" => $kritik_seviye,
            "alis_tarihi" => $alis_tarihi,
            "garanti_suresi" => $garanti_suresi,
            "adet" => $adet,
            "birim_fiyat" => $birim_fiyat,
            "kdvDurumu" => $kdvDurumu,
            "kdv_orani" => $kdv_orani,
            "satin_alinan_adet" => $adet,
        ];

        // Ekle
        $stokSorgu = "INSERT INTO stoklar (
            seri_no, kategoriler_id, alt_kategoriler_id, marka, tedarikci_id, kritik_seviye, alis_tarihi, garanti_suresi, adet, birim_fiyat, kdvDurumu, kdv_orani, satin_alinan_adet
            ) VALUES (
                seri_no, :kategoriler_id, :alt_kategoriler_id, :marka, :tedarikci_id, :kritik_seviye, :alis_tarihi, :garanti_suresi, :adet, :birim_fiyat, :kdvDurumu, :kdv_orani, :satin_alinan_adet
            )";

        DB->query($stokSorgu, $stokVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);
    }
}