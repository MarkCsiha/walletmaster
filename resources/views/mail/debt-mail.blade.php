<x-mail::message>
# Introduction

The body of your message.

{{-- https://laravel.com/docs/12.x/urls --}}
<x-mail::button :url="URL::signedRoute('debts.decision', ['id' => $tartozas->tartozasok_id])">
    Tartozás megnyitása
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
