@extends('admin_layout');
@section('admin_content');
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật danh mục sản phẩm
            </header>
            <div class="panel-body">
                @foreach($edit_category_product as $key=> $edit_value)

                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="tensp">Tên danh mục</label>
                            <input type="text" value="{{$edit_value->category_name}}" name="category_product_name" class="form-control" id="tensp" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <label for="mota">Mô tả danh mục</label>
                            <textarea style="resize: none" rows ="6" class="form-control" name="category_product_description" id="mota">{{$edit_value->category_description}}</textarea>
                        </div>


                        <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật danh mục</button>
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
