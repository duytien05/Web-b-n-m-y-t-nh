@extends('admin_layout');
@section('admin_content');
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Đơn hàng
        </div>
        <div class="table-responsive">
            <?php
            if ($message = Session::get('message')) {
            ?>
            <div><p><br></p></div>
            <div class="alert alert-success"><?php
                echo $message;
                Session::put('message',null);
                ?></div>
            <?php

            }
            ?>
            <table class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th style="width:20px;">
                        <label class="i-checks m-b-none">
                            <input type="checkbox"><i></i>
                        </label>
                    </th>
                    <th>Tên người đặt</th>
                    <th>Tổng giá tiền</th>
                    <th>Tình trạng</th>
                    <th>Hiển thị</th>
                    <th style="width:30px;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($all_order as $key =>$order)
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{$order->customer_name}}</td>
                        <td>{{$order->order_total}}</td>
                        <td>{{$order->order_status}}</td>
                        <td>
                            <a href="{{URL::to('/view-order/'.$order->order_id)}}" class="active" ui-toggle-class="">
                                <i class="fa fa-edit text-success text-active"></i>
                            </a>
                            <a onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?')" href="{{URL::to('/delete-order/'.$order->order_id)}}" class="active" ui-toggle-class="">
                                <i class="fa fa-times text-danger text"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                        <li><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">4</a></li>
                        <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
