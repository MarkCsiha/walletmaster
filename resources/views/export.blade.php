<table>
    <thead>
    <tr>
        <th style="font-weight:bolder; text-align: center;">osszeg</th>
        <th style="font-weight:bolder; text-align: center;">honnan</th>
        <th style="font-weight:bolder; text-align: center;">leiras</th>
        <th style="font-weight:bolder; text-align: center;">tipus</th>
        <th style="font-weight:bolder; text-align: center;">kategoria_nev</th>
        <th style="font-weight:bolder; text-align: center;">fix</th>
        <th style="font-weight:bolder; text-align: center;">datum</th>
    </tr>
    </thead>
    <tbody>
    @foreach($spending as $row)
        <tr>
            <td>{{ $row->osszeg }}</td>
            <td>{{ $row->honnan }}</td>
            <td>{{ $row->leiras }}</td>
            <td>
              {{ $row->tipus }}
            </td>
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
