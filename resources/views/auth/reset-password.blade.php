@push('reset-css')
    <link rel="stylesheet" href="{{asset('resetpass.css')}}">
@endpush
<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div>
{{--Email bekérés nélkül meg kéne oldani--}}
        <label for="email">Email</label>
        <input id="email"
               type="email"
               name="email"
               value="{{ old('email', $email ?? request('email')) }}"
               required
               autofocus>
        @error('email') <div>{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="password">Új jelszó</label>
        <input id="password"
               type="password"
               name="password"
               required>
        @error('password') <div>{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="password_confirmation">Új jelszó újra</label>
        <input id="password_confirmation"
               type="password"
               name="password_confirmation"
               required>
    </div>
    <div class="btn">
        <button type="submit">Jelszó megváltoztatása</button>
    </div>

</form>
