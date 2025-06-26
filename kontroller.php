<?php 
session_start();
//bu sayfada yetkilendirme, sayfa yönlendirme, parametre ayarları
class Kontroller {
    protected $yetki = "misafir";
    protected $metod = "anasayfa";    
    protected $parametre = [];

    public function __construct() {
        if(isset($_SESSION["rol"])) {
            $this->yetki = $_SESSION["rol"];
        }
        require_once "yetkiler/ortak.php";
        require_once "yetkiler/" . $this->yetki . '.php';
        $yetkiDurum = new $this->yetki();
    
        $url = FONK->parseUrl();
        if(isset($url[0])) {   
            if(method_exists($yetkiDurum, $url[0])) {
                $this->metod = $url[0]; 
                unset($url[0]);                
                $this->parametre = $url ? array_values($url) : [];                
            }
            else {
                $this->metod = "_404";
            }
        }
        call_user_func_array([$yetkiDurum, $this->metod], $this->parametre);      
    }
}