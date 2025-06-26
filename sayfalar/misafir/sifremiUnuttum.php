<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Şifremi Unuttum</title>
        <script src="<?=ANASAYFA?>baslik"></script>
        <link rel="stylesheet" href="<?=CSSLER ?>sifremiUnuttum.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="icon" type="image/png" href="<?=RESIMLER?>logo2.png">
    </head>
        <body>
            <div class="wrapper">
                <form action="">
                    <div class="input-box">
                        <input type="email" name="email" placeholder="E-Posta adresinizi giriniz" required>
                        <i class="bx bxs-envelope"></i>
                    </div>

                    <button type="submit" class="btn">Gönder</button>

                    <div class="register-link">
                        <p>Şifrenizi biliyor musunuz? <a href="<?=ANASAYFA?>giris_yap">Giriş Yap</a></p>
                    </div>


                </form>
            </div>
        
        </body>
</html>