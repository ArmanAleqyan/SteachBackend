@extends('admin.layouts.default')
@section('title')
    @if($get_user[0]->role_id == 2)
   Заказчик
    @else
        Исполнитель
    @endif
@endsection

<style>
    input{
        color: white !important;
    }
</style>


@section('content')
    @foreach($get_user as $item)

        @if(session('opentariff'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Вы удачно включили тариф плюс',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
            @endif
        @if(session('closetariff'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Вы удачно отключили  тариф плюс',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
            @endif
    @if(session('succses'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Вы удачно одобрили пользователя',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
    @if(session('blackList'))

        <script>
            Swal.fire({
                icon: 'success',
                title: 'Пользователь добавлен в чёрный список',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif

    @if(session('deleteBlackList'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Пользователь удалён из чёрного списка',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif

    @if(session('updated'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Вы удачно отредактировали пользователя',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
        @endif
        @if(session('messageCreated'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Сообщение отправлено',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
        @endif
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div style="width: 100%;">
                    <div class="card">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between">

                            <h4 class="card-title">Редактирование @if($get_user[0]->role_id == 2) Заказчика @elseИсполнителя  @endif</h4>
                                <button type="button" class="btn btn-outline-secondary btn-fw" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Написать сообщение</button>

                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Новое сообщение</h5>
                                                <button style="    color: aliceblue !important;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('AdminSendMessage')}}" method="post">
                                            <div class="modal-body">

                                                    @csrf
                                                    <input type="hidden" name="receiver_id" value="{{$get_user[0]->id}}">
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Сообщение:</label>
                                                        <textarea style="color: white !important;" name="message" class="form-control" id="message-text" required></textarea>
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-danger btn-fw" data-dismiss="modal">Закрыть</button>
                                                <button type="submit" class="btn btn-outline-success btn-fw">Отправить</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                @if($get_user[0]->status == 2)
                            <a style="height: 30px;" class="btn btn-inverse-warning btn-fw" href="@if($get_user[0]->role_id == 2) {{route('GetNewCustomers')}}  @else {{route('GetNewExecutor')}} @endif">Назад</a>
                            @else
                                    <a style="height: 30px;" class="btn btn-inverse-warning btn-fw" href="@if($get_user[0]->role_id == 2) {{route('GetAllCustomers')}}  @else {{route('GetAllExecutor')}} @endif">Назад</a>
                                @endif

                            </div>
                            <br>
                            <br>
                                <form action="{{route('updateUserProfile')}}" method="post" enctype="multipart/form-data" class="forms-sample">
                                    @csrf
                                        <input type="hidden" name="user_id" value="{{$item->id}}">
                                        <div>
                                            <img style="object-fit: cover; object-position: center; max-height: 200px; max-width: 200px; width: 100%;" src="{{ env('APP_URL').'storage/app/uploads/'.$item->photo }}" alt="image" id="blahas">
                                            <br>
                                            <input accept="image/*" style="display: none" name="photo" id="file-logos" class="btn btn-outline-success" type="file">
                                            <br>
                                            <label style="width: 200px" for="file-logos" class="custom-file-upload btn btn-outline-success">
                                                изменить фотографию
                                            </label>
                                        </div>
                                        <br>
                                    <br>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Имя</label>
                                    <input value="{{$item->name}}" type="text" name="name" class="form-control" id="exampleInputUsername1" placeholder="{{$item->name}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Фамилия</label>
                                    <input type="text" value="{{$item->surname}}" name="surname" class="form-control" id="exampleInputEmail1" placeholder="{{$item->surname}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Эл.почта</label>
                                    <input type="email" value="{{$item->email}}" name="email"  class="form-control" id="exampleInputPassword1" placeholder="{{$item->email}}" required>
                                </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Номер телефона</label>
                                        <input type="text" value="{{$item->phone}}" name="phone"  class="form-control" id="exampleInputPassword1" placeholder="{{$item->phone}}" required>
                                    </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Область</label>
{{--                                    <input type="password"  id="exampleInputConfirmPassword1" placeholder="Password">--}}
                                    <select style="color: white" name="region_id"  class="form-control">
                                        <option  value="{{$item->region_id}}">{{$item->region}}</option>
                                        @foreach($get_region as $region)
                                        <option value="{{$region->id}}">{{$region->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Город</label>
                                        <select style="color: white" name="city_id"  class="form-control">
                                            <option  value="{{$item->city_id}}">{{$item->city}}</option>
                                            @foreach($get_city as $city)
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if($item->role_id == 3)
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Цена за работу&ensp;&ensp;</label>
                                            <input type="number" value="{{$item->priceJob}}" name="priceJob"  class="form-control" id="exampleInputPassword1" placeholder="Введите сумму " >
                                        </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Текущий баланс&ensp;&ensp;  {{$item->balance}}</label>
                                        <input type="number" value="" name="balance"  class="form-control" id="exampleInputPassword1" placeholder="Введите сумму " >
                                    </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Активность пользователя&ensp;&ensp;  {{$item->activity}}</label>
                                            <input type="number" value="" name="activity"  class="form-control" id="exampleInputPassword1" placeholder="Введите число" >
                                        </div>
                                    @endif
                                    @if($item->role_id == 2)
                                        @if($item->tariff_plus == 1)

                                            <a href="{{route('deactiveTariffPlyus',$item->id)}}" class="btn btn-inverse-warning btn-fw">Отключить  тариф плюс</a>
                                       @else
                                            <a href="{{route('activeTariffPlyus',$item->id)}}" class="btn btn-inverse-warning btn-fw">Активировать тариф плюс</a>
                                            @endif
                                        <br>

                                        <br>
                                        @endif
                                    <br>


                                    <div style="display: flex; justify-content: space-between">
                                         <button  type="submit" class="btn btn-inverse-success btn-fw">Сохранить изменение</button>
                                        <a class="btn btn-outline-warning btn-fw" href="{{route('usersChat',$item->id)}}">Переписки пользователя</a>

                                        @if($item->status == 2)
                                            <a href="{{route('succsesuser',$item->id)}}"  class="btn btn-inverse-success btn-fw">Одобрить</a>
                                        @endif

                                        @if($item->black_list == 1)
                                          <a href="{{route('addBlackList',$item->id)}}" class="btn btn-inverse-danger btn-fw">Добавит в черный список</a>
                                        @endif

                                        @if($item->black_list == 2)
                                            <a href="{{route('deleteBlackList',$item->id)}}" class="btn btn-inverse-danger btn-fw">Удалить из черного списка</a>
                                            @endif
                                    </div>

                            </form>
                            @if($item->role_id ==3)
                                <br>
                                <br>
                          <div style="    display: flex;   justify-content: center;"><h2>Транспорт Исполнителя</h2></div>
                                <br>

{{--                                $item->UserTransport[0]->TransporPhoto as $photo--}}
                                <div class="card" style="width: 31rem; border: 1px solid #14402f;">
                                    @if(isset($item->UserTransport[0]->TransporPhoto[0]->photo))
                                    <img class="card-img-top" src="{{ env('APP_URL').'storage/app/uploads/'.$item->UserTransport[0]->TransporPhoto[0]->photo }}" alt="Card image cap">
                                    @endif
                                        @foreach($item->UserTransport as $transport)
                                    <div class="card-body">

                                        <p class="card-text"> <b>Категория</b>  ` {{$transport->category_name}} </p>
                                        @if($transport->sub_category_name != null)
                                        <p class="card-text"> <b>Под Категория</b>  ` {{$transport->sub_category_name}} </p>
                                            @endif
                                        <p class="card-text"> <b>Vin номер </b> ` {{$transport->vin_code}} </p>
                                    </div>

                                    <div class="card-body" style="display: flex;  justify-content: flex-end;">
                                        <a href="{{route('SinglePageTransport',$transport->id)}}" class="btn btn-inverse-success btn-fw">Просмотреть</a>
                                    </div>
                                        @endforeach
                                </div>

                                <br>
                                <br>
                                <h3 style="display: flex; justify-content: center;" >Статистика заказов</h3>
                                <br>
                                <div class="table-responsive">
                                        <p style="display: flex; justify-content: flex-end;">Итоговая сумма комиссии ` {{ceil($sum)}}</p>
                                    <table class="table table-dark">

                                        <thead>
                                        <tr>
                                            <th> № </th>
                                            <th> дата </th>
                                            <th> начало </th>
                                            <th> конец </th>
                                            <th> рейсов/часов </th>
                                            <th> Цена </th>
                                            <th> итого </th>
                                            <th> комиссия </th>
                                        </tr>
                                        </thead>
                                        <?php $i = 0; ?>
                                        @foreach($get_stat as $stat)
                                        <tbody>
                                        <tr>
                                            <td> {{$i++}} </td>
                                            <td> {{$stat->created_at}} </td>
                                            <td> {{$stat->ActiveJobHistory->start_job}} </td>
                                            <td> {{$stat->ActiveJobHistory->end_job}} </td>
                                            <td> {{$stat->time}} </td>
                                            <td> {{ ceil( $stat->ActiveJobHistory->price)}} </td>
                                            <td> {{ ceil( $stat->price)}} </td>
                                            <td> {{ ceil( $stat->pracient)}} </td>
                                        </tr>
                                        </tbody>
                                            @endforeach
                                    </table>
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