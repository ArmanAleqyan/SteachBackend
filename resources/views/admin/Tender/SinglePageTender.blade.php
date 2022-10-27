@extends('admin.layouts.default')
@section('title')

    Тендер

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
    @foreach($tender as $item)




        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div style="width: 100%;">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">

                                    <h4 class="card-title">@if($item->status == 1)Новый тендер   @elseif($item->status == 2)Активный тендер  @elseif($item->status == 3)Завершенный тендер@endif</h4>

                                        <a style="height: 30px;" class="btn btn-inverse-warning btn-fw" href="
                                       @if($item->status == 1) {{route('getNewTender')}} @elseif($item->status == 2 ) {{route('activeTenders')}}@endif
                                                ">Назад</a>

                                </div>
                                <div style="display: flex; justify-content: space-evenly">
                                <div class="card" style="width: 18rem; border: 3px solid #47381d;">
                                    <img class="card-img-top" src="{{ env('APP_URL').'storage/app/uploads/'.$item->AuthorTender->photo }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Заказчик</h5>
                                        <h4 class="card-text">{{$item->AuthorTender->name}}&ensp;{{$item->AuthorTender->surname}}</h4>
                                        <a href="{{route('OnePageGetNewCustomers',$item->AuthorTender->id)}}" class="btn btn-inverse-warning btn-fw">Профиль</a>
                                    </div>
                                </div>

                                @if(isset($item->ExecuterTender))
                                    <div class="card" style="width: 18rem; border: 3px solid #47381d;">
                                        <img class="card-img-top" src="{{ env('APP_URL').'storage/app/uploads/'.$item->ExecuterTender->photo }}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Исполнитель</h5>
                                            <h4 class="card-text">{{$item->ExecuterTender->name}}&ensp;{{$item->ExecuterTender->surname}}</h4>
                                            <a href="{{route('OnePageGetNewCustomers',$item->ExecuterTender->id)}}" class="btn btn-inverse-warning btn-fw">Профиль</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <br>
                                <br>


                                <form action="" method="post" enctype="multipart/form-data" class="forms-sample">
                                    <div>
                                    @foreach($item->Tender as $photo)

                                        <img style="  margin: 6px;  max-width: 200px; width: 100%; min-height: 200px; height: 200px;" src="{{ env('APP_URL').'storage/app/uploads/'.$photo->photo }}" alt="">

                                    @endforeach
                                    </div>

                                    @csrf
                                    <input type="hidden" name="tender_id" value="{{$item->id}}">
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Имя</label>
                                        <input disabled value="{{$item->name}}" type="text" name="name" class="form-control" id="exampleInputUsername1" placeholder="{{$item->name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Описание работы</label>
                                        <textarea disabled  name="description" class="form-control" id="exampleInputUsername1"
                                                    required>{{$item->description}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Категория</label>
                                        <select disabled style="color: white" name="city_id"  class="form-control">
                                            <option  value="{{$item->category_id}}">{{$item->category_name}}</option>
                                            @foreach($get_category as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Подкатегория</label>
                                        <select disabled style="color: white" name="city_id"  class="form-control">
                                            <option  value="{{$item->sub_category_id}}">{{$item->sub_category_name}}</option>
                                            @foreach($get_sub_category as $sub_category)
                                                <option value="{{$sub_category->id}}">{{$sub_category->sub_category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Область</label>
                                        {{--                                    <input type="password"  id="exampleInputConfirmPassword1" placeholder="Password">--}}
                                        <select disabled style="color: white" name="region_id"  class="form-control">
                                            <option  value="{{$item->region_id}}">{{$item->region_name}}</option>
                                            @foreach($get_region as $region)
                                                <option value="{{$region->id}}">{{$region->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Город</label>
                                        <select disabled style="color: white" name="city_id"  class="form-control">
                                            <option  value="{{$item->city_id}}">{{$item->city_name}}</option>
                                            @foreach($get_city as $city)
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Улица</label>
                                        <input disabled value="{{$item->street}}" type="text" name="street" class="form-control" id="exampleInputUsername1" placeholder="{{$item->street}}" required>
                                    </div>


                                    <style>
                                        input{
                                            background-color: black !important;
                                        }
                                        textarea{
                                            background-color: black !important;
                                        }
                                        select{
                                            background-color: black !important;
                                        }
                                    </style>

                                    <br>


                                    <div style="display: flex; justify-content: space-between">
{{--                                        <button  type="submit" class="btn btn-inverse-success btn-fw">Сохранить изменение</button>--}}
                                        @if($item->status != 1)
                                            @if($chat == true)
                                        <a class="btn btn-outline-warning btn-fw" href="{{route('tendersChat',[$item->id,$item->sender_id])}}">Переписки тендера</a>
                                        @endif
                                        @endif
                                        @if($item->status == 1)
                                            <a href="{{route('SuccsesSinglePageTariff', $item->id)}}"  class="btn btn-inverse-success btn-fw">Одобрить</a>
                                        @endif


                                    </div>

                                </form>

                            </div>


                        </div>

                    </div>



                </div>
            </div>

        </div>
    @endforeach
@endsection