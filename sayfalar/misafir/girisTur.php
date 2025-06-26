<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Giriş Tür</title>
        <link rel="stylesheet" href="<?=CSSLER ?>girisTur.css">
        <script src="<?=ANASAYFA?>baslik"></script>
        <link rel="icon" type="image/png" href="<?=RESIMLER?>logo2.png">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    </head>
        <body>
            <div class="wrapper"> 
                <form action="">
                <h1>TRUVA TRAKTÖR</h1>

                <button type="button" class="btn" onclick="window.location.href='<?= ANASAYFA ?>giris_yap'">Yönetici</button>
                <button type="button" class="btn" onclick="window.location.href='<?= ANASAYFA ?>giris_yap'">Teknik Personel</button>
                <button type="button" class="btn" onclick="window.location.href='<?= ANASAYFA ?>giris_yap'">Müşteri</button>

                

                </form>
            </div>
        
        </body>
</html>