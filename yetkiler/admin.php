<?php 
class admin extends ortak {
    public function anasayfa() {
        FONK->goruntu("admin", "anasayfa", ["title"=>"Ana Sayfa"]);
    }
    public function post_admin_ayarlar_guncelle() {
            
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


        if($ulke =="Türkiye"){
            $ilce = $_POST["ilce"] ?? "";
            $mahalle = $_POST["mahalle"] ?? "";
            $sehir = $_POST["sehir"] ?? "";
        }else{
            $sehir = $_POST["sehir_input"] ?? "";
            $ilce = $_POST["ilce_input"] ?? "";
            $mahalle = $_POST["mahalle_input"] ?? "";
        }

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
    public function post_personel_ekle() {
        $sonuc = [];

        $ad = $_POST["ad"];
        $soyad = $_POST["soyad"];
        $email = $_POST["email"];
        $telefon = $_POST["telefon"];
        $tc_no = $_POST["tc_no"];
        $ulke = $_POST["ulke"];
        $cadde = $_POST["cadde"];
        $sokak = $_POST["sokak"];
        $daire = $_POST["daire"];
        $sifre = $_POST["sifre"];
        $sifre_tekrar = $_POST["sifre_tekrar"];
        $dogum_tarihi = $_POST["dogum_tarihi"];
        $kan_grubu = $_POST["kan_grubu"];
        $pozisyon = $_POST["pozisyon"];
        $ise_baslama = $_POST["ise_baslama"];
        $ilce = $_POST["ilce"] ?? "";
        $mahalle = $_POST["mahalle"] ?? "";
        $sehir = $_POST["sehir"] ?? "";

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

        if ($sifre !== $sifre_tekrar) {
            $sonuc["islem"] = "error";
            $sonuc["mesaj"] = "Şifreler uyuşmuyor!";
            echo json_encode($sonuc);
            return;
        }

        // Adres kaydı
        $adresVerileri = [
            "ulke" => $ulke,
            "sehir" => $sehir,
            "ilce" => $ilce,
            "mahalle" => $mahalle,
            "cadde" => $cadde,
            "sokak" => $sokak,
            "daire" => $daire
        ];
        $adresSorgu = "INSERT INTO adresler (
            ulke, sehir, ilce, mahalle, cadde, sokak, daire
        ) VALUES (
            :ulke, :sehir, :ilce, :mahalle, :cadde, :sokak, :daire)";
        DB->query($adresSorgu, $adresVerileri);

        $adres_id = DB->lastInsertId();

        // Kullanıcı kaydı
        $kullaniciVerileri = [
            "ad" => $ad,
            "soyad" => $soyad,
            "email" => $email,
            "telefon" => $telefon,
            "sifre" => $sifre,
            "dogum_tarihi" => $dogum_tarihi,
            "adres_id" => $adres_id,
            "rol" => "personel",
            "tc_no" => $tc_no
        ];

        $kullaniciSorgu = "INSERT INTO kullanicilar (
            ad, soyad, email, telefon, sifre, dogum_tarihi, adres_id, rol, tc_no
        ) VALUES (
            :ad, :soyad, :email, :telefon, :sifre, :dogum_tarihi, :adres_id, :rol, :tc_no)";
        DB->query($kullaniciSorgu, $kullaniciVerileri);

        $kullanici_id = DB->lastInsertId();

        // Personel kaydı
        $personelVerileri = [
            "kullanici_id" => $kullanici_id,
            "ise_baslama_tarihi" => $ise_baslama,
            "pozisyon" => $pozisyon,
            "kan_grubu" => $kan_grubu
        ];

        $personelSorgu = "INSERT INTO personeller (
            kullanici_id, ise_baslama_tarihi, pozisyon, kan_grubu
        ) VALUES (
            :kullanici_id, :ise_baslama_tarihi, :pozisyon, :kan_grubu)";
        DB->query($personelSorgu, $personelVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);
    }
    public function post_tedarikci_ekle(){
        $sonuc = [];

        $ad = $_POST["ad"];
        $yetkili_ad = $_POST["yetkili_ad"];
        $yetkili_soyad = $_POST["yetkili_soyad"];
        $email = $_POST["email"];
        $telefon = $_POST["telefon"];
        $ulke = $_POST["ulke"];
        $cadde = $_POST["cadde"];
        $sokak = $_POST["sokak"];
        $daire = $_POST["daire"];
        $web_adresi = $_POST["web_adresi"];
        $aciklama = $_POST["aciklama"];

        if (!empty($email)) {
            $email_kontrol = DB->row("SELECT * FROM tedarikciler WHERE email = :email", [
                "email" => $email,
            ]);
    
            if ($email_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu e-posta adresi başka bir kullanıcıya ait!";
                echo json_encode($sonuc);
                return;
            }
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



        if($ulke =="Türkiye"){
            $ilce = $_POST["ilce"] ?? "";
            $mahalle = $_POST["mahalle"] ?? "";
            $sehir = $_POST["sehir"] ?? "";
        }else{
            $sehir = $_POST["sehir_input"] ?? "";
            $ilce = $_POST["ilce_input"] ?? "";
            $mahalle = $_POST["mahalle_input"] ?? "";
        }

        if ($sifre !== $sifre_tekrar) {
            $sonuc["islem"] = "error";
            $sonuc["mesaj"] = "Şifreler uyuşmuyor!";
            echo json_encode($sonuc);
            return;
        }




        
        $adresVerileri = [
        "ulke" => $ulke,
        "sehir" => $sehir,
        "ilce" => $ilce,
        "mahalle" => $mahalle,
        "cadde" => $cadde,
        "sokak" => $sokak,
        "daire" => $daire
        ];
         $adresSorgu = "INSERT INTO adresler (
        ulke, sehir, ilce, mahalle, cadde, sokak, daire
        ) VALUES (
        :ulke, :sehir, :ilce, :mahalle, :cadde, :sokak, :daire)";
        DB->query($adresSorgu, $adresVerileri);

        // Adres ID'sini al
        $adres_id = DB->lastInsertId();

        $tedarikciVerileri = [
            "ad" => $ad,
            "yetkili_ad" => $yetkili_ad,
            "yetkili_soyad" => $yetkili_soyad,
            "email" => $email,
            "telefon" => $telefon,
            "adres_id" => $adres_id,
            "web_adresi" => $web_adresi,
            "aciklama" => $aciklama
        ];

        $tedarikciSorgu = "INSERT INTO tedarikciler (
        ad, email, telefon, adres_id, web_adresi, aciklama, yetkili_ad, yetkili_soyad 
        ) VALUES (
        :ad, :email, :telefon, :adres_id, :web_adresi, :aciklama, :yetkili_ad, :yetkili_soyad)";
        DB->query($tedarikciSorgu, $tedarikciVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);
    }
    public function post_admin_stok_ekle() {
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
                :seri_no, :kategoriler_id, :alt_kategoriler_id, :marka, :tedarikci_id, :kritik_seviye, :alis_tarihi, :garanti_suresi, :adet, :birim_fiyat, :kdvDurumu, :kdv_orani, :satin_alinan_adet
            )";

        DB->query($stokSorgu, $stokVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);
    }
    public function post_admin_yeni_stok_ekle(){
        DB->query("SET time_zone = '+03:00'");
         $sonuc = [];

        // Verileri al
        $seri_no = $_POST["yeni_stok_seri_no"];
        $kategoriler_id = $_POST["yeni_kategori_id"];
        $alt_kategoriler_id = $_POST["yeni_alt_kategori_id"];
        $marka = $_POST["yeni_marka"];
        $tedarikci_id = $_POST["yeni_tedarikci_id"];
        $kritik_seviye = $_POST["kritik_seviye"];
        $alis_tarihi = $_POST["alis_tarihi"];
        $garanti_suresi = $_POST["garanti_suresi"];
        $adet = $_POST["adet"];
        $birim_fiyat = $_POST["birim_fiyat"];
        $kdvDurumu = $_POST["kdvDurumu"];
        $kdv_orani = $_POST["kdv_orani"];

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
            :seri_no, :kategoriler_id, :alt_kategoriler_id, :marka, :tedarikci_id, :kritik_seviye, :alis_tarihi, :garanti_suresi, :adet, :birim_fiyat, :kdvDurumu, :kdv_orani, :satin_alinan_adet
        )";

        DB->query($stokSorgu, $stokVerileri);

        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);
    }
    public function post_admin_musteri_traktor_ekle(){
        $sonuc = [];

        $musteri_id = $_POST["musteri_id"];
        $marka = $_POST["marka"];
        $model = $_POST["model"];
        $model_yili = $_POST["model_yili"];
        $plaka = $_POST["plaka"];
        $sasi_no = $_POST["sasi_no"];
        $ithal_sasi_no = $_POST["ithal_sasi_no"];
        $motor_no = $_POST["motor_no"];
        $garanti = $_POST["garanti"];

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
    public function post_admin_musteri_kaydet(){
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
    public function post_servis_kaydi_stok_ekle() {
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
    public function post_admin_servis_kaydi_ekle(){
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
    public function post_admin_servis_kaydi_guncelle() {
        DB->query("SET time_zone = '+03:00'");
        $sonuc = [];
        $servis_kaydi_id = $_POST["servis_kaydi_guncelle_verileri_id"];

        // Servis kaydını al
        $servis_kaydi_verileri = DB->row("SELECT * FROM ariza_kayitlari WHERE id = :id", [
            "id" => $servis_kaydi_id
        ]);

        if (!$servis_kaydi_verileri) {
            echo json_encode([
                "islem" => "hata",
                "mesaj" => "Servis kaydı bulunamadı!"
            ]);
            return;
        }

        if (empty($servis_kaydi_verileri["teslim_tarihi"]) && empty($_POST["teslim_tarihi"])) {
            echo json_encode([
                "islem" => "hata",
                "mesaj" => "Teslim tarihi girilmesi zorunludur."
            ]);
            return;
        }

        if (empty($servis_kaydi_verileri["ucret"]) && empty($_POST["iscilik_ucreti"])) {
            echo json_encode([
                "islem" => "hata",
                "mesaj" => "İşçilik ücreti girilmesi zorunludur."
            ]);
            return;
        }

        if (empty($servis_kaydi_verileri["aciklama"]) && empty($_POST["aciklama"])) {
            echo json_encode([
                "islem" => "hata",
                "mesaj" => "Açıklama girilmesi zorunludur."
            ]);
            return;
        }

        $teslim_tarihi  = $_POST["teslim_tarihi"]  ?: $servis_kaydi_verileri["teslim_tarihi"];
        $iscilik_ucreti = $_POST["iscilik_ucreti"] ?: $servis_kaydi_verileri["ucret"];
        $aciklama       = $_POST["aciklama"]       ?: $servis_kaydi_verileri["aciklama"];

        $stoklar_raw = $_POST["stokListesi"];
        $once = json_decode($stoklar_raw, true);
        $stoklar = is_string($once) ? json_decode($once, true) : $once;

        if (!is_array($stoklar)) {
            echo json_encode([
                "islem" => "hata",
                "mesaj" => "stokListesi iki kez çözümlenemedi",
            ]);
            return;
        }

        $toplam_ucret = 0;

        foreach ($stoklar as $stok) {
            $seri_no = $stok["seri_no"] ?? "";
            $kategori = $stok["kategori"] ?? "";
            $yedek_parca_ad = $stok["yedek_parca_ad"] ?? "";
            $marka = $stok["marka"] ?? "";
            $istenen_adet = intval($stok["adet"] ?? 0);
            $toplam = floatval($stok["toplam"] ?? 0);

            $toplam_ucret += $toplam;

            $kategori_row = DB->row("SELECT id FROM kategoriler WHERE kategoriler_adi = :kategori", [
                "kategori" => $kategori
            ]);
            $kategori_id = $kategori_row["id"] ?? null;

            $alt_kategori_row = DB->row("SELECT id FROM alt_kategoriler WHERE kategoriler_id = :kategori_id AND alt_kategoriler_adi = :yedek_parca_ad", [
                "kategori_id" => $kategori_id,
                "yedek_parca_ad" => $yedek_parca_ad
            ]);
            $alt_kategori_id = $alt_kategori_row["id"] ?? null;

            // Stokları sırayla al (önce giren ilk çıkar mantığı)
            $stok_kayitlari = DB->query("SELECT id, adet FROM stoklar WHERE seri_no = :seri_no AND kategoriler_id = :kategori_id AND alt_kategoriler_id = :alt_kategori_id AND marka = :marka AND adet > 0 ORDER BY id ASC", [
                "seri_no" => $seri_no,
                "kategori_id" => $kategori_id,
                "alt_kategori_id" => $alt_kategori_id,
                "marka" => $marka
            ]);

            $kalan_adet = $istenen_adet;

            foreach ($stok_kayitlari as $stok_kaydi) {
                if ($kalan_adet <= 0) break;

                $stok_adet = intval($stok_kaydi["adet"]);
                $stoktan_dusulecek = min($stok_adet, $kalan_adet);
                $yeni_adet = $stok_adet - $stoktan_dusulecek;

                DB->query("UPDATE stoklar SET adet = :adet WHERE id = :id", [
                    "adet" => $yeni_adet,
                    "id" => $stok_kaydi["id"]
                ]);

                // Stok hareketi kaydı
                DB->query("INSERT INTO stok_hareketleri (
                    seri_no, marka, miktar, aciklama, kategoriler_adi, alt_kategoriler_adi, musteri_id
                ) VALUES (
                    :seri_no, :marka, :miktar, :aciklama, :kategoriler_adi, :alt_kategoriler_adi, :musteri_id
                )", [
                    "seri_no" => $seri_no,
                    "marka" => $marka,
                    "miktar" => $stoktan_dusulecek,
                    "aciklama" => "Servis Parça Kullanımı",
                    "kategoriler_adi" => $kategori,
                    "alt_kategoriler_adi" => $yedek_parca_ad,
                    "musteri_id" => $servis_kaydi_verileri["musteri_id"]
                ]);

                $kalan_adet -= $stoktan_dusulecek;
            }

            // Eğer yeterli stok yoksa uyarı verilebilir (opsiyonel)
            if ($kalan_adet > 0) {
                echo json_encode([
                    "islem" => "hata",
                    "mesaj" => "Yeterli stok bulunamadı: {$kategori} > {$yedek_parca_ad} (Eksik: {$kalan_adet} adet)"
                ]);
                return;
            }
        }

        // Servis kaydını güncelle
        DB->query("UPDATE ariza_kayitlari SET teslim_tarihi = :teslim_tarihi, ucret = :ucret, aciklama = :aciklama WHERE id = :id", [
            "teslim_tarihi" => $teslim_tarihi,
            "ucret"         => $iscilik_ucreti + $toplam_ucret,
            "aciklama"      => $aciklama,
            "id"            => $servis_kaydi_id
        ]);

        echo json_encode([
            "islem" => "success",
            "mesaj" => "Servis kaydı başarıyla güncellendi!"
        ]);
    }
    public function post_formGuncelle(){

        $sonuc = [];

        $gorevTanimi = $_POST["gorevTanimi"];
        $calismaDurumu = $_POST["calismaDurumu"];
        $personel_id = $_POST["personel_guncelleme_id"];
        

        $guncelle = DB->query("UPDATE personeller SET durum = :durum, pozisyon = :pozisyon WHERE id = :id", [
            "durum" => $calismaDurumu,
            "pozisyon" => $gorevTanimi,
            "id" => $personel_id
        ]);

        if ($calismaDurumu === "Ayrıldı") {
            $bugun = date("Y-m-d");
            DB->query("UPDATE personeller SET isten_ayrilma_tarihi = :tarih WHERE id = :id", [
                "tarih" => $bugun,
                "id" => $personel_id
            ]);
        }

    
        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);
        

    }
    public function post_randevu_durumu_guncelle(){

        $randevu_id = $_POST["randevu_id"];
        $randevu_durumu = $_POST["randevu_durumu"];

        $guncelle = DB->query("UPDATE randevular SET durum = :durum WHERE id = :id", [
            "durum" => $randevu_durumu,
            "id" => $randevu_id
        ]);
        if ($guncelle) {
        $mesaj = "";
        if ($randevu_durumu == "Onaylandı") {
            $mesaj = "Randevu başarıyla onaylandı!";
        } elseif ($randevu_durumu == "Reddedildi!") {
            $mesaj = "Randevu reddedildi!";
        } else {
            $mesaj = "Randevu durumu güncellendi.";
        }

        echo json_encode([
            "islem" => "success",
            "mesaj" => $mesaj
        ]);
        } else {
            echo json_encode([
            "islem" => "error",
            "mesaj" => "Randevu onaylanamadı!"
            ]);
        }
    }
    public function post_admin_randevu_al() {
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


       if (!empty($randevu_tarih) && !empty($randevu_saat)) {
            $randevu_kontrol = DB->row("
                SELECT * FROM randevular 
                WHERE randevu_tarih = :randevu_tarih 
                AND randevu_saat = :randevu_saat
                AND durum IN ('Onaylandı', 'Bekliyor')",  
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
    public function post_urun_bilgisi() {
        $seri_no = $_POST["seri_no"] ?? "";

        $urun = DB->row("SELECT 
            s.seri_no, 
            s.kategoriler_id, 
            k.kategoriler_adi AS kategori_adi, 
            s.alt_kategoriler_id, 
            ak.alt_kategoriler_adi AS alt_kategori_adi, 
            s.marka, 
            SUM(s.adet) AS toplam_adet, 
            s.birim_fiyat, 
            s.kdv_orani, 
            s.satis_fiyati
            FROM stoklar s
            LEFT JOIN kategoriler k ON s.kategoriler_id = k.id
            LEFT JOIN alt_kategoriler ak ON s.alt_kategoriler_id = ak.id
            WHERE s.seri_no = :seri_no
            GROUP BY 
            s.seri_no, 
            s.kategoriler_id, 
            k.kategoriler_adi,
            s.alt_kategoriler_id, 
            ak.alt_kategoriler_adi,
            s.marka, 
            s.birim_fiyat, 
            s.kdv_orani, 
            s.satis_fiyati", 
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
        $miktar = intval($_POST["miktar"] ?? 1); // varsayılan 1 adet

        if ($miktar <= 0) {
            echo json_encode(["islem" => "warning", "mesaj" => "Geçersiz miktar"]);
            return;
        }

        // Tüm uygun stok kayıtlarını al (adet > 0 olanlar)
        $stoklar = DB->rows("SELECT * FROM stoklar WHERE seri_no = :seri_no AND adet > 0 ORDER BY id ASC", [
            "seri_no" => $seri_no
        ]);

        $kalan_miktar = $miktar;

        foreach ($stoklar as $stok) {
            if ($kalan_miktar <= 0) break;

            $dusulecek = min($stok["adet"], $kalan_miktar);

            // Güncelle
            DB->query("UPDATE stoklar SET adet = adet - :dusulecek, guncellenme_tarihi = NOW() WHERE id = :id", [
                "dusulecek" => $dusulecek,
                "id" => $stok["id"]
            ]);

            // Hareket kaydı ekle
            DB->insert("stok_hareketleri", [
                "seri_no" => $stok["seri_no"],
                "marka" => $stok["marka"],
                "kategoriler_id" => $stok["kategoriler_id"],
                "alt_kategoriler_id" => $stok["alt_kategoriler_id"],
                "miktar" => -$dusulecek,
                "aciklama" => "Stoktan $dusulecek adet düşüldü",
                "tarih" => date("Y-m-d H:i:s")
            ]);

            $kalan_miktar -= $dusulecek;
        }

        $dusulen = $miktar - $kalan_miktar;

        if ($dusulen > 0) {
            echo json_encode([
                "islem" => "success",
                "mesaj" => "$dusulen adet stoktan düşüldü"
            ]);
        } else {
            echo json_encode([
                "islem" => "warning",
                "mesaj" => "Stokta yeterli ürün yok"
            ]);
        }
    }
    public function post_tedarikci_sil() {
        $tedarikci_id = $_POST["tedarikci_id"];

        if (!empty($tedarikci_id)) {
            $stok_kontrol = DB->row("SELECT * FROM stoklar WHERE tedarikci_id = :tedarikci_id", [
                "tedarikci_id" => $tedarikci_id,
            ]);
            if ($stok_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu Tedarikciye Ait Stok Bulunmaktadır!";
                echo json_encode($sonuc);
                return;
            }
        }

        DB->query("DELETE FROM tedarikciler WHERE id = :id", [
            "id" => $tedarikci_id
        ]);

        echo json_encode([
            "islem" => "success",
            "mesaj" => "Tedarikci başarıyla silindi!"
        ]);
    }
    public function post_stok_sil() {
        DB->query("SET time_zone = '+03:00'");
        $olusturulma_tarihi = $_POST["olusturulma_tarihi"];
        $seri_no = $_POST["seri_no"];
         
        DB->query("DELETE FROM stoklar WHERE olusturulma_tarihi = :olusturulma_tarihi AND seri_no = :seri_no" , [
            "olusturulma_tarihi" => $olusturulma_tarihi,
            "seri_no" => $seri_no
        ]);
        echo json_encode([
            "islem" => "success",
            "mesaj" => "Stok başarıyla silindi!"
        ]);

    }
    public function post_birim_fiyat_guncelle() {
        DB->query("SET time_zone = '+03:00'");
        $birim_fiyat_guncelle = $_POST["birim_fiyat_guncelle"];
        $birim_fiyat_seri_no = $_POST["birim_fiyat_seri_no"];
        $birim_fiyat_olusturulma_tarihi = $_POST["birim_fiyat_olusturulma_tarihi"];

       DB->query("UPDATE stoklar SET 
                satis_fiyati = :satis_fiyati 
                WHERE olusturulma_tarihi = :birim_fiyat_olusturulma_tarihi 
                AND seri_no = :birim_fiyat_seri_no", [
                "satis_fiyati" => $birim_fiyat_guncelle,
                "birim_fiyat_olusturulma_tarihi" => $birim_fiyat_olusturulma_tarihi,
                "birim_fiyat_seri_no" => $birim_fiyat_seri_no
            ]);


        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);

    }
    public function post_kategori_ekle_sayfası(){
        $sonuc = [];
        $kategori_adi = $_POST["kategori_adi"];

        
       if (!empty($kategori_adi)) {
            $kategori_kontrol = DB->row("SELECT * FROM kategoriler WHERE kategoriler_adi = :kategoriler_adi", [
                "kategoriler_adi" => $kategori_adi,
            ]);

            if ($kategori_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu Kategori Kayıtlı!";
                echo json_encode($sonuc);
                return;
            }
        }
    
       $kategoriVerileri = [
            "kategoriler_adi" => $kategori_adi,

        ];

        $kategoriSorgu = "INSERT INTO kategoriler (
        kategoriler_adi 
        ) VALUES (
        :kategoriler_adi)";
        DB->query($kategoriSorgu, $kategoriVerileri);
        
        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);

    }
    public function post_alt_kategori_ekle_sayfası(){
        $sonuc = [];
        $alt_kategori_adi = $_POST["alt_kategori_adi"];
        $kategori_id = $_POST["kategori_id"];

        
       if (!empty($alt_kategori_adi)) {
            $alt_kategori_kontrol = DB->row("SELECT * FROM alt_kategoriler WHERE alt_kategoriler_adi = :alt_kategoriler_adi", [
                "alt_kategoriler_adi" => $alt_kategori_adi,
            ]);

            if ($alt_kategori_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu Yedek Parça Adı Kayıtlı!";
                echo json_encode($sonuc);
                return;
            }
        }
    
       $altKategoriVerileri = [
            "alt_kategoriler_adi" => $alt_kategori_adi,
            "kategoriler_id" => $kategori_id,

        ];

        $altKategoriSorgu = "INSERT INTO alt_kategoriler (
        alt_kategoriler_adi, kategoriler_id
        ) VALUES (
        :alt_kategoriler_adi, :kategoriler_id)";
        DB->query($altKategoriSorgu, $altKategoriVerileri);
        
        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);

    }
    public function post_kategori_sil() {
        $sonuc = [];
        $kategori_id = $_POST["kategori_id_sil"];

        if (!empty($kategori_id)) {
            $kategori_kontrol = DB->row("SELECT * FROM stoklar WHERE kategoriler_id = :kategoriler_id", [
                "kategoriler_id" => $kategori_id,
            ]);

            if ($kategori_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu Kategori Stoklarda Kayıtlı!";
                echo json_encode($sonuc);
                return;
            }
        }


        DB->query("DELETE FROM kategoriler WHERE id = :id", [
        "id" => $kategori_id
        ]);

        echo json_encode([
        "islem" => "success",
        "mesaj" => "Kategori başarıyla silindi!"
        ]);
    }
    public function post_servis_turu_sil() {
        $id = $_POST["id"];

        DB->query("DELETE FROM servis_turu WHERE id = :id", [
        "id" => $id
        ]);

        echo json_encode([
        "islem" => "success",
        "mesaj" => "Servis Türü başarıyla silindi!"
        ]);
    }
    public function post_alt_kategori_sil(){
        $sonuc = [];
        $alt_kategori_id_sil = $_POST["alt_kategori_id_sil"];

        if (!empty($alt_kategori_id_sil)) {
            $alt_kategori_kontrol = DB->row("SELECT * FROM stoklar WHERE alt_kategoriler_id = :alt_kategoriler_id", [
                "alt_kategoriler_id" => $alt_kategori_id_sil,
            ]);

            if ($alt_kategori_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu Kategori Stoklarda Kayıtlı!";
                echo json_encode($sonuc);
                return;
            }
        }

        DB->query("DELETE FROM alt_kategoriler WHERE id = :id" , [
            "id" => $alt_kategori_id_sil
        ]);
        echo json_encode([
            "islem" => "success",
            "mesaj" => "Yedek Parça Adı başarıyla silindi!"
        ]);
    }
    public function post_servis_turu_kaydet(){
        $sonuc = [];
        $servisTurAdi = $_POST["servisTurAdi"];

        
       if (!empty($servisTurAdi)) {
            $kategori_kontrol = DB->row("SELECT * FROM servis_turu WHERE ad = :ad", [
                "ad" => $servisTurAdi,
            ]);

            if ($kategori_kontrol) {
                $sonuc["islem"] = "error";
                $sonuc["mesaj"] = "Bu Servis Türü Kayıtlı!";
                echo json_encode($sonuc);
                return;
            }
        }
    
       $servisVerileri = [
            "ad" => $servisTurAdi,

        ];

        $servisSorgu = "INSERT INTO servis_turu (
        ad 
        ) VALUES (
        :ad)";
        DB->query($servisSorgu, $servisVerileri);
        
        $sonuc["islem"] = "success";
        $sonuc["mesaj"] = "Kayıt başarılı!";
        echo json_encode($sonuc);

    }
    public function ayarlar() {
        FONK->goruntu("admin","ayarlar", ["title"=>"Ayarlar"]);
    }
    public function tedarikciBilgileri() {
        FONK->goruntu("admin","tedarikciBilgileri", ["title"=>"Tedarikçi Bilgileri"]);
    }
    public function servisKayitlari() {
        FONK->goruntu("admin","servisKayitlari", ["title"=>"Servis Kayıtları"]);
    } 
    public function faturaIsEmriYazdir() {
        FONK->goruntu("admin","faturaIsEmriYazdir", ["title"=>"Fatura / İş Emri"]);
    }
    public function teknikPersonelEkle() {
        FONK->goruntu("admin","teknikPersonelEkle", ["title"=>"Teknik Personel Ekle"]);
    }
    public function teknikPersoneller() {
        FONK->goruntu("admin","teknikPersoneller", ["title"=>"Teknik Personeller"]);
    }
    public function yeniServisKaydiAc() {
        FONK->goruntu("admin","yeniServisKaydiAc", ["title"=>"Yeni Servis Kaydı Aç"]);
    }
    public function gelenRandevu() {
        FONK->goruntu("admin","gelenRandevu", ["title"=>"Gelen Randevu"]);
    }
    public function yeniRandevuOlustur() {
        FONK->goruntu("admin","yeniRandevuOlustur", ["title"=>"Yeni Randevu Oluştur"]);
    }
    public function randevuTakvimi() {
        FONK->goruntu("admin","randevuTakvimi", ["title"=>"Randevu Takvimi"]);
    }
    public function yeniStokEkle() {
        FONK->goruntu("admin","yeniStokEkle", ["title"=>"Yeni Stok Ekle"]);
    }
    public function stokYonetimi() {
        FONK->goruntu("admin","stokYonetimi", ["title"=>"Stok Yönetimi"]);
    }
    public function yeniTedarikciEkle() {
        FONK->goruntu("admin","yeniTedarikciEkle", ["title"=>"Yeni Tedarikçi Ekle"]);   
    }
    public function musteriler() {
        FONK->goruntu("admin","musteriler", ["title"=>"Müşteriler"]);
    }
    public function musteriKaydet() {
        FONK->goruntu("admin","musteriKaydet", ["title"=>"Müşteri Kaydet"]);
    }
    public function stokIslem() {
        FONK->goruntu("admin","stokIslem", ["title"=>"Stok İşlem"]);
    }
    public function kategoriIslem() {
        FONK->goruntu("admin","kategoriIslem", ["title"=>"Kategori İşlem"]);
    }
    public function kullanilanUrunYedekParca() {
        FONK->goruntu("admin","kullanilanUrunYedekParca", ["title"=>"Kullanılan Ürün/Yedek Parça"]);
    }
    public function servisTurIslem() {
        FONK->goruntu("admin","servisTurIslem", ["title"=>"Servis Tür İşlem"]);
    }
    public function fatura() {
        FONK->goruntu("admin", "fatura", ["title"=>"fatura"], "tek");
    }
    public function musteriTraktorEkle() {
        FONK->goruntu("admin", "musteriTraktorEkle", ["title"=>"Müşteri Traktör Ekle"]);
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
}