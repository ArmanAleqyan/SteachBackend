@extends('admin.layouts.default')
@section('title')
    Приглашения
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
                        <div style="display: flex;    justify-content: space-between;    align-items: baseline;">
                            <h4 class="card-title" style="color: #2f5687 !important">Приглашения</h4>
                        </div>
                        <br>
                        <br>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>


                                    <th> Заказчик </th>
                                    <th> Исполнитель</th>


                                </tr>
                                </thead>
                                @foreach($get_invite as $item)

                                    <tbody >
                                    <tr>
                                            <td>{{$item->SenderInviteHistory->name}} {{$item->SenderInviteHistory->surname}}</td>
                                            <td>{{$item->ReceiverInviteHistory->name}} {{$item->ReceiverInviteHistory->surname}}</td>
                                            <td>Отклонил приглашение</td>
                                        @if(isset($item->TenderNameHistory))
                                            <td>{{$item->TenderNameHistory->name}}</td>
                                            @endif
                                    </tr>

                                    </tbody>
                                @endforeach

                            </table>

                        </div>

                    </div>
                    <div style="display: flex; justify-content: center;">{{$get_invite->links()}}</div>
                </div>
            </div>
        </div>

    </div>
@endsection