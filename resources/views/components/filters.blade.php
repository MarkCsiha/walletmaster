<div>
    <div class="row">
        <div class="col-md-3">
            <label for="category">Kategória</label>
            <select name="category" id="category" class="form-control">
                @foreach ($data as $szamla)
                    <option value="{{ $szamla->kategoria_nev }}">{{ $szamla->kategoria_nev }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <form action="filtersForm" method="POST" action="/main">
            <label for="From">Mettől</label>
            <input type="date" id="from" name="from" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="To">Meddig</label>
            <input type="date" id="to" name="to" class="form-control">
        </div>
        <div class="col-md-3">
            <button type="submit">Szűrés</button>
        </div>
    </form>
    </div>
</div>
