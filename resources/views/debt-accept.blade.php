@extends("layout")
@section("content")
<main class="container pb-2">

    <form class="card-body" action="{{ route('debts.accept', ['id' => $id->tartozasok_id]) }}" method="post">
        @csrf
        <input type="hidden" name="action" value="elfogadva">

        <button class="btn btn-success" type="submit" name="accept" id="accept">Elfogadom</button>
    </form>
    <form class="card-body" action="/debt-accept" method="post">
        @csrf
        <input type="hidden" name="action" value="elutasítva">

        <button class="btn btn-danger" type="submit" name="reject" id="reject">Visszautasítom</button>
    </form>
</main>

@endsection
