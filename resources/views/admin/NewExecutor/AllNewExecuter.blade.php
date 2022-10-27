@extends('admin.layouts.default')
@section('title')
    Исполнитель
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
                        <h4 class="card-title" style="color: #2f5687 !important">Новые Исполнители</h4>
                        <form style="width: 60%" method="post" action="{{route('serachVinCode')}}" class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                            @csrf
                            <input name="vincode" type="text" class="form-control" placeholder="Поиск по вин номеру">
                        </form>
                        </div>
                        <br>
                        <br>
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