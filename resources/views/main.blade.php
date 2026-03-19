@extends('layout')

@push('mainstyle-css')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endpush

@section('content')

    <main class="container pb-2">
        <div class="row mt-3">
            <div class="col r-3" id="outerpanel">

                <div class="card" id="kartya">
                    <div class="card-body">
                        {{-- ÉV + HÓNAP --}}
                        <div class="text-center mb-2">
                            <h2 class="m-0" id="cm">{{ $monthStart->year }}</h2>
                            <h4>{{ ucfirst($monthStart->translatedFormat('F')) }}</h4>
                        </div>

                        {{-- HÓNAP VÁLTÁS --}}
                        <div class="d-flex justify-content-between mb-2">
                            <a class="btn btn-outline-secondary btn-sm text-white"
                                href="{{ route('naptar', ['ym' => $prevYm]) }}">
                                Előző
                            </a>

                            <a class="btn btn-outline-secondary btn-sm  text-white"
                                href="{{ route('naptar', ['ym' => $nextYm]) }}">
                                Következő
                            </a>
                        </div>

                        {{-- NAPTÁR --}}
                        <table class="border border-striped" id="calendar">
                            <tr id="calendar_th">
                                <th>H</th>
                                <th>K</th>
                                <th>Sz</th>
                                <th>Cs</th>
                                <th>P</th>
                                <th>Sz</th>
                                <th>V</th>
                            </tr>
                            @foreach (array_chunk($days, 7) as $week)
                                <tr>
                                    @foreach ($week as $day)
                                        @php
                                            $date = $day->toDateString();
                                            $inMonth = $day->month === $monthStart->month;

                                            $spentaday = $dailySums[$date]->spent ?? 0;
                                            $gainaday = $dailySums[$date]->gain ?? 0;

                                            $hasTxn = $spentaday > 0 || $gainaday > 0;
                                        @endphp

                                        <td style="height:60px; vertical-align:top;">
                                            @if (!$inMonth)
                                                <div style="font-weight:700; color:tomato;">
                                                    {{ $day->day }}
                                                </div>
                                            @else
                                                @if ($inMonth and $hasTxn)
                                                    <div style="font-weight:700;"
                                                        title="+{{ $gainaday }} | -{{ $spentaday }}">
                                                        {{ $day->day }}
                                                    </div>
                                                @else
                                                    <div style="font-weight:700;">
                                                        {{ $day->day }}
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            {{-- Ez a diagram oszlopa --}}
            <div class="col r-3 ">
                <form action="main" method="POST" id="monthlyChart">
                    @csrf
                    <label for="chartDataType" class="mb-2 mt-3">Költségvetési diagram típusa</label>
                    <select name="chartDataType" id="chartDataType" class="form-control" onchange="this.form.submit()">
                        {{-- request: olyan mint az old value, megtartja az oldal frissítése után azt az inputot, amit a felhasználó választott --}}
                        <option value="categoryChart"    {{ request('chartDataType') == 'categoryChart' ? 'selected' : '' }}>Kategóriák szerinti bontás</option>
                        <option value="monthlyChart"     {{ request('chartDataType') == 'monthlyChart' ? 'selected' : '' }}>Havi kiadás diagram</option>
                        <option value="spentIncomeChart" {{ request('chartDataType') == 'spentIncomeChart' ? 'selected' : '' }}>Költség - Bevétel differencia</option>
                        <option value="budgetComparisonChart" {{ request('chartDataType') == 'budgetComparisonChart' ? 'selected' : '' }}>Összehasonlítás</option>
                    </select>
                    {{-- csak akkor bukkan fel az év választós mező, ha a felhasználó havi költségbontást választott --}}
                    @if (request('chartDataType') == 'monthlyChart')
                        <label for="year mb-2">Év kiválasztása</label>
                        <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                            @foreach ($years as $y)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </form>


                {{-- Oszlop kategória --}}
                <select name="chartType" id="chartType" class="form-control mb-3 mt-3" onchange="this.form.submit()">
                    <option value="bar"      {{ request('chartType','bar') == 'bar' ? 'selected' : '' }}>Oszlopdiagram</option>
                    <option value="pie"      {{ request('chartType') == 'pie' ? 'selected' : '' }}>Kördiagram</option>
                    <option value="doughnut" {{ request('chartType') == 'doughnut' ? 'selected' : '' }}>Fánk diagram</option>
                    <option value="line"     {{ request('chartType') == 'line' ? 'selected' : '' }}>Vonal diagram</option>
                </select>

                {{-- Oszlop --}}
                <div>
                    <h4 class="text-center">Oszlopdiagram</h4>
                    <canvas id="myChart" style="padding: 5px; width:100%; height:100%"></canvas>
                </div>

            </div>
            {{-- Diagram vége --}}


            {{-- Sor lezárás --}}
        </div>

        <form id="filtersForm" method="GET" action="/main" class="mt-3">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label class="mb-1">Mettől</label>
                    <input type="number" name="from" min="1" max="31" class="form-control rounded-pill"
                        value="{{ request('from', 1) }}">
                </div>

                <div class="col-md-3">
                    <label class="mb-1">Meddig</label>
                    <input type="number" name="to" min="1" max="31" class="form-control rounded-pill"
                        value="{{ request('to', 31) }}">
                </div>

                <div class="col-md-3">
                    <label class="mb-1">Kategória</label>
                    <input type="text" name="category" class="form-control rounded-pill" placeholder="pl.: Élelmiszer"
                        value="{{ ucfirst(request('category')) }}">
                </div>

                <div class="col-md-3 d-flex align-items-end pt-3">
                    <button class="btn btn-primary  w-100" type="submit">Szűrés</button>
                </div>
            </div>

        </form>

        <div class="mt-3">

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h2 class="text-center pb-3">{{ ucfirst($monthStart->translatedFormat('F')) }}</h2>
                        <table class="table table bordered">
                            <tr>
                                <th>Összeg</th>
                                <th>Honnan</th>
                                <th>Leíras</th>
                                <th>Kategoria</th>
                                <th>Rendszeres</th>
                                <th>Dátum</th>
                                <th>Módosítás</th>
                                <th>Törlés</th>
                            </tr>

                            @foreach ($result as $szamlak)
                                <tr>
                                    <td>
                                        @if ($szamlak->tipus == 0)
                                            <span class="minus">- {{ $szamlak->osszeg }} Ft</span>
                                        @else
                                            <span class="plus">+ {{ $szamlak->osszeg }} Ft</span>
                                        @endif
                                    </td>
                                    <td>{{ $szamlak->honnan }}</td>
                                    <td>{{ $szamlak->leiras }}</td>
                                    <td>{{ $szamlak->kategoria_nev }}</td>
                                    <td>{{ $szamlak->fix }}</td>
                                    <td>{{ date_format(date_create($szamlak->datum), 'Y. m. d') }}</td>
                                    <td class="text-center"> <a href="/mainmod/{{ $szamlak->szamla_id }}"> <i
                                                class="bi bi-pencil-fill text-warning"></i> </a> </td>
                                    <td class="text-center"> <a href="/mainexit/{{ $szamlak->szamla_id }}"> <i
                                                class="bi bi-trash-fill text-danger"></i> </a> </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $result->links('pagination::bootstrap-4') }}
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 d-flex align-items-center">
                            <form action="/export" method="GET" class="m-0">
                                <button type="submit" class="btn btn-dark">Exportálás</button>
                            </form>
                        </div>

                        <div class="col-6 d-flex justify-content-end align-items-center">
                            <a href="/add" class="btn btn-dark">Hozzáadás</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-autocolors"></script>

<script>
    //a ??-el lehet üres is, azaz ha más formot küldünk, akkor nem fog összeomlani hogy nem kapta meg
    let labels = {!! json_encode($labels ?? []) !!};
    let data   = {!! json_encode($data ?? []) !!};

    let spent = [];
    let income = [];
    let userData = [];
    let compData = [];
    @if(!empty($monthly))
        labels = @json($monthly->keys()->values());
        data   = @json($monthly->values());
    @endif

    @if(!empty($spent))
        labels = @json($spent->keys()->values());
        spent = @json($spent->values());
        income = @json($income->values());
    @endif
    @if(!empty($budgetComparison))
        labels = @json($userExpenses->keys()->values());
        userData = @json($userExpenses->values());
        compData = @json($budgetComparison->values());
    @endif

    const isMonthly     = @json(!empty($monthly));
    const isSpentIncome = @json(!empty($spent));
    const isComparison  = @json(!empty($budgetComparison));
    // $(document).on('click','.deleteSpending',function(){
    //     var programID=$(this).attr('data-programid');
    //     $('#app_id').val(programID);
    //     $('#question').append(programID+' ?');
    //     $('#applicantDeleteModal').modal('show');
    // });
</script>
@endsection
