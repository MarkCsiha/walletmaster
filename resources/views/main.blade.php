@extends('layout')

@section('content')
<main class="container pb-2">

  <form id="filtersForm" method="POST" action="{{ url('/main') }}">
    @csrf

    <div class="row">
      <div class="col-md-3">
        <label>Kategória</label>
        <select name="category" class="form-control">
          <option value="">Összes</option>
          @foreach ($userSpending as $cat)
            <option value="{{ $cat }}" {{ ($selectedCategory ?? '') === $cat ? 'selected' : '' }}>
              {{ $cat }}
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
  const labels = @json($labels ?? []);
  const data   = @json($data ?? []);

</script>
@endsection
