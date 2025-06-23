@extends('admin_layout');
@section('admin_content');
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sản phẩm
            </header>
            <div class="panel-body">


                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="tensp">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" id="tensp" placeholder="Tên sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="mota">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows ="6" class="form-control" name="product_description" id="mota" placeholder="Mô tả sản phẩm"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tomtat">Nội dung sản phẩm</label>
                            <textarea style="resize: none" rows ="6" class="form-control" name="product_content" id="tomtat" placeholder="Nội dung sản phẩm"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="hinhsp">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="hinhsp">
                        </div>

                        <div class="form-group">
                            <label for="giasp">Giá sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" id="giasp" placeholder="Giá sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="hienthi">Danh mục sản phẩm</label>
                            <select id="hienthi" name="product_cate" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key => $cate)
                                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hienthi">Thương hiệu</label>
                            <select id="hienthi" name="product_brand" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hienthi">Hiển thị</label>
                            <select id="hienthi" name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>
                            </select>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
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
