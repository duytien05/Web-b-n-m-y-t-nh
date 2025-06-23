@extends('layout')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                    <li class="active">Xem lại giỏ hàng</li>
                </ol>
            </div>
            <div class="review-payment">
                <h2>Xem lại giỏ hàng</h2>
            </div>

            <div class="table-responsive cart_info">
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
                    @foreach($content as $v_content)
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

            <h4 style="margin: 55px 0; font-size: 20px;">Chọn hình thức thanh toán</h4>
            <form action="{{URL::to('/order')}}" method="POST">
                {{csrf_field()}}
                <div class="payment-options">
{{--                <span>--}}
{{--                    <label><input name="payment_option" value="1" type="checkbox"> Thanh toán bằng thẻ ATM</label>--}}
{{--                </span>--}}
                <span>
                    <label><input name="payment_option" value="2" type="checkbox" checked > Trả tiền mặt</label>
                </span><br>
                    <?php
                    foreach($content as $v_content)
                        if($v_content->qty > 0){?>
                        <span>
                            <input type="submit" value="Đặt hàng" name="send_order" class ="btn btn-primary btn-sm-6x">
                        </span><?php
                    }else{

                    }

                    ?>
                </div>
            </form>

        </div>
    </section> <!--/#cart_items-->


@endsection
