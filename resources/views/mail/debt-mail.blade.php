<x-mail::message>
Tisztelt felhasználónk!

Önnek tartozási kérelmet nyújtottak be, melyet az alábbi linken tud elfogadni, vagy visszautasítani.

{{-- https://laravel.com/docs/12.x/urls --}}
<x-mail::button :url="URL::signedRoute('debts.decision', ['id' => $tartozas->tartozasok_id])">
    Tartozás megnyitása
</x-mail::button>

Üdvölettel,<br>
{{ config('app.name') }} csapata
</x-mail::message>
