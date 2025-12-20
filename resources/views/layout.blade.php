<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Heroic Features - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="#!">WalletMaster</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <button type="button" class="btn btn-secondary">Bejelentkezés</button>
                        <button type="button" class="btn btn-success ms-4 me-4"><a href="/regisztracio">Regisztráció</a></button>
                        <li class="nav-item"><a class="nav-link" href="#!">Rólunk</a></li>
                        <li class="nav-item"><a class="nav-link me-1" href="#!">Kapcsolat
                        </a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        @yield("content")

            <footer class="py-5 bg-dark">
        <div class="container pt-3 text-white">
                    <h5>Elérhetőségek: </h5>
                    <hr>
            <div class="row">
                <div class="col-sm">
                    <p>
                        Készítették: <br> Csiha Márk, Szabó Máté László
                        <br>
                        <p>Terebély Károly Sigmaképző Technikum</p>
                        <p>2025-2026</p>
                    </p>
                </div>
                <div class="row justify-content-center col-sm">
                    <p>
                        Telefon1:   <a class="link-light" href="tel:0666123456">06 70 628 9983</a><br>
                        Telefon2:   <a class="link-light" href="tel:0666123456">06 70 536 0256</a><br>
                        E-mail1:    <a class="link-light" href="mailto:hivatal@pusztaszentmaria.hu">smatelaszlo26@gmail.com</a><br>
                        E-mail2:    <a class="link-light" href="mailto:hivatal@pusztaszentmaria.hu">csihamark46@gmail.com</a><br>
                        Instagram1: <a class="link-light" href="https://www.instagram.com/mateszabo26/"> mateszabo26</a><br>
                        Instagram2: <a class="link-light" href="https://www.instagram.com/markcsiha/"> markcsiha</a>
                        Facebook1:  <a class="link-light" href="https://www.facebook.com/mate.szabo.5074644?locale=hu_HU"> Szabó Máté</a><br>
                        Facebook2:  <a class="link-light" href="https://www.facebook.com/csiha.mark.7?locale=hu_HU"> Csiha Márk</a>
                    </p>

                </div>
            </div>
        </div>
    </footer>
    </body>
</html>