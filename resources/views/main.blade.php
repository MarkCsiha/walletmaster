@extends('layout')
@push('mainstyle-css')
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endpush
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
  <div class="col-md-3">
    <button type="button" id="btnToggle">Váltás (bar ↔ doughnut)</button>
  </div>
  <div class="row mt-4">
    <div class="col-md-6">
      <h4 class="text-center">Oszlopdiagram</h4>
      <canvas id="myChart"></canvas>
    </div>
  </div>
   <div class="row mt-3">
            <div class="col r-3" id="outerpanel">

                <div class="card" id="kartya">
                    <div class="card-body">
                        {{-- ÉV + HÓNAP --}}
                        <div class="text-center mb-2">
                            <h2 class="m-0">{{ $monthStart->year }}</h2>
                            <h4 class="text-muted mt-1">{{ $monthStart->translatedFormat('F') }}</h4>
                        </div>

                        {{-- HÓNAP VÁLTÁS --}}
                        <div class="d-flex justify-content-between mb-2">
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('naptar', ['ym' => $prevYm]) }}">
                                Előző
                            </a>

                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('naptar', ['ym' => $nextYm]) }}">
                                Következő
                            </a>
                        </div>

                        {{-- NAPTÁR --}}
                        <table class="border border-striped" id="calendar">
                            <tr id="calendar_th">
                                <th>Hétfő</th>
                                <th>Kedd</th>
                                <th>Szerda</th>
                                <th>Csütörtök</th>
                                <th>Péntek</th>
                                <th>Szombat</th>
                                <th>Vasárnap</th>
                            </tr>

                            @foreach(array_chunk($days, 7) as $week)
                                <tr>
                                    @foreach($week as $day)
                                        @php
                                            $inMonth = $day->month === $monthStart->month;
                                        @endphp

                                        <td style="height: 60px; vertical-align: top;" class="{{ $inMonth ? '' : 'text-danger' }}">
                                            <div style="font-weight: 700;">
                                                {{ $day->day }}
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

              <div class="mt-3">

            <div class="card">
                <div class="card-body">

                    <table class="table table bordered">
                        <tr>
                            <th>Összeg</th>
                            <th>Honnan</th>
                            <th>Leíras</th>
                            <th>Kategoria</th>
                            <th>Rendszeres</th>
                            <th>Dátum</th>
                        </tr>

                        @foreach ($result as $szamlak)
                            <tr>
                                <td>
                                    @if($szamlak->tipus == 0)
                                        <span class="text-danger">- {{$szamlak->osszeg}} Ft</span>
                                    @else
                                        <span class="text-success">+ {{$szamlak->osszeg}} Ft</span>
                                    @endif
                                </td>
                                <td>{{$szamlak->honnan}}</td>
                                <td>{{$szamlak->leiras}}</td>
                                <td>{{$szamlak->kategoria}}</td>
                                <td>{{$szamlak->fix}}</td>
                                <td>{{ date_format(date_create($szamlak->datum), "Y. m. d")}}</td>

                            </tr>
                        @endforeach
                    </table>

                    <div class="d-flex justify-content-center">
                        {{$result->links('pagination::bootstrap-4')}}
                    </div>

                </div>
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
