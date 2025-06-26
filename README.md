<h1 align="center"><strong>Project: Website bán máy tính</strong>  </h1>

<h2>Thông tin cá nhân</h2>

👤 **Họ tên:** Nguyễn Duy Tiến

🎓 **Mã sinh viên:** 23010468


## 📝 Mô tả dự án

Website bán hàng, cho phép người quản lý thêm, xóa, phân loại sản phẩm.
Dự án sử dụng Laravel, MySQL.


## 🧰 Công nghệ sử dụng

- PHP (Laravel Framework)
- AJAX (Asynchronous JavaScript and XML)
- Laravel Breeze
- MySQL (Aiven Cloud)
- Blade Template
- Tailwind CSS (do Breeze tích hợp sẵn)

## 🚀 Cài đặt & Chạy thử
```bash
git: https://github.com/duytien05/Web-b-n-m-y-t-nh
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

# Sơ đồ khối

![csdlweb](https://github.com/user-attachments/assets/3324842c-a8eb-49a6-b74b-636500c68378)


## ⚙Sơ đồ chức năng

## 🧠Sơ đồ thuật toán

<Strong>AdminController: <Strong>![admincontroller](https://github.com/user-attachments/assets/bbd1fa7c-6037-4fa6-b404-8e95c7120f31)


<Strong>CRUD Category :<Strong> ![CRUD Category](https://github.com/user-attachments/assets/7cbd2a3c-8dbc-42db-9c54-5e99c9cf46fe)



<Strong>Brandproducts :<Strong> ![BrandProduct](https://github.com/user-attachments/assets/89e5e5af-669e-4438-8720-5cc0301f9689)


<Strong>CardController : <Strong>  ![CardController](https://github.com/user-attachments/assets/452372e3-b372-4e88-b8b7-16be4231b758)


# Một số Code chính minh họa
## Controller

- ProductController
```bash
class ProductController extends Controller
{
    public function authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_product(){
        $this->authlogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        return view('admin.add_product')->with('cate_product',$cate_product)->with('brand_product',$brand_product);
    }
    public function all_product(){
        $this->authlogin();
        $all_product = DB::table('tbl_product')->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->get();
        $manager_product = view('admin.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product',$manager_product);

    }
    public function save_product(Request $request){
        $this->authlogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_description'] = $request->product_description;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $request->product_price;

        $get_image = $request->file('product_image');
        $data['product_status'] = $request->product_status;

        if ($data['product_name'] === null || $data['product_name'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-product');
        }
        else if ($data['category_id'] === null || $data['category_id'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-product');
        }
        else if ($data['brand_id'] === null || $data['brand_id'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-product');
        }
        else if ($data['product_description'] === null || $data['product_description'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-product');
        }
        else if ($data['product_content'] === null || $data['product_content'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-product');
        }
        else if ($data['product_price'] === null || $data['product_price'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-product');
        }
        else{

            if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move('upload/product',$new_image);
                $data['product_image']=$new_image;
                DB::table('tbl_product')->insert($data);
                Session::put('message','Thêm sản phẩm thành công');
                return Redirect::to('all-product');
            }

            $data['product_image']='';

            DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công');
            return Redirect::to('all-product');
        }

    }
    public function unactive_product($product_id){
        $this->authlogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','Không kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function active_product($product_id){
        $this->authlogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message','Kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function edit_product($product_id){
        $this->authlogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product)->with('brand_product',$brand_product);
        return view('admin_layout')->with('admin.edit_product',$manager_product);
    }
    public function update_product(Request $request, $product_id){
        $this->authlogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_description'] = $request->product_description;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/product',$new_image);
            $data['product_image']=$new_image;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }


        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');

    }
    public function delete_product($product_id){
        $this->authlogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    //end admin page


    public function detail_product($product_id){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        $detail_product = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->where('tbl_product.product_id',$product_id)->get();

        foreach($detail_product as $key => $value){
            $category_id = $value->category_id;
        }

        $related_product = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();

        return view('pages.sanpham.show_detail')->with('category',$cate_product)->with('brand',$brand_product)
            ->with('product_detail',$detail_product)->with('relate',$related_product);
    }

    public function delete_order($order_id){
        $this->authlogin();
        DB::table('tbl_order')->where('order_id',$order_id)->delete();
        Session::put('message','Xóa đơn hàng thành công');
        return Redirect::to('manage-order');
    }
}
```
- AdminController :
```bash
class AdminController extends Controller
{
    public function authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        return view('admin_login');
    }
    public function show_dashboard(){
        $this->authlogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to('/dashboard');
        }
        else{
            Session::put('message','Sai email hoặc mật khẩu');
            return Redirect::to('/admin');
        }
    }
    public function logout(){
        $this->authlogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
}
```

##Product :
- BrandProduct :
```bash
class BrandProduct extends Controller
{
    public function authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_brand_product(){
        $this->authlogin();
        return view('admin.add_brand_product');
    }
    public function all_brand_product(){
        $this->authlogin();
        $all_brand_product = DB::table('tbl_brand')->get();
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product', $all_brand_product);
        return view('admin_layout')->with('admin.all_brand_product',$manager_brand_product);

    }
    public function save_brand_product(Request $request){
        $this->authlogin();
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_description'] = $request->brand_product_description;
        $data['brand_status'] = $request->brand_product_status;
        if ($data['brand_name'] === null || $data['brand_name'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-brand-product');
        }
        else if ($data['brand_description'] === null || $data['brand_description'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-brand-product');
        }
        else{
            DB::table('tbl_brand')->insert($data);
            Session::put('message','Thêm thương hiệu sản phẩm thành công');
            return Redirect::to('add-brand-product');
        }

    }
    public function unactive_brand_product($brand_product_id){
        $this->authlogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Không kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($brand_product_id){
        $this->authlogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','Kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    public function edit_brand_product($brand_product_id){
        $this->authlogin();
        $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product', $edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request, $brand_product_id){
        $this->authlogin();
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_description'] = $request->brand_product_description;
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data);
        Session::put('message','Cập nhật thương hiệu thành công');
        return Redirect::to('all-brand-product');

    }
    public function delete_brand_product($brand_product_id){
        $this->authlogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->delete();
        Session::put('message','Xóa thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }

    //end function admin page


    public function show_brand_home($brand_id){

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id','=',$brand_id)->get();
        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_id',$brand_id)->limit(1)->get();

        return view('pages.brand.show_brand')->with('category',$cate_product)->with('brand',$brand_product)->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name);
    }
}

```
- CategoryProduct :
```bash
class CategoryProduct extends Controller
{
    public function authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_category_product(){
        $this->authlogin();
        return view('admin.add_category_product');
    }
    public function all_category_product(){
        $this->authlogin();
        $all_category_product = DB::table('tbl_category_product')->get();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('admin.all_category_product',$manager_category_product);

    }
    public function save_category_product(Request $request){
        $this->authlogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_description'] = $request->category_product_description;
        $data['category_status'] = $request->category_product_status;
        if ($data['category_name'] === null || $data['category_name'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-category-product');
        }
        else if ($data['category_description'] === null || $data['category_description'] === '') {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('add-category-product');
        }
        else {

            DB::table('tbl_category_product')->insert($data);
            Session::put('message', 'Thêm danh mục sản phẩm thành công');
            return Redirect::to('add-category-product');
        }
    }
    public function unactive_category_product($category_product_id){
        $this->authlogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id){
        $this->authlogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id){
        $this->authlogin();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product',$manager_category_product);
    }
    public function update_category_product(Request $request, $category_product_id){
        $this->authlogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_description'] = $request->category_product_description;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');

    }
    public function delete_category_product($category_product_id){
        $this->authlogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    //end function admin page


    public function show_category_home($category_id){

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        $category_by_id = DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_product.category_id','=',$category_id)->get();

        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_id)->limit(1)->get();

        return view('pages.category.show_category')->with('category',$cate_product)->with('brand',$brand_product)->with('category_by_id',$category_by_id)->with('category_name',$category_name);
    }

}

```


# Một số hình ảnh chức năng chính
## Xác thực người dùng
Trang đăng nhập

<img width="310" alt="Ảnh chụp Màn hình 2025-06-26 lúc 08 29 06" src="https://github.com/user-attachments/assets/6555d98e-fb01-4db4-b1ea-6d99711bb5c7" />
Trang đăng ký

<img width="311" alt="Ảnh chụp Màn hình 2025-06-26 lúc 08 30 30" src="https://github.com/user-attachments/assets/741f2727-f2a2-40ef-9a15-3574975c7f51" />
## Trang chính

<img width="1680" alt="Ảnh chụp Màn hình 2025-06-26 lúc 08 31 55" src="https://github.com/user-attachments/assets/c7ffbd98-8d69-493a-b548-ffbf4b0634f2" />

## CRUD Products

<img width="1680" alt="Ảnh chụp Màn hình 2025-06-26 lúc 09 40 33" src="https://github.com/user-attachments/assets/6bf5c6c2-11e0-46c3-bdba-c1c7ab56fb09" />

Thêm sản phẩm

<img width="1680" alt="Ảnh chụp Màn hình 2025-06-26 lúc 09 37 52" src="https://github.com/user-attachments/assets/816b7c93-7d2d-48a9-a307-b30fda3a7f60" />
Xem , sửa và xóa :

<img width="1680" alt="Ảnh chụp Màn hình 2025-06-26 lúc 09 42 49" src="https://github.com/user-attachments/assets/1fbe4f0f-d9c4-457a-9b95-1e538a43e0cc" />

## CRUD Categories
![image](https://github.com/user-attachments/assets/a9da1ca1-2c80-49f9-953e-e7f5103d0153)
Thêm mới:

<img width="1680" alt="Ảnh chụp Màn hình 2025-06-26 lúc 09 37 52" src="https://github.com/user-attachments/assets/1911df86-b8fa-4d93-842a-25e0713489a9" />

Sửa và xóa:

<img width="145" alt="Ảnh chụp Màn hình 2025-06-26 lúc 09 48 55" src="https://github.com/user-attachments/assets/df8af5b1-991b-49f0-9d98-57de9c5c4eda" />

Xem sản phẩm:

<img width="145" alt="Ảnh chụp Màn hình 2025-06-26 lúc 09 48 55" src="https://github.com/user-attachments/assets/41de62e6-d572-4867-b412-78b97769fb61" />



## CRUD Brands

<img width="1676" alt="Ảnh chụp Màn hình 2025-06-26 lúc 09 50 20" src="https://github.com/user-attachments/assets/f53db944-fce5-4700-8dc4-dd8b97088c80" />

Thêm mới:

<img width="1680" alt="Ảnh chụp Màn hình 2025-06-26 lúc 09 51 39" src="https://github.com/user-attachments/assets/cd4fb4c1-3349-4518-9a2f-91eceaaa3c73" />

sửa và xóa:

![image](https://github.com/user-attachments/assets/e721d089-e915-4dfa-a0c1-849fffc03f3f)
