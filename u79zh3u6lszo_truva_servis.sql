-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 26 Haz 2025, 16:04:12
-- Sunucu sürümü: 10.6.21-MariaDB-cll-lve
-- PHP Sürümü: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `u79zh3u6lszo_truva_servis`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adminler`
--

CREATE TABLE `adminler` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

--
-- Tablo döküm verisi `adminler`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adresler`
--

CREATE TABLE `adresler` (
  `id` int(11) NOT NULL,
  `sehir` varchar(100) DEFAULT NULL,
  `ilce` varchar(100) DEFAULT NULL,
  `mahalle` varchar(100) DEFAULT NULL,
  `cadde` varchar(100) DEFAULT NULL,
  `sokak` varchar(100) DEFAULT NULL,
  `daire` varchar(20) DEFAULT NULL,
  `ulke` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

--
-- Tablo döküm verisi `adresler`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `alt_kategoriler`
--

CREATE TABLE `alt_kategoriler` (
  `id` int(11) NOT NULL,
  `kategoriler_id` int(11) DEFAULT NULL,
  `alt_kategoriler_adi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ariza_kayitlari`
--

CREATE TABLE `ariza_kayitlari` (
  `id` int(11) NOT NULL,
  `musteri_id` int(11) DEFAULT NULL,
  `traktor_id` int(11) DEFAULT NULL,
  `servis_turu` varchar(255) DEFAULT NULL,
  `gelis_tarihi` date DEFAULT NULL,
  `teslim_tarihi` date DEFAULT NULL,
  `ucret` decimal(10,2) DEFAULT NULL,
  `garanti` varchar(500) DEFAULT NULL,
  `aciklama` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `id` int(11) NOT NULL,
  `kategoriler_adi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) DEFAULT NULL,
  `soyad` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `sifre` varchar(255) DEFAULT NULL,
  `rol` enum('admin','personel','musteri') DEFAULT NULL,
  `tc_no` varchar(11) DEFAULT NULL,
  `dogum_tarihi` date DEFAULT NULL,
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `adres_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteriler`
--

CREATE TABLE `musteriler` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

--
-- Tablo döküm verisi `musteriler`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personeller`
--

CREATE TABLE `personeller` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `pozisyon` varchar(100) DEFAULT NULL,
  `durum` enum('Aktif','Pasif','İzinli','Ayrıldı') DEFAULT 'Aktif',
  `ise_baslama_tarihi` date DEFAULT NULL,
  `isten_ayrilma_tarihi` date DEFAULT NULL,
  `kan_grubu` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

--
-- Tablo döküm verisi `personeller`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `randevular`
--

CREATE TABLE `randevular` (
  `id` int(11) NOT NULL,
  `musteri_id` int(11) DEFAULT NULL,
  `traktor_id` int(11) DEFAULT NULL,
  `randevu_tarih` date DEFAULT NULL,
  `randevu_saat` time DEFAULT NULL,
  `sorun_tanimi` text DEFAULT NULL,
  `durum` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `servis_turu`
--

CREATE TABLE `servis_turu` (
  `id` int(11) NOT NULL,
  `ad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stoklar`
--

CREATE TABLE `stoklar` (
  `id` int(11) NOT NULL,
  `seri_no` varchar(100) NOT NULL,
  `marka` varchar(100) NOT NULL,
  `tedarikci_id` int(11) NOT NULL,
  `kritik_seviye` int(11) NOT NULL,
  `alis_tarihi` date NOT NULL,
  `garanti_suresi` int(11) NOT NULL,
  `adet` int(11) NOT NULL,
  `satin_alinan_adet` int(11) DEFAULT NULL,
  `birim_fiyat` decimal(10,2) NOT NULL,
  `satis_fiyati` decimal(10,2) DEFAULT NULL,
  `kdv_orani` decimal(5,2) NOT NULL,
  `kdvDurumu` enum('dahil','haric') NOT NULL,
  `olusturulma_tarihi` datetime DEFAULT current_timestamp(),
  `guncellenme_tarihi` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kategoriler_id` int(11) DEFAULT NULL,
  `alt_kategoriler_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stok_hareketleri`
--

CREATE TABLE `stok_hareketleri` (
  `id` int(11) NOT NULL,
  `seri_no` varchar(100) NOT NULL,
  `marka` varchar(100) NOT NULL,
  `kategoriler_adi` varchar(50) DEFAULT NULL,
  `alt_kategoriler_adi` varchar(50) DEFAULT NULL,
  `miktar` int(11) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `tarih` datetime DEFAULT current_timestamp(),
  `musteri_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tedarikciler`
--

CREATE TABLE `tedarikciler` (
  `id` int(11) NOT NULL,
  `ad` varchar(255) DEFAULT NULL,
  `yetkili_ad` varchar(100) DEFAULT NULL,
  `yetkili_soyad` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `tedarikci_kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `web_adresi` varchar(255) DEFAULT NULL,
  `aciklama` text DEFAULT NULL,
  `adres_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

--
-- Tablo döküm verisi `tedarikciler`
--


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `traktorler`
--

CREATE TABLE `traktorler` (
  `id` int(11) NOT NULL,
  `musteri_id` int(11) DEFAULT NULL,
  `marka` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `plaka` varchar(50) DEFAULT NULL,
  `sasi_no` varchar(100) DEFAULT NULL,
  `motor_no` varchar(100) DEFAULT NULL,
  `ithal_sasi_no` varchar(100) DEFAULT NULL,
  `model_yili` int(100) DEFAULT NULL,
  `garanti` enum('Garanti Kapsamında','Garanti Dışı','Garanti Durumu Belirsiz') DEFAULT NULL,
  `ruhsat_dosya_yolu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `adminler`
--
ALTER TABLE `adminler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Tablo için indeksler `adresler`
--
ALTER TABLE `adresler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `alt_kategoriler`
--
ALTER TABLE `alt_kategoriler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategoriler_id`);

--
-- Tablo için indeksler `ariza_kayitlari`
--
ALTER TABLE `ariza_kayitlari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `traktor_id` (`traktor_id`),
  ADD KEY `fk_musteri` (`musteri_id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefon` (`telefon`),
  ADD KEY `adres_id` (`adres_id`);

--
-- Tablo için indeksler `musteriler`
--
ALTER TABLE `musteriler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Tablo için indeksler `personeller`
--
ALTER TABLE `personeller`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Tablo için indeksler `randevular`
--
ALTER TABLE `randevular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `musteri_id` (`musteri_id`),
  ADD KEY `traktor_id` (`traktor_id`);

--
-- Tablo için indeksler `servis_turu`
--
ALTER TABLE `servis_turu`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `stoklar`
--
ALTER TABLE `stoklar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tedarikci` (`tedarikci_id`),
  ADD KEY `fk_stoklar_kategori` (`kategoriler_id`),
  ADD KEY `fk_stoklar_alt_kategori` (`alt_kategoriler_id`);

--
-- Tablo için indeksler `stok_hareketleri`
--
ALTER TABLE `stok_hareketleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stok_musteri` (`musteri_id`);

--
-- Tablo için indeksler `tedarikciler`
--
ALTER TABLE `tedarikciler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adres_id` (`adres_id`);

--
-- Tablo için indeksler `traktorler`
--
ALTER TABLE `traktorler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `musteri_id` (`musteri_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `adminler`
--
ALTER TABLE `adminler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `adresler`
--
ALTER TABLE `adresler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `alt_kategoriler`
--
ALTER TABLE `alt_kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ariza_kayitlari`
--
ALTER TABLE `ariza_kayitlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `musteriler`
--
ALTER TABLE `musteriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `personeller`
--
ALTER TABLE `personeller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `randevular`
--
ALTER TABLE `randevular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `servis_turu`
--
ALTER TABLE `servis_turu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `stoklar`
--
ALTER TABLE `stoklar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `stok_hareketleri`
--
ALTER TABLE `stok_hareketleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `tedarikciler`
--
ALTER TABLE `tedarikciler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `traktorler`
--
ALTER TABLE `traktorler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `adminler`
--
ALTER TABLE `adminler`
  ADD CONSTRAINT `adminler_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `alt_kategoriler`
--
ALTER TABLE `alt_kategoriler`
  ADD CONSTRAINT `alt_kategoriler_ibfk_1` FOREIGN KEY (`kategoriler_id`) REFERENCES `kategoriler` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `ariza_kayitlari`
--
ALTER TABLE `ariza_kayitlari`
  ADD CONSTRAINT `ariza_kayitlari_ibfk_1` FOREIGN KEY (`traktor_id`) REFERENCES `traktorler` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_musteri` FOREIGN KEY (`musteri_id`) REFERENCES `musteriler` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD CONSTRAINT `kullanicilar_ibfk_1` FOREIGN KEY (`adres_id`) REFERENCES `adresler` (`id`);

--
-- Tablo kısıtlamaları `musteriler`
--
ALTER TABLE `musteriler`
  ADD CONSTRAINT `musteriler_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `personeller`
--
ALTER TABLE `personeller`
  ADD CONSTRAINT `personeller_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `randevular`
--
ALTER TABLE `randevular`
  ADD CONSTRAINT `randevular_ibfk_1` FOREIGN KEY (`musteri_id`) REFERENCES `musteriler` (`id`),
  ADD CONSTRAINT `randevular_ibfk_2` FOREIGN KEY (`traktor_id`) REFERENCES `traktorler` (`id`);

--
-- Tablo kısıtlamaları `stoklar`
--
ALTER TABLE `stoklar`
  ADD CONSTRAINT `fk_stoklar_alt_kategori` FOREIGN KEY (`alt_kategoriler_id`) REFERENCES `alt_kategoriler` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stoklar_kategori` FOREIGN KEY (`kategoriler_id`) REFERENCES `kategoriler` (`id`),
  ADD CONSTRAINT `fk_tedarikci` FOREIGN KEY (`tedarikci_id`) REFERENCES `tedarikciler` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `stok_hareketleri`
--
ALTER TABLE `stok_hareketleri`
  ADD CONSTRAINT `fk_stok_musteri` FOREIGN KEY (`musteri_id`) REFERENCES `musteriler` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `tedarikciler`
--
ALTER TABLE `tedarikciler`
  ADD CONSTRAINT `tedarikciler_ibfk_1` FOREIGN KEY (`adres_id`) REFERENCES `adresler` (`id`) ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `traktorler`
--
ALTER TABLE `traktorler`
  ADD CONSTRAINT `traktorler_ibfk_1` FOREIGN KEY (`musteri_id`) REFERENCES `musteriler` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
