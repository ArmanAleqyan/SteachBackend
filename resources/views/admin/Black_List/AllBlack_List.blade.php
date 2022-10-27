@extends('admin.layouts.default')
@section('title')
    Чёрный список
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
                        <h4 class="card-title" style="color: #2f5687 !important">Пользователи добавленные в чёрный список</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Аватар</th>
                                    <th> Имя </th>
                                    <th> Фамилия </th>
                                    <th> Область</th>
                                    <th> Город </th>
                                    <th> Тип  </th>

                                </tr>
                                </thead>
                                @foreach($get_user as $item)
                                    <tbody @if($item->black_list == 2)style="color: #f71818" @endif>
                                    <tr>
                                        <td><img @if($item->black_list == 2)style="border: 2px solid #f71818" @endif src="{{ env('APP_URL').'storage/app/uploads/'.$item->photo }}" alt="image"></td>
                                        <td>
                                            <span class="pl-2">{{$item->name}}</span>
                                        </td>
                                        <td> {{$item->surname}}</td>
                                        <td> {{$item->region}} </td>
                                        <td> {{$item->city}} </td>
                                        @if($item->role_id == 2)
                                        <td>Заказчик </td>
                                        @else
                                            <td>Пользователь </td>
                                            @endif
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