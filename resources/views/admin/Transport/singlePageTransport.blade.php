@extends('admin.layouts.default')
@section('title')
    Транспорт


@endsection

<style>
    input{
        color: white !important;
    }

    * {
        margin: 0;
        padding: 0;
        font-weight: normal;
    }


</style>


@section('content')
    @foreach($get_transport as $item)

        @if(session('succses'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Изменения успешно сохранено',
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

                                <div class="card" style="width: 18rem; border: 3px solid #47381d;">
                                    <img class="card-img-top" src="{{env('APP_URL').'storage/app/uploads/'.$item->UserTransport->photo}}" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Владелец</h5>
                                       <h4 class="card-text">{{$item->UserTransport->name}} {{$item->UserTransport->surname}}</h4>
                                        <a href="{{route('OnePageGetNewCustomers',$item->UserTransport->id )}}" class="btn btn-inverse-warning btn-fw">Профиль</a>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div style="display: flex; justify-content: space-between">



                                    <h4 class="card-title">Редактирования Транспорта  </h4>
                                    <a style="height: 30px;" class="btn btn-inverse-warning btn-fw" href="{{route('OnePageGetNewCustomers',$item->UserTransport->id )}}">Назад</a>
                                </div>

                                <br>
                                <br>
                                <form name="form-example-1" id="form-example-1"  action="{{route('UpdateTransport')}}" method="post" enctype="multipart/form-data" class="forms-sample">
                                    @csrf
                                    <input type="hidden" name="transport_id" value="{{$item->id}}">


                                   <div></div> Фотографии транспорта
                                    <div style="display: flex;    flex-wrap: wrap; align-items: center;  width: 100%;" class="similar_ads_items_wrapper">
                                        @foreach($item->TransporPhoto as $files)
                                            <div class="similar_ads_item_child" >
                                                <div style="  padding: 10px;"  class=" similar_ads_item_child_link_img1 image-destroy" >
                                                    <svg   style="    cursor: pointer;    position: relative;    display: flex;    top: 27px;    left: 153px;" class="deletePhoto" data-id="{{$files->id}}" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 100 100" width="35px" height="35px"><path fill="#f37e98" d="M25,30l3.645,47.383C28.845,79.988,31.017,82,33.63,82h32.74c2.613,0,4.785-2.012,4.985-4.617L75,30"/><path fill="#f15b6c" d="M65 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S65 36.35 65 38zM53 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S53 36.35 53 38zM41 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S41 36.35 41 38zM77 24h-4l-1.835-3.058C70.442 19.737 69.14 19 67.735 19h-35.47c-1.405 0-2.707.737-3.43 1.942L27 24h-4c-1.657 0-3 1.343-3 3s1.343 3 3 3h54c1.657 0 3-1.343 3-3S78.657 24 77 24z"/><path fill="#1f212b" d="M66.37 83H33.63c-3.116 0-5.744-2.434-5.982-5.54l-3.645-47.383 1.994-.154 3.645 47.384C29.801 79.378 31.553 81 33.63 81H66.37c2.077 0 3.829-1.622 3.988-3.692l3.645-47.385 1.994.154-3.645 47.384C72.113 80.566 69.485 83 66.37 83zM56 20c-.552 0-1-.447-1-1v-3c0-.552-.449-1-1-1h-8c-.551 0-1 .448-1 1v3c0 .553-.448 1-1 1s-1-.447-1-1v-3c0-1.654 1.346-3 3-3h8c1.654 0 3 1.346 3 3v3C57 19.553 56.552 20 56 20z"/><path fill="#1f212b" d="M77,31H23c-2.206,0-4-1.794-4-4s1.794-4,4-4h3.434l1.543-2.572C28.875,18.931,30.518,18,32.265,18h35.471c1.747,0,3.389,0.931,4.287,2.428L73.566,23H77c2.206,0,4,1.794,4,4S79.206,31,77,31z M23,25c-1.103,0-2,0.897-2,2s0.897,2,2,2h54c1.103,0,2-0.897,2-2s-0.897-2-2-2h-4c-0.351,0-0.677-0.185-0.857-0.485l-1.835-3.058C69.769,20.559,68.783,20,67.735,20H32.265c-1.048,0-2.033,0.559-2.572,1.457l-1.835,3.058C27.677,24.815,27.351,25,27,25H23z"/><path fill="#1f212b" d="M61.5 25h-36c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h36c.276 0 .5.224.5.5S61.776 25 61.5 25zM73.5 25h-5c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5c.276 0 .5.224.5.5S73.776 25 73.5 25zM66.5 25h-2c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2c.276 0 .5.224.5.5S66.776 25 66.5 25zM50 76c-1.654 0-3-1.346-3-3V38c0-1.654 1.346-3 3-3s3 1.346 3 3v25.5c0 .276-.224.5-.5.5S52 63.776 52 63.5V38c0-1.103-.897-2-2-2s-2 .897-2 2v35c0 1.103.897 2 2 2s2-.897 2-2v-3.5c0-.276.224-.5.5-.5s.5.224.5.5V73C53 74.654 51.654 76 50 76zM62 76c-1.654 0-3-1.346-3-3V47.5c0-.276.224-.5.5-.5s.5.224.5.5V73c0 1.103.897 2 2 2s2-.897 2-2V38c0-1.103-.897-2-2-2s-2 .897-2 2v1.5c0 .276-.224.5-.5.5S59 39.776 59 39.5V38c0-1.654 1.346-3 3-3s3 1.346 3 3v35C65 74.654 63.654 76 62 76z"/><path fill="#1f212b" d="M59.5 45c-.276 0-.5-.224-.5-.5v-2c0-.276.224-.5.5-.5s.5.224.5.5v2C60 44.776 59.776 45 59.5 45zM38 76c-1.654 0-3-1.346-3-3V38c0-1.654 1.346-3 3-3s3 1.346 3 3v35C41 74.654 39.654 76 38 76zM38 36c-1.103 0-2 .897-2 2v35c0 1.103.897 2 2 2s2-.897 2-2V38C40 36.897 39.103 36 38 36z"/></svg>
                                                    <img style="max-width: 179px; width: 100%; min-height: 170px;"
                                                            src=" {{ env('APP_URL').'storage/app/uploads/'.$files->photo}}"
                                                            alt="">
                                                </div>
                                                <div class="similar_ads_item_child_info_box">
                                                    <div class="similar_ads_items_child_call_message_btns_wrapper">
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                    <div class="container">


                                        <style>
                                            .upload-text{
                                                cursor: pointer;
                                            }
                                        </style>

                                        <br>
                                            <div class="input-field">
                                                <label style="    display: flex;  justify-content: center;" class="active">
                                                    Добавить новые фотографии транспорта
                                                </label>
                                                <div class="input-images-2" style="padding-top: .5rem;"></div>
                                            </div>




                                    </div>


                                    <div id="show-submit-data" class="modal" style="visibility: hidden;">
                                        <div class="content">
                                            <h4>Submitted data:</h4>
                                            <p id="display-name"><strong>Name:</strong> <span></span></p>
                                            <p id="display-description"><strong>Description:</strong> <span></span></p>
                                            <p><strong>Uploaded images:</strong></p>
                                            <ul id="display-new-images"></ul>
                                            <p><strong>Preloaded images:</strong></p>
                                            <ul id="display-preloaded-images"></ul>
                                            <a href="javascript:$('#show-submit-data').css('visibility', 'hidden')" class="close"><i
                                                        class="material-icons">close</i></a>
                                        </div>
                                    </div>

                                    <br><br>


                                    <br>
                                    <br>
                                <div>Фотографии технического паспорта</div>

                                    <br>
                                    <br>

                                    <div  style="display: flex; justify-content: space-around;">
                                        <div  style="background-color: transparent;  border: none;" class="btn btn-primary" >
                                            <div data-toggle="modal" data-target="#exampleModalCenter2">
                                            <input type="hidden" name="tex_passport1_id" value="{{$item->texPassport[0]->id}}">
                                            <img class="photoModal" style="max-height: 160px; max-width: 172px; width: 100%;" src=" {{ env('APP_URL').'storage/app/uploads/'.$item->texPassport[0]->photo }} " alt="image" id="blahas">
                                            <br>
                                            </div>
                                            <input accept="image/*" style="display: none" name="tex_passport1" id="file-logos" class="btn btn-outline-success" type="file">
                                            <br>
                                            <label style="" for="file-logos" class="custom-file-upload btn btn-outline-success">
                                                изменить техпаспорт
                                            </label>
                                        </div>
                                        <div style="background-color: transparent;  border: none;" class="btn btn-primary" >
                                            <div data-toggle="modal" data-target="#exampleModalCenter">
                                            <input type="hidden" name="tex_passport2_id" value="{{$item->texPassport[1]->id}}">
                                            <img class="photoModal" style="max-height: 160px; max-width: 172px; width: 100%;" src=" {{ env('APP_URL').'storage/app/uploads/'.$item->texPassport[1]->photo }} " alt="image" id="blaha">
                                            <br>
                                            </div>
                                            <input accept="image/*" style="display: none" name="tex_passport2" id="file-logo" class="btn btn-outline-success" type="file">
                                            <br>

                                            <label style="" for="file-logo" class="custom-file-upload btn btn-outline-success">
                                                изменить техпаспорт
                                            </label>
                                        </div>
                                    </div>
                                    <br>
                                    <br>

                                    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <button  style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img style="width:  100%" src="" class="addMOdal" alt="">

                                                                                                    </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img style="width:  100%" src="" class="addMOdal" alt="">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Vin номер</label>
                                        <input type="text" value="{{$item->vin_code}}" name="vin_code"  class="form-control" id="exampleInputPassword1" placeholder="{{$item->vin_code}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Категории</label>
                                        {{--                                    <input type="password"  id="exampleInputConfirmPassword1" placeholder="Password">--}}
                                        <select style="color: white" name="category_id"  class="form-control">
                                            <option  value="{{$item->category_id}}">{{$item->category_name}}</option>
                                            @foreach($category as $categorys)
                                                <option value="{{$categorys->id}}">{{$categorys->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Под категории</label>
                                        <select style="color: white" name="sub_category_id"  class="form-control">
                                            <option  value="{{$item->sub_category}}">{{$item->sub_category_name}}</option>
                                            @foreach($sub_categorty as $sub_categortys)
                                                <option value="{{$sub_categortys->id}}">{{$sub_categortys->sub_category_name}}</option>
                                            @endforeach
                                        </select>
                                        <a style="display: flex; justify-content: flex-end; color: #cf8888;" href="{{route('deleteSubCategory',$item->id)}}">удалить под категорию</a>
                                    </div>
                                    <br>
                                    <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                                        <div class="card-header">Дополнительные оборудование</div>
                                        <div class="card-body">
                                            <input type="hidden" name="additionale_id[]" value="">
                                            <ul >

                                                @foreach($item->TransportAdditional as $add)
                                                <li class="additional">
                                                    {{$add->additional_name }} &ensp; &ensp;
                                                    <svg style="    cursor: pointer;    position: relative;  width: 28px;" class="deleteadditional" data-id="{{$add->id}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="35px" height="35px"><path fill="#f37e98" d="M25,30l3.645,47.383C28.845,79.988,31.017,82,33.63,82h32.74c2.613,0,4.785-2.012,4.985-4.617L75,30"></path><path fill="#f15b6c" d="M65 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S65 36.35 65 38zM53 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S53 36.35 53 38zM41 38v35c0 1.65-1.35 3-3 3s-3-1.35-3-3V38c0-1.65 1.35-3 3-3S41 36.35 41 38zM77 24h-4l-1.835-3.058C70.442 19.737 69.14 19 67.735 19h-35.47c-1.405 0-2.707.737-3.43 1.942L27 24h-4c-1.657 0-3 1.343-3 3s1.343 3 3 3h54c1.657 0 3-1.343 3-3S78.657 24 77 24z"></path><path fill="#1f212b" d="M66.37 83H33.63c-3.116 0-5.744-2.434-5.982-5.54l-3.645-47.383 1.994-.154 3.645 47.384C29.801 79.378 31.553 81 33.63 81H66.37c2.077 0 3.829-1.622 3.988-3.692l3.645-47.385 1.994.154-3.645 47.384C72.113 80.566 69.485 83 66.37 83zM56 20c-.552 0-1-.447-1-1v-3c0-.552-.449-1-1-1h-8c-.551 0-1 .448-1 1v3c0 .553-.448 1-1 1s-1-.447-1-1v-3c0-1.654 1.346-3 3-3h8c1.654 0 3 1.346 3 3v3C57 19.553 56.552 20 56 20z"></path><path fill="#1f212b" d="M77,31H23c-2.206,0-4-1.794-4-4s1.794-4,4-4h3.434l1.543-2.572C28.875,18.931,30.518,18,32.265,18h35.471c1.747,0,3.389,0.931,4.287,2.428L73.566,23H77c2.206,0,4,1.794,4,4S79.206,31,77,31z M23,25c-1.103,0-2,0.897-2,2s0.897,2,2,2h54c1.103,0,2-0.897,2-2s-0.897-2-2-2h-4c-0.351,0-0.677-0.185-0.857-0.485l-1.835-3.058C69.769,20.559,68.783,20,67.735,20H32.265c-1.048,0-2.033,0.559-2.572,1.457l-1.835,3.058C27.677,24.815,27.351,25,27,25H23z"></path><path fill="#1f212b" d="M61.5 25h-36c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h36c.276 0 .5.224.5.5S61.776 25 61.5 25zM73.5 25h-5c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5c.276 0 .5.224.5.5S73.776 25 73.5 25zM66.5 25h-2c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2c.276 0 .5.224.5.5S66.776 25 66.5 25zM50 76c-1.654 0-3-1.346-3-3V38c0-1.654 1.346-3 3-3s3 1.346 3 3v25.5c0 .276-.224.5-.5.5S52 63.776 52 63.5V38c0-1.103-.897-2-2-2s-2 .897-2 2v35c0 1.103.897 2 2 2s2-.897 2-2v-3.5c0-.276.224-.5.5-.5s.5.224.5.5V73C53 74.654 51.654 76 50 76zM62 76c-1.654 0-3-1.346-3-3V47.5c0-.276.224-.5.5-.5s.5.224.5.5V73c0 1.103.897 2 2 2s2-.897 2-2V38c0-1.103-.897-2-2-2s-2 .897-2 2v1.5c0 .276-.224.5-.5.5S59 39.776 59 39.5V38c0-1.654 1.346-3 3-3s3 1.346 3 3v35C65 74.654 63.654 76 62 76z"></path><path fill="#1f212b" d="M59.5 45c-.276 0-.5-.224-.5-.5v-2c0-.276.224-.5.5-.5s.5.224.5.5v2C60 44.776 59.776 45 59.5 45zM38 76c-1.654 0-3-1.346-3-3V38c0-1.654 1.346-3 3-3s3 1.346 3 3v35C41 74.654 39.654 76 38 76zM38 36c-1.103 0-2 .897-2 2v35c0 1.103.897 2 2 2s2-.897 2-2V38C40 36.897 39.103 36 38 36z"></path></svg>
                                                </li>
                                                    <br>
                                                    <br>

                                                    @endforeach

                                                    <style>
                                                        .dropdown-item{
                                                            color: white !important;
                                                            cursor: pointer;
                                                        }
                                                    </style>
{{--                                                    <div  style="display: flex; justify-content: center;" class="dropdown">--}}
{{--                                                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuOutlineButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Добавить оборудование </button>--}}
{{--                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton5" style="">--}}




{{--                                                        </div>--}}

{{--                                                    </div>--}}
                                                    <input style="border: 2px solid green;" type="text" name="yuix" class="form-control" value="">
                                            </ul>
                                            <h5 class="card-title"></h5>

                                        </div>
                                    </div>
                                    <style>
                                        .bg-secondary{
                                            background-color:#313131 !important;
                                        }
                                    </style>
                                    <br>
                                    <div style="display: flex; justify-content: space-between">
                                        <button  type="submit" class="btn btn-inverse-success btn-fw">Сохранить изменение</button>


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

                            </div>

                        </div>

                    </div>



                </div>
            </div>

        </div>
    @endforeach
@endsection

