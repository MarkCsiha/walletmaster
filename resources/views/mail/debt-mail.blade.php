<x-mail::message>
     <div style="text-align:center; margin-bottom:20px;">
        <img src="{{ asset('images/logo.png') }}" alt="WalletMaster" width="160">
    </div>
    <h2>Tisztelt felhasználónk!</h2>
    <p>Önnek tartozási kérelmet nyújtottak be, melyet az alábbi linken tud elfogadni, vagy visszautasítani.</p>

    {{-- https://laravel.com/docs/12.x/urls --}}
    <x-mail::button :url="URL::signedRoute('debts.decision',  $tartozas->tartozasok_id)">
        Tartozás megnyitása
    </x-mail::button>

Üdvölettel,<br>
{{ config('app.name') }} csapata
</x-mail::message>
