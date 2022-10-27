<table>
    <thead>
    <tr>
        <th style="width: 210px;">
            Сумма комиссии`   {{ceil($sum)}}
        </th>
    </tr>
    </thead>
</table>
<br>
<br>
<br>

<table>
    <thead>
    <tr>
        <th>№</th>
        <th style="width: 100px;">исполнитель</th>
        <th>дата</th>
        <th>начало</th>
        <th>конец</th>
        <th>рейсов/часов</th>
        <th>цена </th>
        <th>итого</th>
        <th>комиссия</th>

    </tr>
    </thead>
    <tbody>
    @foreach($history as $item)
        <tr>
    <td>{{$item->ActiveJobHistory->id}}</td>
            <td  style="width: 210px;">  {{$item->ActiveJobReceiver->name}} {{$item->ActiveJobReceiver->surname}}</td>
            <td style="width: 210px;">{{$item->ActiveJobHistory->created_at}}</td>
            <td style="width: 210px;">{{$item->start_job}}</td>
            <td style="width: 210px;">{{$item->end_job}}</td>
            <td style="width: 210px;">{{$item->ActiveJobHistory->time}}</td>
            <td style="width: 210px;">{{ceil($item->price) }}</td>
            <td style="width: 210px;">{{ceil($item->ActiveJobHistory->price)}}</td>
            <td style="width: 210px;">{{ceil($item->ActiveJobHistory->pracient)}}</td>
        </tr>
    @endforeach
    </tbody>

    </table>

