<?php
// Web sayfası üzerine genel fonksiyonlar oluşturulacak
class FONK {
    public function parseUrl() {
        if(isset($_GET["url"])) {
            return explode("/", $_GET["url"]);
        }
    } 
    
    public function goruntu($yetki="musteri",$goruntu="_404", $veri=[], $duzen="sayfa") {
        if($duzen=="sayfa") {
            require_once "sayfalar/".$yetki."/sabitler/header.php";
            require_once "sayfalar/".$yetki."/".$goruntu.".php";
            require_once "sayfalar/".$yetki."/sabitler/footer.php";
        } else if ($duzen == "tek") {
            require_once "sayfalar/".$yetki."/".$goruntu.".php";
        }        
    }

    public function tarihYaz($format='Y/m/d') {
        return date($format, time());
    }

    public function getKullanicilar() {
        return DB->query("SELECT * FROM kullanicilar");
    }

    public function getKullanicilarById($Id) {
        return DB->row("SELECT * FROM kullanicilar where id=:id", 
                        array("id"=>$Id));
    }

}