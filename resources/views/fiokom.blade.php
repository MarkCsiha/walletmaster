@extends("layout")

@push("account-css")
    <link rel="stylesheet" href="{{asset('css/account.css')}}">
@endpush

@section("content")
<div class="container py-5">
    <h2 class="mb-4">Felhasználói beállítások</h2>
    <form>
        <div class="row mb-4">
            <div class="col-md-6">
                <h4>Személyes adatok</h4>
                <div class="mb-3">
                    <label for="fullName" class="form-label">Vezetéknév: </label>
                    <input type="text" class="form-control rounded-pill" id="veznev" value="{{ Auth::user()->vez_nev }}">
                </div>
                <div class="mb-3">
                    <label for="fullName" class="form-label">Keresztnév: </label>
                    <input type="text" class="form-control rounded-pill" id="kernev" value="{{   Auth::user()->ker_nev }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email cím </label>
                    <input type="email" class="form-control rounded-pill" id="email" value="{{ Auth::user()->email }}">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefonszám </label>
                    <input type="tel" class="form-control rounded-pill" id="phone" value="{{ Auth::user()->telszam }}">
                </div>
            </div>
        </div>

        <details>
            <summary><h4> Jelszó megváltoztatása </h4></summary>
            <div class="row mb-4">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Jelenlegi jelszó</label>
                        <input type="password" class="form-control rounded-pill" id="currentPassword">
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Új jelszó</label>
                        <input type="password" class="form-control rounded-pill" id="newPassword">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Új jelszó megerősítése</label>
                        <input type="password" class="form-control rounded-pill" id="confirmPassword">
                    </div>
                </div>
            </div>
        </details>


        <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-secondary btn-lg"><a href="/kijelentkezes">Kijelentkezés</a></button>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-secondary btn-lg">Visszavonás</button>
            <button type="submit" class="btn btn-primary btn-lg">Mentés</button>
        </div>
    </form>
</div>
@endsection
