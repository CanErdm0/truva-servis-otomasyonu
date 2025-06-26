<?php 
class misafir extends ortak {
    public function anasayfa() {
        FONK->goruntu("misafir", "anasayfa", [], "tek");
    }
    public function kaydol() {
        FONK->goruntu("misafir","kaydol", [], "tek");
    }
    public function randevuSorgula() {
        FONK->goruntu("misafir","randevuSorgula", [], "tek");
    }
    public function giris_yap() {
        FONK->goruntu("misafir","giris_yap", [], "tek");
    }
    public function sifremiUnuttum() {
        FONK->goruntu("misafir","sifremiUnuttum", [], "tek");
    }
    public function girisTur() {
        FONK->goruntu("misafir","girisTur", [], "tek");
    }
    public function post_giris_yap(){
        $nesne = [];
        $email = $_POST["email"];
        $sifre = $_POST["sifre"];

        $kullanici = DB->row("SELECT * FROM kullanicilar WHERE email = :email AND sifre = :sifre LIMIT 1", [
            "email" => $email,
            "sifre" => $sifre
        ]);

        if(is_array($kullanici)) {
            // Rol bazlı detay bilgileri çek (opsiyonel)
            $rol = $kullanici["rol"];
            $rol_detay = null;

            if ($rol == "personel") {
                $rol_detay = DB->row("SELECT * FROM personeller WHERE kullanici_id = :id", ["id" => $kullanici["id"]]);
            } elseif ($rol == "musteri") {
                $rol_detay = DB->row("SELECT * FROM musteriler WHERE kullanici_id = :id", ["id" => $kullanici["id"]]);
            } elseif ($rol == "admin") {
                $rol_detay = DB->row("SELECT * FROM adminler WHERE kullanici_id = :id", ["id" => $kullanici["id"]]);
            } elseif ($rol == "tedarikci") {
                $rol_detay = DB->row("SELECT * FROM tedarikciler WHERE kullanici_id = :id", ["id" => $kullanici["id"]]);
            }

            $_SESSION = [
                "rol" => $rol, 
                "adsoyad" => $kullanici["ad"] . " " . $kullanici["soyad"],
                "id" => $kullanici["id"],
                "email" => $kullanici["email"],
                "telefon" => $kullanici["telefon"],
                "kayit_tarihi" => $kullanici["kayit_tarihi"],
                "adres_id" => $kullanici["adres_id"],
                "tc_no" => $kullanici["tc_no"],
                "rol_detay" => $rol_detay // opsiyonel olarak detayları da ekliyoruz
            ];

            
            $yonlendir = "";
            switch ($rol) {
                case "admin":
                    $yonlendir = "anasayfa";
                break;
                case "personel":
                    $yonlendir = "anasayfa";
                break;
                case "musteri":
                    $yonlendir = "anasayfa";
                break;
                case "tedarikci":
                    $yonlendir = "anasayfa";
                break;
                default:
                    $yonlendir = "girisTur";
            }
                $nesne["islem"] = "success";
                $nesne["mesaj"] = "Başarılı giriş yaptınız. Yönlendiriliyorsunuz";
                $nesne["rol"] = $rol;
                $nesne["yonlendir"] = $yonlendir;
                } else {
                $nesne["islem"] = "error";
            $nesne["mesaj"] = "Hatalı giriş";
            }

            sleep(1);
            echo json_encode($nesne);
    }
    public function post_kaydol(){
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
    public function post_bos_saatler(){
        $tarih = $_POST["tarih"] ?? null;

        if (!$tarih) {
            echo json_encode([]);
            exit;
        }

        try {
            $veriler = DB->query("SELECT randevu_saat FROM randevular WHERE randevu_tarih = :randevu_tarih", [
            "randevu_tarih" => $tarih
            ]);


            $doluSaatler = [];

            foreach ($veriler as $satir) {
                $doluSaatler[] = $satir["randevu_saat"];
            }

            echo json_encode($doluSaatler);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["hata" => "Sunucu hatası", "detay" => $e->getMessage()]);
            exit;
        }
    }
}

