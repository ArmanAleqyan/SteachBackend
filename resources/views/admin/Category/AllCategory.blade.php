@extends('admin.layouts.default')
@section('title')
    Категории
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
                            <h4 class="card-title" style="color: #2f5687 !important">Категории</h4>

                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th >Название</th>
                                    <th>Тип </th>
                                    <th>Цена </th>

                                </tr>
                                </thead>

                                <tbody>
                                @foreach($get_Category as $category)
                                <tr>
                                    <td>{{$category->category_name}}</td>
                                    @if($category->type == 'raice')
                                    <td>Рейсовый</td>
                                    @elseif($category->type == 'time')
                                        <td>Часовой</td>
                                        @endif
                                    <td>{{$category->price}}</td>
                                    <th style="display: flex;   justify-content: flex-end;">
                                            <a href="{{route('SinglePageCategory',$category->id)}}" class="btn btn-inverse-warning btn-fw">Просмотреть</a>
                                    </th>
                                </tr>
                                @endforeach
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