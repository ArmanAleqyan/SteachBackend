@extends('admin.layouts.default')
@section('title')
    Сообщение
@endsection


@section('content')


    {{--    @dd($right_side_data)--}}
    <style>
        .content-wrapper {
            /*width: 1291px !important;*/
        }

        .no-gutters {
            min-height: 600px;
        }

        .users-container {
            height: 91% !important;
        }

        /*.chat-container{*/
        /*    height: 600px;*/
        /*}*/
        input {
            color: white !important;
        }
    </style>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container" style="max-width:  1334px !important; ">

        <br>
        <br>
        <br>

        <!-- Page header start -->

        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="card m-0">

                        <!-- Row start -->
                        <div class="row no-gutters">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-3 col-3"
                                 style="    background-color: #191c24; ">

                                <div style="padding: 8px;">
                                    <form id="searchForm" action="">
                                        @csrf
                                        <input id="someInput" class="form-control" type="text"
                                               placeholder="Поиск пользователей">
                                        <input type="submit" style="display: none" id="submitSearch">
                                    </form>
                                </div>
                                <div class="users-container">
                                    @foreach($right_side_data as $users)
                                        <ul class="users room_id" data-id="{{$users['room_id']}}">
                                            <li class="person" data-chat="person1">
                                                <div style="    display: flex;    align-items: center;    justify-content: space-between;">
                                                    <div>
                                                        <div class="user">
                                                            <img src="{{env('APP_URL').'storage/app/uploads/'.$users['user_image']}}"
                                                                 alt="Retail Admin">
                                                        </div>
                                                        <p class="name-time">
                                                            <span class="name">{{$users['user_name']}}</span>
                                                            <span class="name">{{$users['surname']}}</span>
                                                            <input value="{{$users['surname']}}" type="hidden"
                                                                   class="surname">
                                                            {{--                                                <span class="time">{{$users['created_at']}}</span>--}}
                                                        </p>
                                                    </div>
                                                    <div class="asdasd"
                                                         style="background-color: #ee1133; border-radius: 50px; width: 25px; display: block;">
                                                        @if($users['review'] >0 )
                                                            <div class="row_count">
                                                                <span style="display: flex; font-family: system-ui;   justify-content: center;"> {{$users['review']}}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            @if(isset($data_id))

                                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-9 col-9"
                                     style="background-color: #191c24;  ">
                                    <div class="SubmitUSer"
                                         style="    height: 600px;    display: none;     justify-content: center;    align-items: center;">
                                        <p style="border-radius: 50px;  background-color: #2f5687;   padding: 7px;">
                                            Выберите кому хотели бы написать</p>
                                    </div>
                                    <div class="selected-user">
                                        @if($get_message[0]->receiver_id == auth()->user()->id)
                                            <span> <span
                                                        class="header_name name">{{$get_message[0]->SenderMessage->name}} {{$get_message[0]->SenderMessage->surname}}</span></span>
                                        @else
                                            <span> <span
                                                        class="header_name name">{{$get_message[0]->ReceiverMessage->name}} {{$get_message[0]->ReceiverMessage->surname}}</span></span>
                                        @endif
                                    </div>

                                    <div style="" class="chat-container">
                                        @foreach($get_message as $message)

                                            <ul class="chat-box chatContainerScroll">
                                                @if($message->receiver_id == auth()->user()->id)
                                                    <li class="chat-left">
                                                        <div class="chat-avatar">
                                                            <img src="{{env('APP_URL').'storage/app/uploads/'.$message->SenderMessage->photo}}"
                                                                 alt="Retail Admin">
                                                            <div class="chat-name">{{$message->SenderMessage->name}}</div>
                                                        </div>
                                                        @if($message->file == null)
                                                            <div class="chat-text">{{$message->message}}</div>
                                                        @else
                                                            <a href="{{env('APP_URL').'storage/app/uploads/'.$message->file}}"
                                                               download="">
                                                                <img src="{{env('APP_URL').'storage/app/uploads/'.$message->file}}"
                                                                     style="    height: 130px;  width: 130px;">
                                                            </a>
                                                        @endif
                                                        <div class="chat-hour">{{$message->time}} </div>
                                                    </li>
                                                @else

                                                    <li class="chat-right">
                                                        <div class="chat-hour">{{$message->time}} </div>
                                                        @if($message->file == null)
                                                            <div class="chat-text">{{$message->message}}</div>
                                                        @else
                                                            <a href="{{env('APP_URL').'storage/app/uploads/'.$message->file}}"
                                                               download="">
                                                                <img src="{{env('APP_URL').'storage/app/uploads/'.$message->file}}"
                                                                     style="    height: 130px;  width: 130px;">
                                                            </a>
                                                        @endif
                                                        <div class="chat-avatar">
                                                            <img src="{{env('APP_URL').'storage/app/uploads/'.$message->ReceiverMessage->photo}}"
                                                                 alt="Retail Admin">
                                                            <div class="chat-name">{{$message->ReceiverMessage->name}}</div>
                                                        </div>
                                                    </li>
                                                @endif


                                            </ul>
                                        @endforeach

                                        <style>
                                            .chat-text {
                                                max-width: 600px;
                                            }

                                            .chat-text p {
                                                word-break: break-word !important;
                                            }

                                            .icon {
                                                font-size: 28px;
                                                position: absolute;
                                                left: 5px;
                                                top: 23px;
                                                cursor: pointer;
                                            }

                                            .form-control::-webkit-scrollbar {
                                                width: 0;
                                            }
                                        </style>
                                        <form enctype="multipart/form-data" id="chatSubmit">
                                            @csrf

                                            <div class="form-group mt-3 mb-0">

                                                <label style="position: relative; width: 100%;" for="">

                                                    <label for="fileMessage"><i style="cursor: pointer;"                                                             class="mdi mdi-cloud-upload icon"></i></label>
                                                    <input style="display: none" id="fileMessage" type="file"
                                                           name="file">

                                                    @if($get_message[0]->receiver_id == auth()->user()->id)
                                                        <input type="hidden" name="receiver_id"
                                                               value="{{$get_message[0]->sender_id}}">
                                                    @else
                                                        <input type="hidden" name="receiver_id"
                                                               value="{{$get_message[0]->receiver_id}}">
                                                    @endif

                                                    <textarea
                                                            style="color: white !important; padding-right: 30px; padding-left: 41px; overflow: auto"
                                                            class="form-control" name="message"
                                                            placeholder="Введите  сообщение" id="inputChat"></textarea>
                                                    <label for="submitInput"><i class="mdi mdi-send" style=" font-size: 28px;  position: absolute;      left: 858px;   top: 23px;
    cursor: pointer;"></i> </label>
                                                    <input id="submitInput" type="submit" style="display: none;">
                                                </label>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            @else
                                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-9 col-9"
                                     style="background-color: #191c24; ">
                                    <div class="SubmitUSer"
                                         style="    height: 600px;    display: flex;     justify-content: center;    align-items: center;">
                                        <p style="border-radius: 50px;  background-color: #2f5687;   padding: 7px;">
                                            Выберите кому хотели бы написать</p>
                                    </div>
                                    <div class="selected-user">
                                        <span> <span class="header_name name"></span></span>
                                    </div>

                                    <div class="chat-container">
                                        <div class="chat-inside-container">
                                            <ul class="chat-box chatContainerScroll">
                                                {{--                                                @if($message->receiver_id == auth()->user()->id)--}}
                                                {{--                                                    <li class="chat-left">--}}
                                                {{--                                                        <div class="chat-avatar">--}}
                                                {{--                                                            <img src="{{env('APP_URL').'storage/app/uploads/'.$message->SenderMessage->photo}}" alt="Retail Admin">--}}
                                                {{--                                                            <div class="chat-name">{{$message->SenderMessage->name}}</div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                        @if($message->file == null)--}}
                                                {{--                                                            <div class="chat-text">{{$message->message}}</div>--}}
                                                {{--                                                        @else--}}
                                                {{--                                                            <a href="{{env('APP_URL').'storage/app/uploads/'.$message->file}}" download="">--}}
                                                {{--                                                                <img src="{{env('APP_URL').'storage/app/uploads/'.$message->file}}" style="    height: 130px;  width: 130px;">--}}
                                                {{--                                                            </a>--}}
                                                {{--                                                        @endif--}}
                                                {{--                                                        <div class="chat-hour">{{$message->time}} </div>--}}
                                                {{--                                                    </li>--}}
                                                {{--                                                @else--}}

                                                {{--                                                    <li class="chat-right">--}}
                                                {{--                                                        <div class="chat-hour">{{$message->time}} </div>--}}
                                                {{--                                                        @if($message->file == null)--}}
                                                {{--                                                            <div class="chat-text">{{$message->message}}</div>--}}
                                                {{--                                                        @else--}}
                                                {{--                                                            <a href="{{env('APP_URL').'storage/app/uploads/'.$message->file}}" download="">--}}
                                                {{--                                                                <img src="{{env('APP_URL').'storage/app/uploads/'.$message->file}}" style="    height: 130px;  width: 130px;">--}}
                                                {{--                                                            </a>--}}
                                                {{--                                                        @endif--}}
                                                {{--                                                        <div class="chat-avatar">--}}
                                                {{--                                                            <img src="{{env('APP_URL').'storage/app/uploads/'.$message->ReceiverMessage->photo}}" alt="Retail Admin">--}}
                                                {{--                                                            <div class="chat-name">{{$message->ReceiverMessage->name}}</div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </li>--}}
                                                {{--                                                @endif--}}


                                            </ul>


                                        </div>


                                        <style>
                                            .chat-text {
                                                max-width: 600px;
                                            }

                                            .chat-text p {
                                                word-break: break-word !important;
                                            }

                                            .icon {
                                                font-size: 28px;
                                                position: absolute;
                                                left: 5px;
                                                top: 23px;
                                                cursor: pointer;
                                            }

                                            .form-control::-webkit-scrollbar {
                                                width: 0;
                                            }

                                            .users-container {
                                                max-height: 600px;
                                                overflow: auto;
                                            }

                                            .users-container::-webkit-scrollbar {
                                                width: 0;
                                            }

                                            .chat-right .chat-text {
                                                /*clip-path: polygon(0% 0%, 95% 0, 95% 80%, 100% 100%, 80% 90%, 0 90%);*/
                                                border-radius: 15px 15px 0px 15px !important;
                                            }

                                            .chat-left .chat-text {
                                                /*clip-path: polygon(20% 90%, 1% 98%, 10% 80%, 10% 0, 100% 0, 100% 90%);*/
                                                border-radius: 15px 15px 15px 0px !important
                                            }

                                            .chat-inside-container {
                                                display: flex;
                                                flex-direction: column;
                                                min-height: 600px;
                                                justify-content: flex-end;
                                            }
                                        </style>
                                        <form enctype="multipart/form-data" id="chatSubmit">
                                            @csrf

                                            <div class="form-group mt-3 mb-0">
                                                <span id="uploadfile"></span>
                                                <label style="font-size: 0.875rem; line-height: 1; vertical-align: top;  background: #2a3038;  align-items: flex-end; display: flex;  justify-content: space-between; gap: 10px; "
                                                       for="">
                                                    <label for="fileMessage" style="font-size: 25px;"><i style="cursor: pointer"
                                                                class="mdi mdi-cloud-upload "></i></label>
                                                    <input style="display: none" id="fileMessage" type="file"
                                                           name="file">

                                                    <textarea
                                                            style="color: white !important;  overflow: auto"
                                                            class="form-control" name="message"
                                                            placeholder="Введите  сообщение" id="inputChat"></textarea>
                                                    <label for="submitInput" style="font-size: 28px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-right: 5px;"><i class="mdi mdi-send"
                            style=" font-size: 28px; cursor: pointer;"></i>
                                                    </label>
                                                    <input id="submitInput" type="submit" style="display: none;">
                                                </label>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            @endif
                        </div>
                        <!-- Row end -->
                    </div>

                </div>

            </div>
            <!-- Row end -->

        </div>
        <!-- Content wrapper end -->

    </div>

    <style>
        .selected-user {
            display: none;
        }

        .chat-container {
            display: none;
            overflow: auto;
            height: 600px;
        }

        .chat-container::-webkit-scrollbar {
            width: 0;
        }

        .container-fluid {
            margin-left: 1px !important;
        }

        /*************** 1.Variables ***************/


        /* ------------------ Color Pallet ------------------ */


        /*************** 2.Mixins ***************/


        /************************************************
            ************************************************
                                                Search Box
            ************************************************
        ************************************************/

        .chat-search-box {
            -webkit-border-radius: 3px 0 0 0;
            -moz-border-radius: 3px 0 0 0;
            border-radius: 3px 0 0 0;
            padding: .75rem 1rem;
        }

        .chat-search-box .input-group .form-control {
            -webkit-border-radius: 2px 0 0 2px;
            -moz-border-radius: 2px 0 0 2px;
            border-radius: 2px 0 0 2px;
            border-right: 0;
        }

        .chat-search-box .input-group .form-control:focus {
            border-right: 0;
        }

        .chat-search-box .input-group .input-group-btn .btn {
            -webkit-border-radius: 0 2px 2px 0;
            -moz-border-radius: 0 2px 2px 0;
            border-radius: 0 2px 2px 0;
            margin: 0;
        }

        .chat-search-box .input-group .input-group-btn .btn i {
            font-size: 1.2rem;
            line-height: 100%;
            vertical-align: middle;
        }

        @media (max-width: 767px) {
            .chat-search-box {
                display: none;
            }
        }


        /************************************************
            ************************************************
                                            Users Container
            ************************************************
        ************************************************/

        .users-container {
            position: relative;
            padding: 1rem 0;
            border-right: 1px solid #e6ecf3;
            height: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
        }


        /************************************************
            ************************************************
                                                    Users
            ************************************************
        ************************************************/

        .users {
            padding: 0;
        }

        .users .person {
            position: relative;
            width: 100%;
            padding: 10px 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f0f4f8;
        }

        .users .person:hover {
            background-color: #2f5687;
            /* Fallback Color */
            background-image: -webkit-gradient(linear, left top, left bottom, from(#2f5687), to(#2f5687));
            /* Saf4+, Chrome */
            background-image: -webkit-linear-gradient(right, #2f5687, #2f5687);
            /* Chrome 10+, Saf5.1+, iOS 5+ */
            background-image: -moz-linear-gradient(right, #2f5687, #2f5687);
            /* FF3.6 */
            background-image: -ms-linear-gradient(right, #2f5687, #2f5687);
            /* IE10 */
            background-image: -o-linear-gradient(right, #2f5687, #2f5687);
            /* Opera 11.10+ */
            background-image: linear-gradient(right, #2f5687, #2f5687);
        }

        .users .person.active-user {
            background-color: #2f5687;
            /* Fallback Color */
            background-image: -webkit-gradient(linear, left top, left bottom, from(#2f5687), to(#2f5687));
            /* Saf4+, Chrome */
            background-image: -webkit-linear-gradient(right, #2f5687, #2f5687);
            /* Chrome 10+, Saf5.1+, iOS 5+ */
            background-image: -moz-linear-gradient(right, #2f5687, #2f5687);
            /* FF3.6 */
            background-image: -ms-linear-gradient(right, #2f5687, #2f5687);
            /* IE10 */
            background-image: -o-linear-gradient(right, #2f5687, #2f5687);
            /* Opera 11.10+ */
            background-image: linear-gradient(right, #2f5687, #2f5687);
        }

        .users .person:last-child {
            border-bottom: 0;
        }

        .users .person .user {
            display: inline-block;
            position: relative;
            margin-right: 10px;
        }

        .users .person .user img {
            width: 48px;
            height: 48px;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
        }

        .users .person .user .status {
            width: 10px;
            height: 10px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
            background: #e6ecf3;
            position: absolute;
            top: 0;
            right: 0;
        }

        .users .person .user .status.online {
            background: #9ec94a;
        }

        .users .person .user .status.offline {
            background: #c4d2e2;
        }

        .users .person .user .status.away {
            background: #f9be52;
        }

        .users .person .user .status.busy {
            background: #fd7274;
        }

        .users .person p.name-time {
            font-weight: 600;
            font-size: .85rem;
            display: inline-block;
        }

        .users .person p.name-time .time {
            font-weight: 400;
            font-size: .7rem;
            text-align: right;
            color: #8796af;
        }

        @media (max-width: 767px) {
            .users .person .user img {
                width: 30px;
                height: 30px;
            }

            .users .person p.name-time {
                display: none;
            }

            .users .person p.name-time .time {
                display: none;
            }
        }


        /************************************************
            ************************************************
                                            Chat right side
            ************************************************
        ************************************************/

        .selected-user {
            width: 100%;
            padding: 0 15px;
            min-height: 64px;
            line-height: 64px;
            border-bottom: 1px solid #e6ecf3;
            -webkit-border-radius: 0 3px 0 0;
            -moz-border-radius: 0 3px 0 0;
            border-radius: 0 3px 0 0;
        }

        .selected-user span {
            line-height: 100%;
        }

        .selected-user span.name {
            font-weight: 700;
        }

        .chat-container {
            position: relative;
            padding: 1rem;
        }

        .chat-container li.chat-left,
        .chat-container li.chat-right {
            display: flex;
            flex: 1;
            flex-direction: row;
            margin-bottom: 40px;
        }

        .chat-container li img {
            width: 48px;
            height: 48px;
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;
        }

        .chat-container li .chat-avatar {
            margin-right: 20px;
        }

        .chat-container li.chat-right {
            justify-content: flex-end;
        }

        .chat-container li.chat-right > .chat-avatar {
            margin-left: 20px;
            margin-right: 0;
        }

        .chat-container li .chat-name {
            font-size: .75rem;
            color: #999999;
            text-align: center;
        }

        .chat-container li .chat-text {
            padding: .4rem 1rem;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            background: #000000;
            font-weight: 300;
            line-height: 150%;
            position: relative;
        }

        /*.chat-container li .chat-text:before {*/
        /*    content: '';*/
        /*    position: absolute;*/
        /*    width: 0;*/
        /*    height: 0;*/
        /*    top: 10px;*/
        /*    left: -20px;*/
        /*    border: 10px solid;*/
        /*    border-color: transparent #ffffff transparent transparent;*/
        /*}*/

        .chat-container li.chat-right > .chat-text {
            text-align: right;
        }

        .chat-container li.chat-right > .chat-text:before {
            right: -20px;
            border-color: transparent transparent transparent #ffffff;
            left: inherit;
        }

        .chat-container li .chat-hour {
            padding: 0;
            margin-bottom: 10px;
            font-size: .75rem;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            margin: 0 0 0 15px;
        }

        .chat-container li .chat-hour > span {
            font-size: 16px;
            color: #9ec94a;
        }

        .chat-container li.chat-right > .chat-hour {
            margin: 0 15px 0 0;
        }

        @media (max-width: 767px) {
            .chat-container li.chat-left,
            .chat-container li.chat-right {
                flex-direction: column;
                margin-bottom: 30px;
            }

            .chat-container li img {
                width: 32px;
                height: 32px;
            }

            .chat-container li.chat-left .chat-avatar {
                margin: 0 0 5px 0;
                display: flex;
                align-items: center;
            }

            .chat-container li.chat-left .chat-hour {
                justify-content: flex-end;
            }

            .chat-container li.chat-left .chat-name {
                margin-left: 5px;
            }

            .chat-container li.chat-right .chat-avatar {
                order: -1;
                margin: 0 0 5px 0;
                align-items: center;
                display: flex;
                justify-content: right;
                flex-direction: row-reverse;
            }

            .chat-container li.chat-right .chat-hour {
                justify-content: flex-start;
                order: 2;
            }

            .chat-container li.chat-right .chat-name {
                margin-right: 5px;
            }

            .chat-container li .chat-text {
                font-size: .8rem;
            }
        }

        .chat-form {
            padding: 15px;
            width: 100%;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ffffff;
            border-top: 1px solid white;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .card {
            border: 0;
            background: #f4f5fb;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            margin-bottom: 2rem;
            box-shadow: none;
        }
    </style>

@endsection

