@extends('admin.layouts.default')
@section('title')

    Редактирования категории
@endsection

<style>
    input{
        color: white !important;
    }
    textarea{
        color: white !important;
    }
</style>




@section('content')
    @foreach($get_category as $item)




        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div style="width: 100%;">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">

                                    <h4 class="card-title">Редактирования категории  </h4>

                                    <a style="height: 30px;" class="btn btn-inverse-warning btn-fw" href="
                                       {{route('getcategory')}}
                                            ">Назад</a>

                                </div>
                                <br>

                                <form action="{{route('UpdateCategory')}}" method="post" enctype="multipart/form-data" class="forms-sample">


                                    @csrf
                                    <input type="hidden" name="category_id" value="{{$item->id}}">
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Название</label>
                                        <input  value="{{$item->category_name}}"  name="category_name" class="form-control" id="exampleInputUsername1"
                                                required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Тип</label>
                                        <select style="color: white;" class="form-control" name="type" id="">
                                            <option value="{{$item->type}}">
                                                @if($item->type == 'raice')
                                                    Рейсовый
                                                    @else
                                                    Часовой
                                                @endif
                                            </option>
                                            <option value="@if($item->type == 'raice')   time  @else raice  @endif">
                                                @if($item->type == 'raice')
                                                    Часовой
                                                @else
                                                    Рейсовый
                                                @endif
                                            </option>
                                        </select>   </div>

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Цена</label>
                                        <input  value="{{$item->price}}"  name="price" class="form-control" id="exampleInputUsername1"
                                                    required>
                                    </div>

                                    <br>
                                    <div style="display: flex; justify-content: space-between">
                                        <button  type="submit" class="btn btn-inverse-success btn-fw">Сохранить изменение</button>
                                    </div>
                                </form>

                                @if(!$sub_category->isEmpty())
                            <h3 style="display: flex;justify-content: center;">Подкатегории</h3>

                                    <div class="row ">
                                        <div class="col-12 grid-margin">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div style="    display: flex;    justify-content: space-between;    align-items: baseline;">
{{--                                                        <h4 class="card-title" style="color: #2f5687 !important">Категории</h4>--}}

                                                    </div>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th >Название</th>
                                                                <th>Цена </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($sub_category as $category)
                                                                <tr>
                                                                    <td>{{$category->sub_category_name}}</td>
{{--                                                                    @if($category->type == 'raice')--}}
{{--                                                                        <td>Рейсовый</td>--}}
{{--                                                                    @elseif($category->type == 'time')--}}
{{--                                                                        <td>Часовой</td>--}}
{{--                                                                    @endif--}}
                                                                    <td>{{$category->price}}</td>
                                                                    <th style="display: flex;   justify-content: flex-end;">
                                                                        <a href="{{route('SinglePageSubCategory',$category->id)}}" class="btn btn-inverse-warning btn-fw">Просмотреть</a>
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
                                    @endif
                            </div>


                        </div>

                    </div>



                </div>
            </div>

        </div>
    @endforeach
@endsection