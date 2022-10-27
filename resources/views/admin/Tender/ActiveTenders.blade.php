@extends('admin.layouts.default')
@section('title')
    Тендеры
@endsection

@section('content')

    <style>
        input{
            color: white !important;
        }
    </style>

    <div class="content-wrapper">
        <br>
        <br>
        <br>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div style="    display: flex;    justify-content: space-between;    align-items: baseline;">
                            <h4 class="card-title" style="color: #2f5687 !important">Активные  Тендеры</h4>

                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Заказчик</th>
                                    <th> Имя </th>
                                    <th> Категория </th>
                                    <th> Подкатегория</th>
                                    <th> Регион </th>
                                    <th> Дата выполнения </th>
                                    <th>Исполнитель</th>

                                </tr>
                                </thead>
                                @foreach($tenders as $item)
                                    <tbody >
                                    <tr>
                                        <td>{{$item->AuthorTender->name}} {{$item->AuthorTender->surname}}</td>
                                        <td>
                                            <span class="pl-2">{{$item->name}}</span>
                                        </td>
                                        <td> {{$item->category_name}}</td>
                                        @if($item->sub_category_name != null)
                                            <td> {{$item->sub_category_name}} </td>
                                        @else
                                            <td> Нет</td>
                                        @endif
                                        <td> {{$item->region_name}} </td>
                                        <td> {{$item->date_time}} </td>
                                        @if(isset($item->ExecuterTender))
                                        <td> {{$item->ExecuterTender->name}}  {{$item->ExecuterTender->surname}}</td>
                                        @else
                                        <td>Ещё не выбран</td>
                                            @endif
                                        <td style="    display: flex;
    justify-content: flex-end;">

                                            <a href="{{route('SinglePageTariff',$item->id)}}" class="btn btn-inverse-warning btn-fw">Просмотреть</a>
                                            {{--                                        <a class="btn btn-inverse-danger btn-fw">Заблокировать</a>--}}
                                        </td>
                                    </tr>

                                    </tbody>
                                @endforeach

                            </table>

                        </div>

                    </div>
                    <div style="display: flex; justify-content: center;">{{$tenders->links()}}</div>
                </div>
            </div>
        </div>

    </div>
@endsection