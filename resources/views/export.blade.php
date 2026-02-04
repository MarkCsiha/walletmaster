<table>
    <thead>
    <tr>
        <th style="font-weight:bolder; text-align: center;">Összeg</th>
        <th style="font-weight:bolder; text-align: center;">Honnan</th>
        <th style="font-weight:bolder; text-align: center;">Leírás</th>
        <th style="font-weight:bolder; text-align: center;">Kategória</th>
        <th style="font-weight:bolder; text-align: center;">Rendszeres</th>
        <th style="font-weight:bolder; text-align: center;">Dátum</th>
    </tr>
    </thead>
    <tbody>
    @foreach($spending as $row)
        <tr>
            <td>{{ $row->osszeg }}</td>
            <td>{{ $row->honnan }}</td>
            <td>{{ $row->leiras }}</td>
            <td>{{ $row->kategoria_nev }}</td>
            <td>
                @if($row->fix == 0)
                    nem
                @else
                    {{ $row->fix }}
                @endif
            </td>
            <td>{{ date_format(date_create($row->datum), "Y. m. d")}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
