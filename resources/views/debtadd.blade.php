@extends("layout")
@section("content")

<main class="container pb-2">
 <form id="debtForm" method="POST" action="/debtadd">
        @csrf
        <label class="form-label mt-3" for="debtToFrom">Ki tartozik:</label>
        <select name="debtToFrom" id="debtToFrom">
            <option value="debtTo">Én</option>
            <option value="debtFrom">A másik fél</option>
        </select>
        <label for="name" class="form-label mt-3">Mi a neve?</label>
        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name">

        <label for="username" class="form-label mt-3">Mi a felhasználóneve? (Ha nem WalletMaster felhasználó, kérjük hagyja üresen)</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" type="text" name="username" id="username">

        <label for="debtAmount" class="form-label mt-3">Összeg: </label>
        <input type="number" class="form-control @error('amount') is-invalid @enderror" name="debtAmount" id="debtAmount">

         <label for="description" class="form-label mt-3">Leírás, ha szükséges: </label>
        <input type="textbox" class="form-control @error('description') is-invalid @enderror" type="text" name="description" id="description">

        <label for="debtDate" class="form-label mt-3">Dátum: </label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" name="debtDate" id="debtDate">

        <button type="submit">Tartozás felvitele</button>

</main>
@endsection
