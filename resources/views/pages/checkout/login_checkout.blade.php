@extends('layout')
@section('content')

<section id="form"><!--form-->
    <div class="haha">
        <div class="row">
            <?php
                if ($error = Session::get('error')) {
            ?>
            <h2 class="text-center"><?php
                echo $error;
                Session::put('error',null);
                ?></h2>
            <?php

            }
            ?>
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Đăng nhập vào tài khoản</h2>
                    <form action="{{URL::to('/login-customer')}}" method="POST">
                        {{csrf_field()}}
                        <input type="text" name="email_account" placeholder="Tài khoản" />
                        <input type="password" name="password_account" placeholder="Password" />
                        <span>
                            <input type="checkbox" class="checkbox">
                            Ghi nhớ đăng nhập
                        </span>
                        <button type="submit" class="btn btn-default">Đăng nhập</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">HOẶC</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Tạo tài khoản mới</h2>
                    <form action="{{URL::to('/add-customer')}}" method="POST">
                        {{csrf_field()}}
                        <input type="text" name="customer_name" placeholder="Họ và tên"/>
                        <input type="email" name="customer_email" placeholder="Email"/>
                        <input type="password" name="customer_password" placeholder="Mật khẩu"/>
                        <input type="text" name="customer_phone" placeholder="Số điện thoại"/>
                        <button type="submit" class="btn btn-default">Đăng ký</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->


@endsection
