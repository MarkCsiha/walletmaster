@extends('layout')
@section('content')

<main class="container pb-2">
      <div class="col-md-9">
            @if (session('success'))
                    <p class="text text-success text-center">{{session("success")}}</p>
            @endif
        </div>
  <form id="filtersForm" method="POST" action="/main">
    @csrf

    <div class="row">
      <div class="col-md-3">
        <label>Kategória</label>
        <select name="category" class="form-control">
          <option value="">Összes</option>
          @foreach ($labels as $label)
            <option value="{{ $label }}" {{ ($selectedCategory ?? '') === $label ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-3">
        <label>Mettől</label>
        <input type="date" name="from" class="form-control" value="{{ $from ?? '' }}">
      </div>

      <div class="col-md-3">
        <label>Meddig</label>
        <input type="date" name="to" class="form-control" value="{{ $to ?? '' }}">
      </div>

      <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary w-100" type="submit">Szűrés</button>
      </div>
    </div>
  </form>
  <div class="col-md-3">
    <form action="main.charts" method="POST" id="categoryChart">
        @csrf
        <button type="submit">Kategóriák</button>
    </form>
  </div>
    <div class="col-md-3">
        <form action="main.spentincome" method="POST" id="spentIncome">
            @csrf
            <button type="submit">Költség - kiadás</button>
        </form>
  </div>
  <div class="row mt-4">
    <div class="col-md-6">
      <h4 class="text-center">Oszlopdiagram</h4>
      <canvas id="myChart"></canvas>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    const labels = {!! json_encode($labels) !!};
    const data = {!! json_encode($data) !!};
</script>
@endsection
