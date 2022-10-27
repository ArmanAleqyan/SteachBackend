@extends('admin.layouts.default')
@section('title')
    Заказчики
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
                        <div style="  display: flex;    justify-content: space-between;    align-items: baseline;">
                        <h4 class="card-title" style="color: #2f5687 !important">Заказчики</h4>
                        <form method="post" action="{{'searchCustomers'}}" style="width: 80%;" class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                            @csrf
                            <select name="Searchmethod" style="width: 15%;" class="form-control">
                                <option value="name">По имени</option>
                                <option value="surname">По фамилии</option>
                                <option value="city">По городу</option>
                                <option value="phone">По номеру телефона</option>

                            </select>&ensp;
                            <input required type="text" class="form-control" name="search" placeholder="Искать пользователя">
                        </form>
                        </div>

                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Аватар</th>
                                    <th> Имя </th>
                                    <th> Фамилия </th>
                                    <th> Область</th>
                                    <th> Город </th>
                                </tr>
                                </thead>
                                @foreach($get_user as $item)
                                    <tbody @if($item->black_list == 2)style="color: #f71818" @endif>
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td><img @if($item->black_list == 2)style="border: 2px solid #f71818" @endif src="{{ env('APP_URL').'storage/app/uploads/'.$item->photo }}" alt="image"></td>
                                        <td>
                                            <span class="pl-2">{{$item->name}}</span>
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