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
    @foreach($get_sub_category as $item)




        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div style="width: 100%;">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">

                                    <h4 class="card-title">Редактирования категории  </h4>

                                    <a style="height: 30px;" class="btn btn-inverse-warning btn-fw" href="
                                       {{route('SinglePageCategory',$item->category_id)}}
                                            ">Назад</a>

                                </div>
                                <br>

                                <form action="{{route('UpdateSubCategory')}}" method="post" enctype="multipart/form-data" class="forms-sample">


                                    @csrf
                                    <input type="hidden" name="sub_category_id" value="{{$item->id}}">
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Название</label>
                                        <input  value="{{$item->sub_category_name}}"  name="sub_category_name" class="form-control" id="exampleInputUsername1"
                                                required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Тип</label>
                                        <select style="color: white;" class="form-control" name="type" >
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

                            </div>


                        </div>

                    </div>



                </div>
            </div>

        </div>
    @endforeach
@endsection