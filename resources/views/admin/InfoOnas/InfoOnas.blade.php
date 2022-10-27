@extends('admin.layouts.default')
@section('title')

    Оценка

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
    @foreach($get_all as $item)




        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div style="width: 100%;">
                        <div class="card">
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between">

                                    <h4 class="card-title">Контакты  </h4>

                                </div>
                                <div >
                                    <style>
                                        .mdi-star{
                                            font-size: 36px;
                                            color: #f3ab09;
                                        }
                                    </style>


                                <form action="{{route('UpdateInfo')}}" method="post" enctype="multipart/form-data" class="forms-sample">


                                    @csrf
                                    <input type="hidden" name="info" value="{{$item->id}}">
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Эл.почта</label>
                                        <input  value="{{$item->email}}" type="email" name="email" class="form-control" id="exampleInputUsername1" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Номер телефона</label>
                                        <input  value="{{$item->phone}}"  name="phone" class="form-control" id="exampleInputUsername1"    required>
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