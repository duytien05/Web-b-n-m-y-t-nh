@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>



        <div class="register-req col-sm-9">
            <p>Đăng nhập hoặc đăng ký tài khoản để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
        </div><!--/register-req-->
   


        <div class="shopper-informations">
            <div class="row">
           
                <div class="col-sm-9">
                    <div class="bill-to">
                        <p>Thông tin gửi hàng</p>
                        <?php
                        if ($error = Session::get('error')) {
                        ?>
                        <div><p><br></p></div>
                        <div class="alert alert-danger"><?php
                            echo $error;
                            Session::put('error',null);
                            ?></div>
                        <?php

                        }
                        ?>
                        <div class="form-one">
                            <form action="{{URL::to('/save-checkout-customer')}}" method="POST">
                                {{csrf_field()}}
                                <input type="text" name="shipping_email" placeholder="Email*">
                                <input type="text" name="shipping_name" placeholder="Họ và tên *">
                                <input type="text" name="shipping_address" placeholder="Địa chỉ *">
                                <input type="text" name="shipping_phone" placeholder="Số điện thoại">
                                <p>Ghi chú gửi hàng</p>
                                <textarea name="shipping_note"  placeholder="Ghi chú đơn hàng của bạn" rows="16"></textarea>
                                <input type="submit" value="Gửi" name="send_order" class ="btn btn-primary btn-sm">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="review-payment">
            <h2>Hình thức thanh toán</h2>
        </div>
<br>
        <div class="payment-options">
{{--                <span>--}}
{{--                    <label><input name="payment_option" value="1" type="checkbox"> Thanh toán bằng thẻ ATM</label>--}}
{{--                </span>--}}
            <span>
                    <label><input name="payment_option" value="2" type="checkbox"> Trả tiền mặt</label>
                </span><br>
        </div>
    </div>
</section> <!--/#cart_items-->


@endsection
