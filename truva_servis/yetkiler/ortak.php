<?php
class ortak {
    //bu fonksiyon ile js dosyası oluşturdum
    public function baslik() {
        Header("content-type: application/x-javascript");
        echo 'var anadizin = "' . ANASAYFA . '";                
                var url = window.location.href;
                console.log("baslik geldi");';
    }

    public function cikis_yap() {
        session_destroy(); 
        header("Location: anasayfa");       
    }

    public function _404() {
        FONK->goruntu("ortak", "_404", ["title"=>"404 Sayfası"], "tek");
    }

    public function tc_kimlik_dogrula($tc) {
    if (!preg_match('/^[1-9][0-9]{10}$/', $tc)) return false;

    $digits = str_split($tc);
    $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8];
    $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7];

    $digit10 = (($odd_sum * 7) - $even_sum) % 10;
    $digit11 = (array_sum(array_slice($digits, 0, 10))) % 10;

    return ($digit10 == $digits[9] && $digit11 == $digits[10]);
}


}