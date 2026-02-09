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
        {{-- <div class="col-md-9">
            <p class="text text-center">A költése {{ $percentage }}%-al nagyobb, mint az előző havi.</p>
        </div> --}}
  <form id="filtersForm" method="GET" action="/main">
    @csrf

    <div class="row">
      <div class="col-md-3">
        <label>Kategória</label>
        <select name="category" class="form-control">
          <option value="">Összes</option>
          @foreach (($labels ?? []) as $label)
            <option value="{{ $label }}" {{ ($selectedCategory ?? '') === $label ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-3">
        <label>Mettől</label>
        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
      </div>

      <div class="col-md-3">
        <label>Meddig</label>
        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
      </div>

      <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary w-100" type="submit">Szűrés</button>
      </div>
    </div>
  </form>
  <div class="col-md-3">
    <form action="main" method="POST" id="monthlyChart">
        @csrf
        <label for="chartDataType">Költségvetési diagram típusa</label>
        <select name="chartDataType" id="chartDataType" class="form-control" onchange="this.form.submit()">
            {{-- request: olyan mint az old value, megtartja az oldal frissítése után azt az inputot, amit a felhasználó választott --}}
            <option value="categoryChart"    {{ request('chartDataType') == 'categoryChart' ? 'selected' : '' }}>Kategóriák szerinti bontás</option>
            <option value="monthlyChart"     {{ request('chartDataType') == 'monthlyChart' ? 'selected' : '' }}>Havi kiadás diagram</option>
            <option value="spentIncomeChart" {{ request('chartDataType') == 'spentIncomeChart' ? 'selected' : '' }}>Költség - Bevétel differencia</option>
            <option value="budgetComparisonChart" {{ request('chartDataType') == 'budgetComparisonChart' ? 'selected' : '' }}>Összehasonlítás</option>
        </select>
        {{-- csak akkor bukkan fel az év választós mező, ha a felhasználó havi költségbontást választott --}}
        @if (request('chartDataType') == 'monthlyChart')
            <label for="year">Év kiválasztása</label>
            <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
        @endif
    </select>

    </form>
  </div>
  <div class="col-md-3">
    <select name="chartType" id="chartType" class="form-control" onchange="this.form.submit()">
        <option value="bar"      {{ request('chartType','bar') == 'bar' ? 'selected' : '' }}>Oszlopdiagram</option>
        <option value="pie"      {{ request('chartType') == 'pie' ? 'selected' : '' }}>Kördiagram</option>
        <option value="doughnut" {{ request('chartType') == 'doughnut' ? 'selected' : '' }}>Fánk diagram</option>
        @if (request('chartDataType') == 'monthlyChart')
            <option value="line" {{ request('chartType') == 'line' ? 'selected' : '' }}>Vonal diagram</option>
        @endif
    </select>
  </div>
  <div class="row mt-4">
    <div class="col-md-6">
      <h4 class="text-center">Oszlopdiagram</h4>
      <canvas id="myChart" style="background-color: black; padding: 5px;"></canvas>
    </div>
  </div>

    <button><a href="/export">Exportálás</a></button>
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
                            <th>Leírás</th>
                            <th>Kategória</th>
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
    //a ??-el lehet üres is, azaz ha más formot küldünk, akkor nem fog összeomlani hogy nem kapta meg
    let labels = {!! json_encode($labels ?? []) !!};
    let data   = {!! json_encode($data ?? []) !!};

    @if(!empty($monthly))
        labels = @json($monthly->keys()->values());
        data   = @json($monthly->values());
    @endif

    @if(!empty($budgetComparison))
        labels   = @json($budgetComparison->keys());
        userData = @json($data);
        compData = @json($budgetComparison->values());
    @endif

    const isComparison = {!! json_encode(!empty($budgetComparison)) !!};
</script>
@endsection
