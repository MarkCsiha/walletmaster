<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WalletMaster</title>
        <link rel="icon" type="image/x-icon" href="{{asset('img/wallet.svg')}}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('css/layout.css')}}">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="/">WalletMaster</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @guest
                            <li class="nav-item"><a href="/login" class="btn btn-secondary">Bejelentkezés</a></li>
                            <li class="nav-item ms-4 me-4"><a href="/registration" class="btn btn-success bi bi-person">Regisztráció</a></li>
                        @else
                            <li class="nav-item ms-4 me-4"><a href="/main" class="btn btn-dark">Főoldal</a></li>
                            <li class="nav-item ms-4 me-4"><a href="/add" class="btn btn-dark">Hozzáadás</a></li>
                            <li class="nav-item ms-4 me-4"><a href="/goals" class="btn btn-dark">Céljaim</a></li>
                            <li class="nav-item ms-4 me-4"><a href="/account" class="btn btn-success">Profilom<i class="bi bi-person fs-4"></i></a></li>
                            <li class="nav-item ms-4 me-4"><a href="/logout" class="btn btn-success bi bi-person">Kijelentkezés</a></li>
                        @endguest
                      </ul>
                </div>
            </div>
        </nav>

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

                <div class="d-flex col-sm ">
                    <div class="vr"></div>
                </div>
                <div class="row justify-content-center col-sm">
                    <p><span class="bi bi-telephone"></span> <a class="link-light" href="tel:0666123456">06 70 628 9983</a><br> </p>
                    <p><span class="bi bi-telephone"></span> <a class="link-light" href="tel:0666123456">06 70 536 0256</a><br> </p>
                    <p><span class="bi bi-envelope"></span>  <a class="link-light" href="mailto:hivatal@pusztaszentmaria.hu">  smatelaszlo26@gmail.com</a><br> </p>
                    <p><span class="bi bi-envelope"></span>  <a class="link-light" href="mailto:hivatal@pusztaszentmaria.hu">  csihamark46@gmail.com</a><br> </p>
                    <p><span class="bi bi-instagram"></span> <a class="link-light" href="https://www.instagram.com/walletmaster01/"> mateszabo26</a><br> </p>
                    <p><span class="bi bi-facebook"></span>  <a class="link-light" href="https://www.facebook.com/mate.szabo.5074644?locale=hu_HU"> Szabó Máté</a><br> </p>
                    <p><span class="bi bi-facebook"></span>  <a class="link-light" href="https://www.facebook.com/csiha.mark.7?locale=hu_HU"> Csiha Márk</a> </p>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/charts.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
