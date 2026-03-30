@push('reset-css')
    <link rel="stylesheet" href="{{ asset('resetpass.css') }}">
@endpush
<form method="POST" action="/reset-password">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email" hidden>Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $email ?? request('email')) }}"
            required autofocus hidden>
        @error('email')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="password">Új jelszó: </label>
        <input id="password" type="password" name="password" class="rounded-pill" required>
        @error('password')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="password_confirmation">Jelszó újra: </label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="rounded-pill" required>
    </div>
    <div class="btn">
        <button type="submit">Jelszó megváltoztatása</button>
    </div>

</form>
