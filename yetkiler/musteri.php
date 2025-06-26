<?php 
class musteri extends ortak {
    public function anasayfa() {
        FONK->goruntu("musteri", "anasayfa", ["title"=>"Anasayfa"]);
    }
    public function ayarlar() {
        FONK->goruntu("musteri", "ayarlar", ["title"=>"Ayarlar"]);
    }
    public function randevuAl() {
        FONK->goruntu("musteri", "randevuAl", ["title"=>"Randevu Al"]);
    }
    public function randevuDurumu() {
        FONK->goruntu("musteri", "randevuDurumu", ["title"=>"Randevu Durumu"]);
    }
    public function servisKayitlari() {
        FONK->goruntu("musteri", "servisKayitlari", ["title"=>"Servis Kayıtları"]);
    }
    public function traktorEkle() {
        FONK->goruntu("musteri", "traktorEkle", ["title"=>"Traktör Ekle"]);
    }
    public function post_musteri_randevu_al(){
        $sonuc = [];

        $traktor_id = $_POST["traktor_id"];
        $sorun_tanimi = $_POST["sorun_tanimi"];
        $randevu_tarih = $_POST["randevu_tarih"];
        $randevu_saat = $_POST["randevu_saat"];

        $id = $_SESSION["id"];
        // Müşteri bilgilerini al
        $musteri_bilgileri = DB->row("SELECT * FROM musteriler WHERE kullanici_id = :id", [
        "id" => $id,
        ]);
        $musteri_id = $musteri_bilgileri["id"];


        if (!empty($randevu_tarih) && !empty($randevu_saat)) {
            $randevu_kontrol = DB->row("
            SELECT * FROM randevular 
            WHERE randevu_tarih = :randevu_tarih 
            AND randevu_saat = :randevu_saat", 
                [
                    "randevu_tarih" => $randevu_tarih,
                    "randevu_saat" => $randevu_saat
                ]
            );

            if ($randevu_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu tarih ve saat için zaten randevu alınmış!";
                echo json_encode($sonuc);
                return;
            }
        }

        $randevuVerileri = [
        "traktor_id" => $traktor_id,
        "sorun_tanimi" => $sorun_tanimi,
        "randevu_tarih" => $randevu_tarih,
        "randevu_saat" => $randevu_saat,
        "musteri_id" => $musteri_id,
        "durum" => "Bekliyor"
        ];

        $randevuSorgu = "INSERT INTO randevular (
            traktor_id, sorun_tanimi, randevu_tarih, randevu_saat, musteri_id, durum
        ) VALUES (
            :traktor_id, :sorun_tanimi, :randevu_tarih, :randevu_saat, :musteri_id, :durum
        )";

        DB->query($randevuSorgu, $randevuVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);
    }
    public function post_musteri_traktor_ekle(){
        $sonuc = [];

        $marka = $_POST["marka"];
        $model = $_POST["model"];
        $model_yili = $_POST["model_yili"];
        $plaka = $_POST["plaka"];
        $sasi_no = $_POST["sasi_no"];
        $ithal_sasi_no = $_POST["ithal_sasi_no"];
        $motor_no = $_POST["motor_no"];
        $garanti = $_POST["garanti"];

        $id = $_SESSION["id"];

        // Müşteri bilgilerini al
        $musteri_bilgileri = DB->row("SELECT * FROM musteriler WHERE kullanici_id = :id", [
            "id" => $id,
        ]);

        $musteri_id = $musteri_bilgileri["id"];

        // Plaka kontrolü
        if (!empty($plaka)) {
            $plaka_kontrol = DB->row("SELECT * FROM traktorler WHERE plaka = :plaka", [
                "plaka" => $plaka,
            ]);

            if ($plaka_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu plaka sistemde kayıtlı.";
                echo json_encode($sonuc);
                return;
            }
        }

        // Motor No kontrolü
        if (!empty($motor_no)) {
            $motor_kontrol = DB->row("SELECT * FROM traktorler WHERE motor_no = :motor_no", [
                "motor_no" => $motor_no,
            ]);

            if ($motor_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu Motor No sistemde kayıtlı.";
                echo json_encode($sonuc);
                return;
            }
        }

        // Şasi no veya ithal şasi no kontrolü
        if (!empty($sasi_no)) {
            $sasi_kontrol = DB->row("SELECT * FROM traktorler WHERE sasi_no = :sasi_no", [
                "sasi_no" => $sasi_no,
            ]);
            if ($sasi_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu şasi numarası sistemde kayıtlı.";
                echo json_encode($sonuc);
                return;
            }
        } elseif (!empty($ithal_sasi_no)) {
            $ithal_kontrol = DB->row("SELECT * FROM traktorler WHERE ithal_sasi_no = :ithal_sasi_no", [
                "ithal_sasi_no" => $ithal_sasi_no,
            ]);
            if ($ithal_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu ithal şasi numarası sistemde kayıtlı.";
                echo json_encode($sonuc);
                return;
            }
        }

        $traktorVerileri = [
            "musteri_id" => $musteri_id,
            "marka" => $marka,
            "model" => $model,
            "model_yili" => $model_yili,
            "plaka" => $plaka,
            "sasi_no" => $sasi_no,
            "ithal_sasi_no" => $ithal_sasi_no,
            "motor_no" => $motor_no,
            "garanti" => $garanti
            ];

            $traktorSorgu = "INSERT INTO traktorler (
                musteri_id, marka, model, model_yili, plaka, sasi_no, ithal_sasi_no, motor_no, garanti
            ) VALUES (
            :musteri_id, :marka, :model, :model_yili, :plaka, :sasi_no, :ithal_sasi_no, :motor_no, :garanti)";
            DB->query($traktorSorgu, $traktorVerileri);

            $sonuc["islem"] = "success";
            $sonuc["mesaj"] = "Kayıt başarılı!";
            echo json_encode($sonuc);

    }
    public function post_randevu_sil() {
        $randevu_id = $_POST["randevu_id"];

        DB->query("DELETE FROM randevular WHERE id = :id", [
            "id" => $randevu_id
        ]);

        echo json_encode([
            "islem" => "success",
            "mesaj" => "Randevu başarıyla silindi!"
        ]);
    }
    public function post_traktor_sil() {
        $traktor_id = $_POST["traktor_id"];

        if (!empty($traktor_id)) {
            $randevu_kontrol = DB->row("SELECT * FROM randevular WHERE traktor_id = :traktor_id", [
                "traktor_id" => $traktor_id,
            ]);
            if ($randevu_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu Traktöre Ait Randevu Bulunmaktadır!";
                echo json_encode($sonuc);
                return;
            }
        }

        DB->query("DELETE FROM traktorler WHERE id = :id", [
            "id" => $traktor_id
        ]);

        echo json_encode([
            "islem" => "success",
            "mesaj" => "Traktör başarıyla silindi!"
        ]);
    }
    public function post_musteri_ayarlar_guncelle(){
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
            $email_kontrol = DB->row("SELECT * FROM kullanicilar WHERE email = :email AND id != :id", [
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
}