@extends('admin.layouts.default')
@section('title')
    Статистика пользователей
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
                            <h4 class="card-title" style="color: #2f5687 !important">Статистика пользователей</h4>

                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th >Заказчики</th>
                                    <th>Заказчики На модерации</th>
                                    <th>Исполнители</th>
                                    <th>Исполнители На модерации</th>
                                    <th>Чёрный список</th>

                                </tr>
                                </thead>

                                    <tbody >
                                    <tr>
                                        <td>{{$get_Executor}}</td>
                                        <td>
                                            {{$new_get_Executor}}
                                        </td>
                                        <td>{{$get_Custumers}} </td>

                                            <td>{{$new_get_Custumers}} </td>

                                            <td> {{$get_black_list}}</td>

                                    </tr>

                                    </tbody>


                            </table>

                        </div>

                    </div>
                    <div style="display: flex; justify-content: center;"> </div>
                </div>
            </div>
        </div>

    </div>
@endsection