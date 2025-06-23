@extends('admin_layout');
@section('admin_content');
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật sản phẩm
            </header>
            <div class="panel-body">


                <div class="position-center">
                    @foreach($edit_product as $key =>$pro)
                    <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="tensp">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" id="tensp" value="{{$pro->product_name}}">
                        </div>
                        <div class="form-group">
                            <label for="giasp">Giá sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" id="giasp" value="{{$pro->product_price}}">
                        </div>
                        <div class="form-group">
                            <label for="hinhsp">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="hinhsp">
                            <img src="{{URL::to('upload/product/'.$pro->product_image)}}" height="100" width="100">
                        </div>
                        <div class="form-group">
                            <label for="mota">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows ="6" class="form-control" name="product_description" id="mota">{{$pro->product_description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="tomtat">Nội dung sản phẩm</label>
                            <textarea style="resize: none" rows ="6" class="form-control" name="product_content" id="tomtat" >{{$pro->product_content}}</textarea>
                        </div>



                        <div class="form-group">
                            <label for="hienthi">Danh mục sản phẩm</label>
                            <select id="hienthi" name="product_cate" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key => $cate)
                                    @if($cate->category_id==$pro->category_id)
                                        <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @else
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hienthi">Thương hiệu</label>
                            <select id="hienthi" name="product_brand" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                    @if($cate->category_id==$pro->category_id)
                                        <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @else
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hienthi">Hiển thị</label>
                            <select id="hienthi" name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>

                        <button type="submit" name="update_product" class="btn btn-info">Cập nhật sản phẩm</button>
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
                    @endforeach
                </div>

            </div>
        </section>

    </div>
@endsection
