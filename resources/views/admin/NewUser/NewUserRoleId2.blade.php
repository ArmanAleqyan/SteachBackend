@extends('admin.layouts.default')
@section('title')
    Новый Заказчик
@endsection

@section('content')


    <div class="content-wrapper">
        <br>
        <br>
        <br>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="color: #2f5687 !important">Новые заказчики</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Аватар</th>
                                    <th> Имя </th>
                                    <th> Фамилия </th>
                                    <th> Область</th>
                                    <th> Город </th>

                                </tr>
                                </thead>
                                @foreach($get_user as $item)
                                <tbody>
                                <tr>
                                <td><img src="{{ env('APP_URL').'storage/app/uploads/'.$item->photo }}" alt="image"></td>
                                    <td>
                                        <span >{{$item->name}}</span>
                                    </td>
                                    <td> {{$item->surname}}</td>
                                    <td> {{$item->region}} </td>
                                    <td> {{$item->city}} </td>

                                    <td style="    display: flex;
    justify-content: flex-end;">

                                        <a href="{{route('OnePageGetNewCustomers',$item->id)}}" class="btn btn-inverse-warning btn-fw">Просмотреть</a>
{{--                                        <a class="btn btn-inverse-danger btn-fw">Заблокировать</a>--}}

                                    </td>
                                </tr>

                                </tbody>
                                    @endforeach

                            </table>

                        </div>

                    </div>
                  <div style="display: flex; justify-content: center;">{{$get_user->links()}}</div>
                </div>
            </div>
        </div>

    </div>
@endsection