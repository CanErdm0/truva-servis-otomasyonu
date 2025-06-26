<?php
$isim = "https://truva-traktor.com/";


define("ANASAYFA", $isim);
define("TITLE", "TRUVA TRAKTÖR");
define("RESIMLER", $isim . "assets/images/");
define("CSSLER", $isim . "assets/css/");
define("JSLER", $isim . "assets/js/");
define("TEMA", $isim . "assets/tema/AdminLTE-4.0.0-beta3/");  

/*
dosya import etme
include         : dosyayı getirir
include_once    : bu dosya daha önce geldiyse tekrar getirme
require         : dosyayı getirir. dosya yoksa hata verip çalışmayı durdurur
require_once    : require ile aynı. dosya bir defa getirilir
*/
require_once 'fonksiyonlar.php';
require_once 'kontroller.php';
define("FONK", new FONK());

require_once 'veritabani/Db.class.php';
define("DB", new Db());

$kontroller = new Kontroller();

//print_r(FONK->parseUrl()); // new ile tanımlanmış değişken içerisinen fonksiyon
//echo FONK::tarihYaz(); // static bir sıfın içerisindeki fonksiyon çalışır

//https://github.com/wickyaswal/php-my-sql-pdo-database-class/tree/master
//https://github.com/ColorlibHQ/AdminLTE/releases