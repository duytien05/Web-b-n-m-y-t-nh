@extends('admin_layout');
@section('admin_content');
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm thương hiệu sản phẩm
            </header>
            <div class="panel-body">


                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="tensp">Tên thương hiệu</label>
                            <input type="text" name="brand_product_name" class="form-control" id="tensp" placeholder="Tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="mota">Mô tả thương hiệu</label>
                            <textarea style="resize: none" rows ="6" class="form-control" name="brand_product_description" id="mota" placeholder="Mô tả thương hiệu"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="hienthi">Hiển thị</label>
                            <select id="hienthi" name="brand_product_status" class="form-control input-sm m-bot15">
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>
                            </select>
                        </div>


                        <button type="submit" name="add_category_product" class="btn btn-info">Thêm thương hiệu</button>
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
                    </form>
                </div>

            </div>
        </section>

    </div>
@endsection
