<!DOCTYPE html>
        <html lang="tr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Kaydol</title>
                <link rel="stylesheet" href="<?= CSSLER ?>kaydol.css">
                <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
                <script src="<?=ANASAYFA?>baslik"></script>
                <link rel="icon" type="image/png" href="<?=RESIMLER?>logo2.png">
            </head>
            <body>
                <div class="wrapper">
                            <h1>KAYDOL</h1>

                             <div class="input-box">
                                <input type="text" name="ad" placeholder="Ad" id="ad" required>
                                <i class="bx bxs-user"></i>
                            </div>
                            <div class="input-box">
                                <input type="text" name="soyad" placeholder="Soyad" id="soyad" required>
                                <i class="bx bxs-user"></i>
                            </div>

                            <div class="input-box">
                                <input type="text" name="tc_no" placeholder="T.C. Kimlik Numarası" id="tc_no" required>
                                <i class="bx bxs-id-card"></i>
                            </div>


                            <div class="input-box">
                                <input type="email" name="email" placeholder="E-Posta" id="email" required>
                                <i class="bx bxs-envelope"></i>
                            </div>

                            <div class="input-box">
                                <input 
                                id="telefon"
                                    type="tel" 
                                    name="telefonNo" 
                                    placeholder="Telefon (05xx xxx xx xx)" 
                                    required 
                                    pattern="^0?5\d{2} ?\d{3} ?\d{2} ?\d{2}$" 
                                    maxlength="11" 
                                    title="Telefon numarası 10 haneli olmalı ve 5 ile başlamalıdır."
                                    inputmode="tel"
                                >
                                <i class="bx bxs-phone"></i>
                            </div>

                            

                            <div class="input-box">
                                <input type="password" id="sifre" name="sifre" placeholder="Şifre" required>
                                <i class='bx bxs-show toggle-eye' onclick="togglePassword('sifre', this)"></i> <!--  göz -->
                                <i class='bx bxs-lock-alt'></i> <!--  kilit -->
                            </div>

                            <div class="input-box">
                                <input type="password" id="sifre_tekrar" name="sifre_tekrar" placeholder="Şifre Tekrar" required>
                                <i class='bx bxs-show toggle-eye' onclick="togglePassword('sifre_tekrar', this)"></i> <!-- göz -->
                                <i class='bx bxs-lock'></i> <!-- kilit -->
                            </div>


                            <button type="button" class="btn" id="btn_kaydol" onclick="kaydol(this)">Kaydol</button>

                            <div class="register-link">
                                <p>Zaten hesabın var mı? <a href="<?=ANASAYFA?>giris_yap">Giriş Yap</a></p>
                            </div>
                </div>





                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="<?=JSLER?>fonksiyonlar.js"></script>
            </body>
    </html>
