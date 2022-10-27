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
                            <h4 class="card-title" style="color: #2f5687 !important">Активные заказы</h4>
{{--                            <form method="post" action="{{'searchExucator'}}" style="width: 80%;" class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">--}}
{{--                                @csrf--}}
{{--                                <input required type="text" class="form-control" name="search" placeholder="Искать пользователя по номеру телефона">--}}
{{--                            </form>--}}
                        </div>
                        <br>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>


                                    <th> Заказчик </th>
                                    <th> Исполнитель</th>
                                    <th> Заказ </th>
                                    <th> Начало работы </th>

                                </tr>
                                </thead>
                                @foreach($get_jobs as $item)

                                    <tbody @if($item->black_list == 2)style="color: #f71818" @endif>
                                    <tr>

                                        <td><a href="{{route('OnePageGetNewCustomers',$item->ActiveJobSender->id)}}">{{$item->ActiveJobSender->name}}&ensp;&ensp;{{$item->ActiveJobSender->surname}}</a> </td>
                                        <td><a href="{{route('OnePageGetNewCustomers', $item->ActiveJobReceiver->id)}}">{{$item->ActiveJobReceiver->name}}&ensp;&ensp;{{$item->ActiveJobReceiver->surname}}</a>  </td>
                                        @if(isset($item->tender_id))
                                        <td><a  href="{{route('SinglePageTariff', $item->ActiveJobTender->id)}}">{{$item->ActiveJobTender->name}}</a></td>
                                            @else
                                            <td>Простой заказ</td>
                                        @endif
                                        <td> {{$item->start_job}} </td>


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