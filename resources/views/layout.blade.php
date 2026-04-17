<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>WalletMaster</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/WMFavIcon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @stack('mainstyle-css')
    @stack('goals-css')
    @stack('add-css')
    @stack('regisztracio-css')
    @stack('belepes-css')
    @stack('layout-css')
    @stack('account-css')
    @stack('loading-css')
    @stack('debt-css')
    @stack('forgot-css')
    @stack('reset-css')
    @stack('verify-css')
    @stack('limit-css')
    @stack('pending-css')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0"></script>
    @livewireStyles
    @include('sweetalert::alert')

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container px-lg-5">
            @if (Auth::check())
                <a class="navbar-brand" href="/main">WalletMaster</a>
            @else
                <a class="navbar-brand" href="/">WalletMaster</a>
            @endif
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item ms-4 me-4 pb-2 pt-2 d-flex align-items-center">
                            <a href="/login" class="btn rounded-pill d-flex align-items-center gap-2 loginBtn">
                                <span class="bi bi-person"></span>
                                <span>Bejelentkezés</span>
                            </a>
                        </li>
                        <li class="nav-item ms-4 me-4 pb-2 pt-2 d-flex align-items-center">
                            <a href="/registration" class="btn rounded-pill d-flex align-items-center gap-2 registrationBtn">
                                <span class="bi bi-person"></span>
                                <span>Regisztráció</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-4 me-4 pb-2 pt-2 d-flex align-items-center"><a href="/">Rólunk</a></li>
                        <li class="nav-item ms-4 me-4 pb-2 pt-2 d-flex align-items-center"><a href="/limit">Számla adataim</a></li>
                        <li class="nav-item ms-4 me-4 pb-2 pt-2 d-flex align-items-center"><a href="/debt" class="bi bi-coin">Tartozások</a></li>
                        <li class="nav-item ms-4 me-4 pb-2 pt-2 d-flex align-items-center"><a href="/goals" class="bi bi-bullseye"> Céljaim</a>
                        </li>
                        <li class="nav-item ms-4 me-4 pb-2 pt-2 d-flex align-items-center"><a href="/main">Főoldal</a></li>
                        <li class="nav-item ms-4 me-4 pb-2 pt-2 d-flex align-items-center"><a href="/account"><span
                                    class="bi bi-person"></span></a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="py-5 bg-dark">
        <div class="container pt-3 text-white">
            <h5>Elérhetőségek: </h5>
            <hr>
            <div class="row justify-content-center col-sm">
                <div class="col-sm">
                    <p>
                        Készítették: <br> Csiha Márk, Szabó Máté László
                        <br>
                    <p>Terebély Károly Technikum</p>
                    <span>Észrevétele van?</span> <a href="/review" class="footerReview">Írjon nekünk!</a>
                    </p>
                    <p>Minden jog fenntartva © {{ now()->year }} WalletMaster</p>
                </div>

                <div class="d-flex col-sm">
                    <div class="vr" id="no-mobile"></div>
                </div>
                <div class="row justify-content-center col-sm">
                    <span class="bi bi-telephone"> <a href="tel:06700216634"> 06 70 021 6634</a></span>
                    <span class="bi bi-envelope"> <a href="mailto:sigmawallet01@gmail.com">
                            walletmaster01@gmail.com</a></span>
                    <span class="bi bi-instagram"> <a href="https://www.instagram.com/walletmaster01/" target="_blank">
                            WalletMaster</a></span>
                    <span class="bi bi-facebook"> <a href="https://www.facebook.com/mate.szabo.5074644?locale=hu_HU"
                            target="_blank"> WalletMaster</a></span>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/charts.js') }}"></script>
    <script src="{{ asset('js/charts-spentincome.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/autologout.js') }}"></script>
</body>

</html>
