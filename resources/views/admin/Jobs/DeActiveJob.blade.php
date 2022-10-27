@extends('admin.layouts.default')
@section('title')
    Заказы
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
                        <div style="display: flex;    justify-content: space-between;    align-items: baseline;">
                            <h4 class="card-title" style="color: #2f5687 !important">Завершенные заказы</h4>
                                                        <form  method="post" action="{{'FiltredeactiveJobde'}}" style="width: 80%; justify-content: flex-end" class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                                                            @csrf
                                                            <div style="display: flex; justify-content: space-between" >
                                                            <input style="width:  50%;" required type="date" class="form-control" name="start" placeholder="">&ensp;
                                                                <input style="width: 50%;" required type="date" class="form-control" name="end" placeholder="">&ensp;

                                                                <button class="btn btn-inverse-success btn-fw" type="submit">Искать</button>
                                                            </div>

                                                        </form>
                        </div>
                        <br>
                        @if(isset($start_date))
                          <h3>  Вы применили фильтр с  <span style="color: #14402f">{{$start_date}} </span> До <span style="color: #14402f;">{{$end_date}} </span>найдено <span style="color:#14402f; ">{{$count}}</span> </h3>

                            @else
                            <a href="{{route('downloadExele')}}">Скачать Excel Файл</a>

                        @endif
                        <br>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th> Заказчик </th>
                                    <th> Исполнитель</th>
                                    <th> Заказ </th>
                                    <th> Начало работы </th>
                                    <th>Завершение работы</th>
                                    <th>Рейсов/Часов</th>
                                    <th>Цена</th>
                                    <th>Итого</th>
                                    <th>Комиссия</th>
                                </tr>
                                </thead>
                                @foreach($get_jobs as $item)

                                    <tbody @if($item->black_list == 2)style="color: #f71818" @endif>
                                    <tr>

                                        <td><a href="">{{$item->ActiveJobSender->name}}&ensp;&ensp;{{$item->ActiveJobSender->surname}}</a> </td>
                                        <td><a href="">{{$item->ActiveJobReceiver->name}}&ensp;&ensp;{{$item->ActiveJobReceiver->surname}}</a>  </td>
                                        @if(isset($item->tender_id))
                                            <td><a  href="">{{$item->ActiveJobTender->name}}</a></td>
                                        @else
                                            <td>Простой заказ</td>
                                        @endif
                                        <td> {{$item->start_job}} </td>
                                        <td> {{$item->end_job}} </td>
                                        <td> {{$item->ActiveJobHistory->time}} </td>
                                        <td> {{$item->price}} </td>
                                        <td> <?php  $floor_price = ceil($item->ActiveJobHistory->price) ?> {{$floor_price}} </td>
                                        <td> <?php  $floor_pracient = ceil($item->ActiveJobHistory->pracient) ?> {{$floor_pracient}} </td>


                                        {{--                                        <td style="    display: flex;--}}
                                        {{--    justify-content: flex-end;">--}}

                                        {{--                                            <a href="{{route('OnePageGetNewCustomers',$item->id)}}" class="btn btn-inverse-warning btn-fw">Просмотреть</a>--}}
                                        {{--                                            --}}{{--                                        <a class="btn btn-inverse-danger btn-fw">Заблокировать</a>--}}

                                        {{--                                        </td>--}}
                                    </tr>

                                    </tbody>
                                @endforeach

                            </table>

                        </div>

                    </div>
                    <div style="display: flex; justify-content: center;">{{$get_jobs->links()}}</div>
                </div>
            </div>
        </div>

    </div>
@endsection