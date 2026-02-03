<table>
    <thead>
    <tr>
        <th>Összeg</th>
        <th>Honnan</th>
        <th>Leírás</th>
        <th>Kategória</th>
        <th>Rendszeres</th>
        <th>Dátum</th>
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
                @if($row->rendszeres == 0)
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
