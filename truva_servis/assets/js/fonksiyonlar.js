var birim_fiyat_seri_no = null;
var birim_fiyat_olusturulma_tarihi = null;
var personel_guncelleme_id = null;
var yeni_stok_seri_no = null;
var yeni_kategori_id = null;
var yeni_alt_kategori_id = null;
var yeni_marka = null;
var yeni_tedarikci_id = null;
var servis_kaydi_guncelle_verileri_id = null;
function yonlendir(_adres='', _timer=1000){
    sleep(_timer).then(() => {
        window.location.href = anadizin + _adres;
    });
}
function formPost(url, data, basariliYonlendirme = "") {
    $("button[type='submit']").prop("disabled", true);
    $.post(anadizin + url, data, function(response) {
        surelialert(response["islem"], response["mesaj"]);

        if (response["islem"] == "success") {
            // Eğer PHP tarafı yonlendir verdiyse onu kullan, yoksa parametreyi
            var hedef = response["yonlendir"] ? response["yonlendir"] : basariliYonlendirme;
            if (hedef) yonlendir(hedef);
        } else {
            $("button[type='submit']").prop("disabled", false);
        }
    }, "json");
}
function gecerliEmailMi(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
function sifreGecerliMi(sifre, sifre_tekrar) {
    console.log("Şifre gelen:", `"${sifre}"`, "Tekrar gelen:", `"${sifre_tekrar}"`);
    console.log("Tipler:", typeof sifre, typeof sifre_tekrar);
    if (sifre !== sifre_tekrar) return "Şifreler uyuşmuyor!";
    if (sifre.length < 6) return "Şifre en az 6 karakter olmalı!";
    return true;
}
function telefonGecerliMi(telefon) {
    var regex = /^05\d{9}$/;
    return regex.test(telefon);
}
function bosAlanVarMi(alanlar) {
    for (var i = 0; i < alanlar.length; i++) {
        if (!alanlar[i] || alanlar[i].trim() === "") {
            return true;
        }
    }
    return false;
}
function adresGecerliMi(ilce, koy, cadde, sokak) {
    if (!ilce && !koy) {
        surelialert("warning", "İlçe veya Köy adresinden en az birini doldurmanız gerekir!");
        return false;
    }
    if (!cadde && !sokak) {
        surelialert("warning", "Cadde veya sokak adresinden en az birini doldurmanız gerekir!");
        return false;
    }
    return true;
}
function caddeSokakGecerliMi(cadde, sokak) {
    if (!cadde && !sokak) {
        surelialert("warning", "Cadde veya sokak adresinden en az birini doldurmanız gerekir!");
        return false;
    }
    return true;
}
function togglePassword(inputId, icon) {
    var input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bxs-show");
        icon.classList.add("bxs-hide");
    } else {
        input.type = "password";
        icon.classList.remove("bxs-hide");
        icon.classList.add("bxs-show");
    } 
      
}
// Belirtilen süre kadar bekler (ms cinsinden)
function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}
function surelialert(_icon, _title, _timer=2000){
    Swal.fire({
        icon: _icon,
        title: _title,
        showConfirmButton: false,
        timer: _timer
    });
}
function giris_yap() {
    var email = $("#email").val();
    var sifre = $("#sifre").val();

    if (bosAlanVarMi([email, sifre])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    if (!gecerliEmailMi(email)) {
        surelialert("error", "E-posta adresi geçersiz!");
        return;
    }

    formPost("post_giris_yap", { email, sifre });
}
function kaydol(){
    var ad = $("#ad").val().trim();
    var soyad = $("#soyad").val().trim();
    var email = $("#email").val().trim();
    var telefon = $("#telefon").val().trim();
    var tc_no = $("#tc_no").val().trim();
    var sifre = $("#sifre").val().trim();
    var sifre_tekrar = $("#sifre_tekrar").val().trim();

    if (bosAlanVarMi([ad, soyad, email, telefon, sifre, sifre_tekrar])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }
    
    if (!gecerliEmailMi(email)) {
        surelialert("error", "Geçerli bir e-posta adresi giriniz!");
        return;
    }

    if (!telefonGecerliMi(telefon)) {
        surelialert("error", "Telefon numarası geçersiz. Örnek: 05XXXXXXXXX");
        return;
    }

    var sifreKontrol = sifreGecerliMi(sifre, sifre_tekrar);
    if (sifreKontrol !== true) {
        surelialert("error", sifreKontrol);
        return;
    }

    formPost("post_kaydol", {ad, soyad, email, telefon, tc_no, sifre, sifre_tekrar}, "girisTur");
}
function personel_ayarlar_guncelle(){

    var ad = $("#ad").val();
    var soyad = $("#soyad").val();
    var telefon = $("#telefon").val();
    var ulke = $("#ulke").val();
    var cadde = $("#cadde").val();
    var sokak = $("#sokak").val();
    var daire = $("#daire").val();
    var email = $("#email").val();
    var sifre = $("#sifre").val().trim();
    var sifre_tekrar = $("#sifre_tekrar").val().trim();

    if (telefon && !telefonGecerliMi(telefon)) {
    surelialert("error", "Telefon numarası geçersiz. Örnek: 05XXXXXXXXX");
    return;
}


    if (email && !gecerliEmailMi(email)) {
    surelialert("error", "Geçerli bir e-posta adresi giriniz!");
    return;
}


     if (sifre || sifre_tekrar) {
    var sifreKontrol = sifreGecerliMi(sifre, sifre_tekrar);
    if (sifreKontrol !== true) {
        surelialert("error", sifreKontrol);
        return;
    }
}

    if(ulke == "Türkiye"){
        var sehir = $("#sehir").val();
        var ilce = $("#ilce").val();
        var mahalle = $("#mahalle").val();
    }else{
        var sehir = $("#sehir_input").val();
        var ilce = $("#ilce_input").val();
        var mahalle = $("#mahalle_input").val();
    }

    formPost("post_personel_ayarlar_guncelle", {
        ad, soyad, email, telefon, sifre, sifre_tekrar, ulke, 
        sehir, mahalle, daire, ilce, cadde, sokak
    }, "ayarlar");

}
function personel_musteri_kaydet(){
    var ad = $("#ad").val().trim();
    var soyad = $("#soyad").val().trim();
    var email = $("#email").val().trim();
    var telefon = $("#telefon").val().trim();
    var tc_no = $("#tc_no").val().trim();
    var sifre = $("#sifre").val().trim();
    var sifre_tekrar = $("#sifre_tekrar").val().trim();

    if (bosAlanVarMi([ad, soyad, email, telefon, tc_no, sifre, sifre_tekrar])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    if (!telefonGecerliMi(telefon)) {
        surelialert("error", "Telefon numarası geçersiz. Örnek: 05XXXXXXXXX");
        return;
    }

    var sifreKontrol = sifreGecerliMi(sifre, sifre_tekrar);
    if (sifreKontrol !== true) {
        surelialert("error", sifreKontrol);
        return;
    }

    if (!gecerliEmailMi(email)) {
        surelialert("error", "Geçerli bir e-posta adresi giriniz!");
        return;
    }
    formPost("post_personel_musteri_kaydet", {ad, soyad, email, telefon, tc_no, sifre, sifre_tekrar}, "anasayfa");
}
function admin_ayarlar_guncelle(){
    var ad = $("#ad").val();
    var soyad = $("#soyad").val();
    var telefon = $("#telefon").val();
    var email = $("#email").val();
    var sifre = $("#sifre").val();
    var sifre_tekrar = $("#sifre_tekrar").val();
    var ulke = $("#ulke").val();
    var cadde = $("#cadde").val();
    var sokak = $("#sokak").val();
    var daire = $("#daire").val();

    

     if (telefon && !telefonGecerliMi(telefon)) {
    surelialert("error", "Telefon numarası geçersiz. Örnek: 05XXXXXXXXX");
    return;
    }


    if (email && !gecerliEmailMi(email)) {
    surelialert("error", "Geçerli bir e-posta adresi giriniz!");
    return;
    }


    if (sifre || sifre_tekrar) {
        var sifreKontrol = sifreGecerliMi(sifre, sifre_tekrar);
        if (sifreKontrol !== true) {
            surelialert("error", sifreKontrol);
            return;
        }
    }

    if(ulke == "Türkiye"){
        var sehir = $("#sehir").val();
        var ilce = $("#ilce").val();
        var mahalle = $("#mahalle").val();

        formPost("post_admin_ayarlar_guncelle", {
        ad, soyad, email, telefon, sifre, sifre_tekrar, ulke, 
        sehir, mahalle, daire, ilce, cadde, sokak
    }, "ayarlar");
    }else{
        var sehir_input = $("#sehir_input").val();
        var ilce_input = $("#ilce_input").val();
        var mahalle_input = $("#mahalle_input").val();

        formPost("post_admin_ayarlar_guncelle", {
        ad, soyad, email, telefon, sifre, sifre_tekrar, ulke, 
        sehir_input, mahalle_input, daire, ilce_input, cadde, sokak
    }, "ayarlar");
    }
}
function personel_ekle() {
    var ad = $("#ad").val();
    var soyad = $("#soyad").val();
    var tc_no = $("#tc_no").val();
    var kan_grubu = $("#kan_grubu").val();
    var telefon = $("#telefon").val();
    var email = $("#email").val();
    var dogum_tarihi = $("#dogum_tarihi").val();
    var pozisyon = $("#pozisyon").val();
    var ise_baslama = $("#ise_baslama").val();
    var ulke = $("#ulke").val();
    var cadde = $("#cadde").val();
    var sokak = $("#sokak").val();
    var daire = $("#daire").val();
    var sifre = $("#sifre").val();
    var sifre_tekrar = $("#sifre_tekrar").val();
    

    if(ulke == "Türkiye"){
        var sehir = $("#sehir").val();
        var ilce = $("#ilce").val();
        var mahalle = $("#mahalle").val();
    }else{
        var sehir = $("#sehir_input_group").val();
        var ilce = $("#ilce_input_group").val();
        var mahalle = $("#mahalle_input_group").val();
    }

     if (bosAlanVarMi([ad, soyad, email, telefon, sehir, ilce,mahalle, tc_no, sifre, sifre_tekrar, dogum_tarihi, kan_grubu, ulke, daire, pozisyon, ise_baslama])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    if (!telefonGecerliMi(telefon)) {
        surelialert("error", "Telefon numarası geçersiz. Örnek: 05XXXXXXXXX");
        return;
    }

    var sifreKontrol = sifreGecerliMi(sifre, sifre_tekrar);
    if (sifreKontrol !== true) {
        surelialert("error", sifreKontrol);
        return;
    }

    formPost("post_personel_ekle", {
        ad, soyad, email, telefon, sifre, sifre_tekrar, ulke, 
        sehir, mahalle, daire, ilce, cadde, sokak
    }, "teknikPersoneller");
  
}
function admin_servis_kaydi_ekle(){
    var musteri_id = $("#musteri_id").val();
    var traktor_id = $("#traktor_id").val();
    var servis_turu = $("#servis_turu").val();
    var gelis_tarihi = $("#gelis_tarihi").val();
    var garanti = $("#garanti").val();
    var aciklama = $("#aciklama").val();
    

    if (bosAlanVarMi([musteri_id, traktor_id, servis_turu, gelis_tarihi, garanti, aciklama])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    formPost("post_admin_servis_kaydi_ekle", {
        musteri_id, traktor_id,servis_turu, gelis_tarihi, garanti, aciklama
    }, "servisKayitlari");

}
function servis_kaydi_guncelle_verileri(id){
    servis_kaydi_guncelle_verileri_id = id;
}
function admin_servis_kaydi_guncelle(){
    var teslim_tarihi = $("#teslim_tarihi").val();
    var iscilik_ucreti = $("#iscilik_ucreti").val();
    var aciklama = $("#aciklama").val();
    

    var stokListesi = JSON.stringify(sessionStorage.getItem("stokListesi") || "[]");
    console.log(stokListesi);


    formPost("post_admin_servis_kaydi_guncelle", {
        teslim_tarihi, iscilik_ucreti, aciklama, stokListesi, servis_kaydi_guncelle_verileri_id
    }, "servisKayitlari");

    sessionStorage.removeItem("stokListesi");

}
function personel_servis_kaydi_guncelle(){
    var teslim_tarihi = $("#teslim_tarihi").val();
    var iscilik_ucreti = $("#iscilik_ucreti").val();
    var aciklama = $("#aciklama").val();
    

    var stokListesi = JSON.stringify(sessionStorage.getItem("stokListesi") || "[]");
    console.log(stokListesi);


    formPost("post_personel_servis_kaydi_guncelle", {
        teslim_tarihi, iscilik_ucreti, aciklama, stokListesi, servis_kaydi_guncelle_verileri_id
    }, "servisKayitlari");

    sessionStorage.removeItem("stokListesi");

}
function personel_servis_kaydi_ekle(){
    var musteri_id = $("#musteri_id").val();
    var traktor_id = $("#traktor_id").val();
    var servis_turu = $("#servis_turu").val();
    var gelis_tarihi = $("#gelis_tarihi").val();
    var garanti = $("#garanti").val();
    var aciklama = $("#aciklama").val();
    

    if (bosAlanVarMi([musteri_id, traktor_id, servis_turu, gelis_tarihi, garanti, aciklama])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    formPost("post_personel_servis_kaydi_ekle", {
        musteri_id, traktor_id,servis_turu, gelis_tarihi, garanti, aciklama
    }, "servisKayitlari");


}
function admin_musteri_traktor_ekle(){
    var musteri_id = $("#musteri_id").val().trim();
    var marka = $("#marka").val().trim();
    var model = $("#model").val().trim();
    var model_yili = $("#model_yili").val().trim();
    var plaka = $("#plaka").val().trim();
    var sasi_no = $("#sasi_no").val();
    var ithal_sasi_no = $("#ithal_sasi_no").val();
    var motor_no = $("#motor_no").val().trim();
    var garanti = $("#garanti").val().trim();

    if (bosAlanVarMi([marka, model, model_yili, plaka, motor_no, garanti])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    if (!sasi_no && !ithal_sasi_no) {
        surelialert("warning", "Şasi No veya İthal Şasi No kutucuklarından en az birini doldurmanız gerekir!");
        return;
    }

    formPost("post_admin_musteri_traktor_ekle", {
        marka, model, model_yili, plaka, sasi_no, ithal_sasi_no, motor_no, garanti, musteri_id
    }, "musteriTraktorEkle");
}

function musteri_traktor_ekle(){
    var marka = $("#marka").val().trim();
    var model = $("#model").val().trim();
    var model_yili = $("#model_yili").val().trim();
    var plaka = $("#plaka").val().trim();
    var sasi_no = $("#sasi_no").val();
    var ithal_sasi_no = $("#ithal_sasi_no").val();
    var motor_no = $("#motor_no").val().trim();
    var garanti = $("#garanti").val().trim();

    if (bosAlanVarMi([marka, model, model_yili, plaka, motor_no, garanti])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    if (!sasi_no && !ithal_sasi_no) {
        surelialert("warning", "Şasi No veya İthal Şasi No kutucuklarından en az birini doldurmanız gerekir!");
        return;
    }

    formPost("post_musteri_traktor_ekle", {
        marka, model, model_yili, plaka, sasi_no, ithal_sasi_no, motor_no, garanti
    }, "traktorEkle");
}
function musteri_randevu_al(){
    
    var traktor_id = $("#traktor_id").val().trim();
    var sorun_tanimi = $("#sorun_tanimi").val().trim();
    var randevu_tarih = $("#randevu_tarih").val().trim();
    var randevu_saat = $("#randevu_saat").val().trim();

    console.log(traktor_id, sorun_tanimi, randevu_tarih,randevu_saat )
    

    if (bosAlanVarMi([sorun_tanimi, randevu_tarih, randevu_saat, traktor_id])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    formPost("post_musteri_randevu_al", {
        traktor_id, sorun_tanimi, randevu_tarih, randevu_saat
    }, "randevuDurumu");
    
}
function tedarikci_ekle(){
    var ad = $("#ad").val().trim();
    var yetkili_ad = $("#yetkili_ad").val().trim();
    var yetkili_soyad = $("#yetkili_soyad").val().trim();
    var email = $("#email").val().trim();
    var telefon = $("#telefon").val().trim();
    var ulke = $("#ulke").val().trim();
    var cadde = $("#cadde").val().trim();
    var sokak = $("#sokak").val().trim();
    var daire = $("#daire").val().trim();
    var web_adresi = $("#web_adresi").val();
    var aciklama = $("#aciklama").val().trim();


    if (bosAlanVarMi([ad, yetkili_ad, yetkili_soyad, email, telefon, ulke, daire, aciklama])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    if (!caddeSokakGecerliMi(cadde, sokak)) return;

    if (!gecerliEmailMi(email)) {
        surelialert("error", "Geçerli bir e-posta adresi giriniz!");
        return;
    }

    if (!telefonGecerliMi(telefon)) {
        surelialert("error", "Telefon numarası geçersiz. Örnek: 05XXXXXXXXX");
        return;
    }

    if(ulke == "Türkiye"){
        var sehir = $("#sehir").val();
        var ilce = $("#ilce").val();
        var mahalle = $("#mahalle").val();

        formPost("post_tedarikci_ekle", {
        ad, yetkili_ad, yetkili_soyad, email, telefon, ulke, 
        sehir, mahalle, daire, ilce, cadde, sokak, web_adresi, aciklama
    }, "tedarikciBilgileri");
    }else{
        var sehir_input = $("#sehir_input").val();
        var ilce_input = $("#ilce_input").val();
        var mahalle_input = $("#mahalle_input").val();

        formPost("post_tedarikci_ekle", {
        ad, yetkili_ad, email, telefon, yetkili_soyad, ulke, web_adresi, 
        sehir_input, mahalle_input, daire, ilce_input, cadde, sokak, aciklama
    }, "tedarikciBilgileri");
    }
}
function randevu_sil(randevu_id) {
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu randevu kalıcı olarak silinecek!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            formPost("post_randevu_sil", { randevu_id }, "randevuDurumu");
        }
    });
}
function randevu_durumu_guncelle(randevu_id) {
    var randevu_durumu = $("#randevu_durumlari_" + randevu_id).val();
    if (bosAlanVarMi([randevu_durumu])) {
        surelialert("warning", "Randevu Durumu Seçiniz!");
        return;
    }
    Swal.fire({
        title: 'Emin misiniz?',
       text: "Bu randevuyu " + randevu_durumu + " olarak güncellemek üzeresiniz!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, Onayla',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            formPost("post_randevu_durumu_guncelle", { randevu_id, randevu_durumu }, "gelenRandevu");
        }
    });
}
function traktor_sil(traktor_id) {
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu traktörü silmek istediğinize emin misiniz?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'Vazgeç'
    }).then((result) => {
        if (result.isConfirmed) {
            formPost("post_traktor_sil", { traktor_id: traktor_id }, "traktorEkle");
        }
    });
}
function admin_traktor_sil(traktor_id) {
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu traktörü silmek istediğinize emin misiniz?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'Vazgeç'
    }).then((result) => {
        if (result.isConfirmed) {
            formPost("post_traktor_sil", { traktor_id: traktor_id }, "musteriTraktorEkle");
        }
    });
}
function tedarikci_sil(tedarikci_id){
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu tedarikçiyi silmek istediğinize emin misiniz?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'Vazgeç'
    }).then((result) => {
        if (result.isConfirmed) {
            formPost("post_tedarikci_sil", { tedarikci_id: tedarikci_id }, "tedarikciBilgileri");
        }
    });
}
function admin_stok_ekle(){
    var seri_no = $("#seri_no").val();
    var kategori_id = $("#kategori_id").val();
    var alt_kategori_id = $("#alt_kategori_id").val();
    var marka = $("#marka").val();
    var tedarikci_id = $("#tedarikci_id").val();
    var kritik_seviye = $("#kritik_seviye").val();
    var alis_tarihi = $("#alis_tarihi").val();
    var garanti_suresi = $("#garanti_suresi").val();
    var adet = $("#adet").val();
    var birim_fiyat = $("#birim_fiyat").val();
    var kdvDurumu = $('input[name="kdv_durumu"]:checked').val();
    var kdv_orani = $("#kdv_orani").val();

    if (bosAlanVarMi([seri_no, kategori_id, alt_kategori_id, marka, tedarikci_id, kritik_seviye, alis_tarihi, garanti_suresi, adet, birim_fiyat, kdvDurumu, kdv_orani])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    formPost("post_admin_stok_ekle", {
        seri_no, kategori_id, alt_kategori_id, marka, tedarikci_id, kritik_seviye, 
        alis_tarihi, garanti_suresi, adet, birim_fiyat, kdvDurumu, kdv_orani
    }, "stokYonetimi");
}
function personel_stok_ekle(){
    var seri_no = $("#seri_no").val();
    var kategori_id = $("#kategori_id").val();
    var alt_kategori_id = $("#alt_kategori_id").val();
    var marka = $("#marka").val();
    var tedarikci_id = $("#tedarikci_id").val();
    var kritik_seviye = $("#kritik_seviye").val();
    var alis_tarihi = $("#alis_tarihi").val();
    var garanti_suresi = $("#garanti_suresi").val();
    var adet = $("#adet").val();
    var birim_fiyat = $("#birim_fiyat").val();
    var kdvDurumu = $('input[name="kdv_durumu"]:checked').val();
    var kdv_orani = $("#kdv_orani").val();

    if (bosAlanVarMi([seri_no, kategori_id, alt_kategori_id, marka, tedarikci_id, kritik_seviye, alis_tarihi, garanti_suresi, adet, birim_fiyat, kdvDurumu, kdv_orani])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    formPost("post_personel_stok_ekle", {
        seri_no, kategori_id, alt_kategori_id, marka, tedarikci_id, kritik_seviye, 
        alis_tarihi, garanti_suresi, adet, birim_fiyat, kdvDurumu, kdv_orani
    }, "stokYonetimi");
}
function musteri_ayarlar_guncelle(){

    var ad = $("#ad").val();
    var soyad = $("#soyad").val();
    var telefon = $("#telefon").val();
    var email = $("#email").val();
    var sifre = $("#sifre").val();
    var sifre_tekrar = $("#sifre_tekrar").val();
    var ulke = $("#ulke").val();
    var cadde = $("#cadde").val();
    var sokak = $("#sokak").val();
    var daire = $("#daire").val();

    

     if (telefon && !telefonGecerliMi(telefon)) {
    surelialert("error", "Telefon numarası geçersiz. Örnek: 05XXXXXXXXX");
    return;
    }


    if (email && !gecerliEmailMi(email)) {
    surelialert("error", "Geçerli bir e-posta adresi giriniz!");
    return;
    }


    if (sifre || sifre_tekrar) {
        var sifreKontrol = sifreGecerliMi(sifre, sifre_tekrar);
        if (sifreKontrol !== true) {
            surelialert("error", sifreKontrol);
            return;
        }
    }

    if(ulke == "Türkiye"){
        var sehir = $("#sehir").val();
        var ilce = $("#ilce").val();
        var mahalle = $("#mahalle").val();
    }else{
        var sehir = $("#sehir_input").val();
        var ilce = $("#ilce_input").val();
        var mahalle = $("#mahalle_input").val();
    }

    formPost("post_musteri_ayarlar_guncelle", {
        ad, soyad, email, telefon, sifre, sifre_tekrar, ulke, 
        sehir, mahalle, daire, ilce, cadde, sokak
    }, "ayarlar");

}
function admin_musteri_kaydet(){
    var ad = $("#ad").val().trim();
    var soyad = $("#soyad").val().trim();
    var email = $("#email").val().trim();
    var telefon = $("#telefon").val().trim();
    var tc_no = $("#tc_no").val().trim();
    var sifre = $("#sifre").val().trim();
    var sifre_tekrar = $("#sifre_tekrar").val().trim();

    if (bosAlanVarMi([ad, soyad, email, telefon, tc_no, sifre, sifre_tekrar])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    if (!telefonGecerliMi(telefon)) {
        surelialert("error", "Telefon numarası geçersiz. Örnek: 05XXXXXXXXX");
        return;
    }

    var sifreKontrol = sifreGecerliMi(sifre, sifre_tekrar);
    if (sifreKontrol !== true) {
        surelialert("error", sifreKontrol);
        return;
    }

    if (!gecerliEmailMi(email)) {
        surelialert("error", "Geçerli bir e-posta adresi giriniz!");
        return;
    }
    formPost("post_admin_musteri_kaydet", {ad, soyad, email, telefon, tc_no, sifre, sifre_tekrar}, "anasayfa");
}
function admin_randevu_al(){
    
    var musteri_id = $("#musteri_id").val().trim();
    var traktor_id = $("#traktor_id").val().trim();
    var sorun_tanimi = $("#sorun_tanimi").val().trim();
    var randevu_tarih = $("#randevu_tarih").val().trim();
    var randevu_saat = $("#randevu_saat").val().trim();
    

    if (bosAlanVarMi([musteri_id, sorun_tanimi, randevu_tarih, randevu_saat, traktor_id])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    formPost("post_admin_randevu_al", {
        musteri_id, traktor_id, sorun_tanimi, randevu_tarih, randevu_saat
    }, "gelenRandevu");
    
}
function personel_randevu_al(){
    
    var musteri_id = $("#musteri_id").val().trim();
    var traktor_id = $("#traktor_id").val().trim();
    var sorun_tanimi = $("#sorun_tanimi").val().trim();
    var randevu_tarih = $("#randevu_tarih").val().trim();
    var randevu_saat = $("#randevu_saat").val().trim();
    

    if (bosAlanVarMi([musteri_id, sorun_tanimi, randevu_tarih, randevu_saat, traktor_id])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    formPost("post_personel_randevu_al", {
        musteri_id, traktor_id, sorun_tanimi, randevu_tarih, randevu_saat
    }, "gelenRandevu");
    
}
function birim_fiyat_verileri(seri_no, olusturulma_tarihi){
    birim_fiyat_seri_no = seri_no;
    birim_fiyat_olusturulma_tarihi = olusturulma_tarihi;
    
}
function var_olan_stok_ekleme_bilgileri(seri_no, kategori_id, alt_kategori_id, marka, tedarikci_id){
    yeni_stok_seri_no = seri_no;
    yeni_kategori_id = kategori_id;
    yeni_alt_kategori_id = alt_kategori_id;
    yeni_marka = marka;
    yeni_tedarikci_id = tedarikci_id;
}
function var_olan_stok_ekle(){
    var alis_tarihi = $("#alis_tarihi").val();
    var garanti_suresi = $("#garanti_suresi").val();
    var adet = $("#adet").val();
    var birim_fiyat = $("#birim_fiyat").val();
    var kdv_orani = $("#kdv_orani").val();
    var kritik_seviye = $("#kritik_seviye").val();
    var kdvDurumu = $('input[name="kdv_durumu"]:checked').val();


    if (bosAlanVarMi([alis_tarihi, garanti_suresi, adet, birim_fiyat, kdv_orani, kdvDurumu, kritik_seviye])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }

    formPost("post_admin_yeni_stok_ekle", {
        alis_tarihi, garanti_suresi, adet, birim_fiyat, kdv_orani, kdvDurumu, kritik_seviye,
        yeni_stok_seri_no, yeni_kategori_id, yeni_alt_kategori_id, yeni_marka, yeni_tedarikci_id
    }, "stokYonetimi");

}
function personeller_guncelleme_verileri(personel_id){
    personel_guncelleme_id = personel_id;
}
function stok_sil(seri_no,olusturulma_tarihi){
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu Stok bilgilerini silmek istediğinize emin misiniz?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'Vazgeç'
    }).then((result) => {
        if (result.isConfirmed) {
            formPost("post_stok_sil", { seri_no: seri_no, olusturulma_tarihi: olusturulma_tarihi }, "stokYonetimi");
        }
    });
}
function birim_fiyat_guncelle(){
     var birim_fiyat_guncelle = $("#birim_fiyat_guncelle").val();
      if (bosAlanVarMi([birim_fiyat_guncelle])) {
        surelialert("warning", "Lütfen tüm alanları doldurunuz!");
        return;
    }
    formPost("post_birim_fiyat_guncelle", {
        birim_fiyat_guncelle, birim_fiyat_seri_no, birim_fiyat_olusturulma_tarihi
    }, "stokYonetimi");
}
function form_guncelle(){
    var gorevTanimi = $("#gorevTanimi").val();
    var calismaDurumu = $("#calismaDurumu").val();

     if (bosAlanVarMi([gorevTanimi])) {
        surelialert("warning", "Görev Tanımı Boş Bırakılamaz!");
        return;
    }

    formPost("post_formGuncelle", {
      gorevTanimi, calismaDurumu, personel_guncelleme_id
    }, "teknikPersoneller");
}
function kategori_ekle_sayfası(){
    var kategori_adi = $("#kategori_adi").val();

    if (bosAlanVarMi([kategori_adi])) {
        surelialert("warning", "Kategori Adı Girin!");
        return;
    }

     formPost("post_kategori_ekle_sayfası", {
        kategori_adi
    }, "kategoriIslem");
    
}
function alt_kategori_ekle_sayfası(){
    var alt_kategori_adi = $("#alt_kategori_adi").val();
    var kategori_id = $("#kategori_id").val();

     if (bosAlanVarMi([alt_kategori_adi])) {
        surelialert("warning", "Yedek Parça Adı Girin!");
        return;
    }
    if (bosAlanVarMi([kategori_id])) {
        surelialert("warning", "Kategori Seçin!");
        return;
    }

     formPost("post_alt_kategori_ekle_sayfası", {
        alt_kategori_adi, kategori_id
    }, "kategoriIslem");
    
}
function kategori_sil() {
    var kategori_id_sil = $("#kategori_id_sil").val();
    if (bosAlanVarMi([kategori_id_sil])) {
        surelialert("warning", "Kategori Seçin!");
        return;
    }

    formPost("post_kategori_sil", {
        kategori_id_sil
    }, "kategoriIslem"); 
}
function alt_kategori_sil() {
    var alt_kategori_id_sil = $("#alt_kategori_id_sil").val();
    if (bosAlanVarMi([alt_kategori_id_sil])) {
        surelialert("warning", "Yedek Parça Adı Seçin!");
        return;
    }

    formPost("post_alt_kategori_sil", {
        alt_kategori_id_sil
    }, "kategoriIslem"); 
}
function servis_turu_kaydet(){
    var servisTurAdi = $("#servisTurAdi").val();

    if (bosAlanVarMi([servisTurAdi])) {
        surelialert("warning", "Servis Adı Girin!");
        return;
    }

     formPost("post_servis_turu_kaydet", {
        servisTurAdi
    }, "servisTurIslem");
    
}
function servis_turu_sil(id) {
    formPost("post_servis_turu_sil", {
        id
    }, "servisTurIslem"); 
}

 


