{{-- resources/views/auth/reset-password.blade.php --}}

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    {{-- nagyon fontos --}}
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
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

    <button type="submit">Jelszó megváltoztatása</button>
</form>
