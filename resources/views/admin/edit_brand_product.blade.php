@extends('admin_layout');
@section('admin_content');
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật thương hiệu sản phẩm
            </header>
            <div class="panel-body">
                @foreach($edit_brand_product as $key=> $edit_value)

                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="tensp">Tên thương hiệu</label>
                                <input type="text" value="{{$edit_value->brand_name}}" name="brand_product_name" class="form-control" id="tensp" placeholder="Tên danh mục">
                            </div>
                            <div class="form-group">
                                <label for="mota">Mô tả thương hiệu</label>
                                <textarea style="resize: none" rows ="6" class="form-control" name="brand_product_description" id="mota">{{$edit_value->brand_description}}</textarea>
                            </div>


                            <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật thương hiệu</button>
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
                        </form>
                    </div>
                @endforeach

            </div>
        </section>

    </div>
@endsection
