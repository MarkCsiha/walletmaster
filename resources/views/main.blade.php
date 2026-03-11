@extends('layout')

@push('mainstyle-css')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endpush

@section('content')

    <main class="container pb-2">
<<<<<<< Updated upstream
        {{-- <div class="col-md-9">
            @if (session('success'))
                <p class="text text-success text-center">{{session("success")}}</p>
            @endif
        </div> --}}
=======
>>>>>>> Stashed changes
        <div class="row mt-3">
            <div class="col r-3" id="outerpanel">

                <div class="card" id="kartya">
                    <div class="card-body">
                        {{-- ÉV + HÓNAP --}}
                        <div class="text-center mb-2">
                            <h2 class="m-0" id="cm">{{ $monthStart->year }}</h2>
                            <h4>{{ $monthStart->translatedFormat('F') }}</h4>
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
                    <label for="chartDataType">Költségvetési diagram típusa</label>
                    <select name="chartDataType" id="chartDataType" class="form-control" onchange="this.form.submit()">
                        {{-- request: olyan mint az old value, megtartja az oldal frissítése után azt az inputot, amit a felhasználó választott --}}
                        <option value="categoryChart" {{ request('chartDataType') == 'categoryChart' ? 'selected' : '' }}>
                            Kategóriák szerinti bontás</option>
                        <option value="monthlyChart" {{ request('chartDataType') == 'monthlyChart' ? 'selected' : '' }}>
                            Havi kiadás diagram</option>
                        <option value="spentIncomeChart"
                            {{ request('chartDataType') == 'spentIncomeChart' ? 'selected' : '' }}>Költség - Bevétel
                            differencia</option>
<<<<<<< Updated upstream
=======
                        <option value="budgetComparisonChart"
                            {{ request('chartDataType') == 'budgetComparisonChart' ? 'selected' : '' }}>Összehasonlítás
                        </option>
>>>>>>> Stashed changes
                    </select>
                    {{-- csak akkor bukkan fel az év választós mező, ha a felhasználó havi költségbontást választott --}}
                    @if (request('chartDataType') == 'monthlyChart')
                        <label for="year">Év kiválasztása</label>
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
                <select name="chartType" id="chartType" class="form-control mt-3" onchange="this.form.submit()">
                    <option value="bar" {{ request('chartType', 'bar') == 'bar' ? 'selected' : '' }}>Oszlopdiagram
                    </option>
                    <option value="pie" {{ request('chartType') == 'pie' ? 'selected' : '' }}>Kördiagram</option>
                    <option value="doughnut" {{ request('chartType') == 'doughnut' ? 'selected' : '' }}>Fánk diagram
                    </option>
<<<<<<< Updated upstream
                    @if (request('chartDataType') == 'monthlyChart')
                        <option value="line" {{ request('chartType') == 'line' ? 'selected' : '' }}>Vonal diagram
                        </option>
                    @endif
=======
                    <option value="line" {{ request('chartType') == 'line' ? 'selected' : '' }}>Vonal diagram</option>
>>>>>>> Stashed changes
                </select>

                {{-- Oszlop --}}
                <div>
                    <h4 class="text-center">Oszlopdiagram</h4>
                    <canvas id="myChart" style="background-color: white; padding: 5px; width:100%; height:100%"></canvas>
                </div>

            </div>
            {{-- Diagram vége --}}


            {{-- Sor lezárás --}}
        </div>

        <form id="filtersForm" method="GET" action="/main">
            @csrf
<<<<<<< Updated upstream

            <div class="row">
                <div class="col-md-3">
                    <label>Kategória</label>
                    <select name="category" class="form-control">
                        <option value="">Összes</option>
                        @foreach ($labels as $label)
                            <option value="{{ $label }}"
                                {{ ($selectedCategory ?? '') === $label ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

=======
            <div class="row">
>>>>>>> Stashed changes
                <div class="col-md-3">
                    <label>Mettől</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-3">
                    <label>Meddig</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-3">
                    <label>Kategória</label>
                    <input type="text" name="categories" class="form-control" placeholder="pl.: Élelmiszer"
                        value="{{ ucfirst(request('categorie')) }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" type="submit">Szűrés</button>
                </div>
            </div>

        </form>

        <div class="mt-3">

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h2 class="text-center pb-3">{{ $monthStart->translatedFormat('F') }}</h2>
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
                    <div class="row">
                        <div class="col-6">
                            <div id="exportbtn" class=" mt-2">
                                <form action="/export" id="export" method="GET">
                                    <button type="submit" class="btn btn-dark">Exportálás</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-6">
                            <div id="addbtn">
                                <a href="/add" class="btn btn-dark">Hozzáadás</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<<<<<<< Updated upstream

    <script>
        let labels = {!! json_encode($labels ?? []) !!};
        let data = {!! json_encode($data ?? []) !!};

        let cm = document.getElementById("cm")

        @if (!empty($monthly))
            labels = @json($monthly->keys()->values());
            data = @json($monthly->values());
        @endif
=======
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-autocolors"></script>

    <script>
        //a ??-el lehet üres is, azaz ha más formot küldünk, akkor nem fog összeomlani hogy nem kapta meg
        let labels = {!! json_encode($labels ?? []) !!};
        let data = {!! json_encode($data ?? []) !!};

        let spent = [];
        let income = [];
        let userData = [];
        let compData = [];
        @if (!empty($monthly))
            labels = @json($monthly->keys()->values());
            data = @json($monthly->values());
        @endif

        @if (!empty($spent))
            labels = @json($spent->keys()->values());
            spent = @json($spent->values());
            income = @json($income->values());
        @endif
        @if (!empty($budgetComparison))
            labels = @json($userExpenses->keys()->values());
            userData = @json($userExpenses->values());
            compData = @json($budgetComparison->values());
        @endif

        const isMonthly = @json(!empty($monthly));
        const isSpentIncome = @json(!empty($spent));
        const isComparison = @json(!empty($budgetComparison));
        // $(document).on('click','.deleteSpending',function(){
        //     var programID=$(this).attr('data-programid');
        //     $('#app_id').val(programID);
        //     $('#question').append(programID+' ?');
        //     $('#applicantDeleteModal').modal('show');
        // });
>>>>>>> Stashed changes
    </script>
@endsection
