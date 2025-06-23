@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        <div class="table-responsive cart_info col-sm-9">
            <?php
                $content = Cart::content();
            ?>
            <table class="table table-condensed">
                <thead>
                <tr class="cart_menu">
                    <td class="image">Hình ảnh</td>
                    <td class="description">Mô tả</td>
                    <td class="price">Giá</td>
                    <td class="quantity">Số lượng</td>
                    <td class="total">Tổng tiền</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;

                    ?>
                    @foreach($content as $v_content)
                    <?php
                        $i++;

                    ?>
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('upload/product/'.$v_content->options->image)}}" alt="" width="50" height="50"/>
                            </a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>ID: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price).' '.'VNĐ'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                    {{csrf_field()}}
                                    <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}"  size="2">

                                    <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class ="form-control">
                                    <input type="submit" value="Cập nhật" name="update_qty" class ="btn btn-compose btn-sm">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                {{number_format($v_content->qty * $v_content->price).' '.'VNĐ'}}
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->
<section id="do_action">
    <div class="container">

        <div class="row col-sm-9">

            <div class="col-sm-12">
                <div class="total_area">
                    <?php
                    if($i>0){
                    ?>
                    <ul>
                        <li>Tổng tiền <span>{{Cart::subtotal().' '.'VNĐ'}}</span></li>
                        <li>Thuế <span>{{Cart::tax().' '.'VNĐ'}}</span></li>
                        <li>Phí vận chuyển <span>Free</span></li>
                        <li>Thành tiền <span>{{Cart::total().' '.'VNĐ'}}</span></li>
                    </ul>
{{--                    <a class="btn btn-default update" href="">Update</a>--}}
                    <?php
                        }else{
                        ?>
                        <h3>Vui lòng thêm sản phẩm vào giỏ hàng trước khi đặt hàng</h3>
                        <a class="btn btn-default check_out" href="{{URL::to('/trang-chu')}}"> Home</a>
                        <?php
                        }
                        ?>

                    <?php

                    $customer_id = Session::get('customer_id');
                    if($customer_id && $i > 0){



                    ?>
                    <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}"> Thanh toán</a>
                    <?php
                    }
                    else if(!$customer_id) {
                    ?>
                    <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}"> Thanh toán</a>
                    <?php
                    }else{

                        ?>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->

@endsection
