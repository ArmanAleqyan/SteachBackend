@extends('admin.layouts.default')
@section('title')
    Оценки исполнителей
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
                        <div style="display: flex; justify-content: space-between">
                            <h4 class="card-title" style="color: #2f5687 !important">Оценки исполнителей</h4>

                        </div>
                        <br>
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Заказчик</th>
                                    <th> Исполнитель </th>
                                    <th> Оценка </th>


                                </tr>
                                </thead>
                                @foreach($get_all as $item)
                                    <tbody>
                                    <tr>



                                        <td> {{$item->SenderReview->name}}&ensp; {{$item->SenderReview->surname}}</td>
                                        <td> {{$item->ReceiverReview->name}}&ensp; {{$item->ReceiverReview->surname}} </td>
                                        @if($item->grade == 1)
                                        <td> <i class="mdi mdi-star"></i> </td>
                                        @elseif($item->grade == 2)
                                            <td> <i class="mdi mdi-star"></i>  <i class="mdi mdi-star"></i>  </td>
                                        @elseif($item->grade == 3)
                                            <td>
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                            </td>
                                            @elseif($item->grade == 4)
                                            <td>
                                                <i class="mdi mdi-star"></i>  <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>  <i class="mdi mdi-star"></i>
                                            </td>
                                            @elseif($item->grade == 5)
                                            <td>
                                                <i class="mdi mdi-star"></i>  <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>  <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                            </td>
                                            @endif
                                        <style>
                                            .mdi-star{
                                                font-size: 18px;
                                                color: #ffab00;

                                            }
                                        </style>
                                        <td style="    display: flex;
    justify-content: flex-end;">

                                            <a href="{{route('singlePageRaiting',$item->id)}}" class="btn btn-inverse-warning btn-fw">Просмотреть</a>
                                            {{--                                        <a class="btn btn-inverse-danger btn-fw">Заблокировать</a>--}}

                                        </td>
                                    </tr>

                                    </tbody>
                                @endforeach

                            </table>

                        </div>

                    </div>
                    <div style="display: flex; justify-content: center;">{{$get_all->links()}}</div>
                </div>
            </div>
        </div>

    </div>
@endsection