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

                                    <h4 class="card-title">Оценка  </h4>

                                    <a style="height: 30px;" class="btn btn-inverse-warning btn-fw" href="
                                        {{route('getRaiting')}}
                                            ">Назад</a>

                                </div>
                                <div style="display: flex; justify-content: space-evenly">
                                    <div class="card" style="width: 18rem; border: 3px solid #47381d;">
                                        <img class="card-img-top" src="{{ env('APP_URL').'storage/app/uploads/'.$item->SenderReview->photo }}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Заказчик</h5>
                                            <h4 class="card-text">{{$item->SenderReview->name}}&ensp;{{$item->SenderReview->surname}}</h4>
                                            <a href="{{route('OnePageGetNewCustomers',$item->SenderReview->id)}}" class="btn btn-inverse-warning btn-fw">Профиль</a>
                                        </div>
                                    </div>
                                    <style>
                                        .mdi-star{
                                            font-size: 36px;
                                            color: #f3ab09;
                                        }
                                    </style>
                <div style="display: flex; align-items:center ;">
                                    @if($item->grade == 1)
                                        <i class="mdi mdi-star"></i>
                                    @elseif($item->grade == 2)
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>
                                        @elseif($item->grade == 3)
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>

                                        @elseif($item->grade == 4)
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>



                                        @elseif($item->grade == 5)
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>
                                        <i class="mdi mdi-star"></i>

                                        @endif
                </div>
                                    @if(isset($item->ReceiverReview))
                                        <div class="card" style="width: 18rem; border: 3px solid #47381d;">
                                            <img class="card-img-top" src="{{ env('APP_URL').'storage/app/uploads/'.$item->ReceiverReview->photo }}" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Исполнитель</h5>
                                                <h4 class="card-text">{{$item->ReceiverReview->name}}&ensp;{{$item->ReceiverReview->surname}}</h4>
                                                <a href="{{route('OnePageGetNewCustomers',$item->ReceiverReview->id)}}" class="btn btn-inverse-warning btn-fw">Профиль</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <br>
                                <br>


                                <form action="{{route('updatereview')}}" method="post" enctype="multipart/form-data" class="forms-sample">


                                    @csrf
                                    <input type="hidden" name="review_id" value="{{$item->id}}">
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Оценка</label>
                                        <input  value="{{$item->grade}}" type="text" name="grade" class="form-control" id="exampleInputUsername1" placeholder="{{$item->grade}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Описание</label>
                                        <textarea   name="message" class="form-control" id="exampleInputUsername1"
                                                  required>{{$item->message}}</textarea>
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