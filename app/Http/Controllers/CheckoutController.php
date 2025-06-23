<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

session_start();

class CheckoutController extends Controller
{
    public function login_checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['email_verified'] = 0;
        $data['email_verification_token'] = Str::random(32);

        $et = $request->customer_email;
        $em = DB::table('tbl_customers')->where('customer_email',$et)->first();

        if (empty($data['customer_name']) || empty($data['customer_phone']) || empty($data['customer_email']) || empty($data['customer_password'])) {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('login-checkout');
        }

        if ($em) {
            Session::put('error', 'Email đã tồn tại');
            session_destroy();
            return Redirect::to('/login-checkout');
        }

        $customer_id = DB::table('tbl_customers')->insertGetId($data);

        // Gửi email xác minh
        $verificationLink = url('/verify-email?token=' . $data['email_verification_token']);
        $emailData = [
            'name' => $request->customer_name,
            'link' => $verificationLink
        ];

        Mail::send('emails.verify', $emailData, function($message) use ($data) {
            $message->to($data['customer_email']);
            $message->subject('Xác minh tài khoản của bạn');
        });

        Session::put('success', 'Tạo tài khoản thành công. Vui lòng kiểm tra email để xác minh.');
        return Redirect::to('/login-checkout');
    }

    public function verifyEmail(Request $request){
        $token = $request->query('token');

        $user = DB::table('tbl_customers')->where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect('/login-checkout')->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
        }

        DB::table('tbl_customers')->where('customer_id', $user->customer_id)->update([
            'email_verified' => 1,
            'email_verification_token' => null
        ]);

        Session::put('success', 'Xác minh email thành công. Bạn có thể đăng nhập.');
        return redirect('/login-checkout');
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);

        if(empty($email) || empty($password)){
            Session::put('error', 'Vui lòng nhập email và mật khẩu');
            return Redirect::to('login-checkout');
        }

        $user = DB::table('tbl_customers')
            ->where('customer_email', $email)
            ->where('customer_password', $password)
            ->first();

        if(!$user){
            Session::put('error', 'Sai email hoặc mật khẩu');
            return Redirect::to('login-checkout');
        }

        if($user->email_verified == 0){
            Session::put('error', 'Vui lòng xác minh email trước khi đăng nhập');
            return Redirect::to('login-checkout');
        }

        Session::put('customer_id',$user->customer_id);
        Session::put('customer_name',$user->customer_name);
        return Redirect::to('/show-cart');
    }

    public function checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;

        if (empty($data['shipping_name']) || empty($data['shipping_phone']) || empty($data['shipping_email']) || empty($data['shipping_address']) || empty($data['shipping_note'])) {
            Session::put('error', 'Vui lòng nhập đầy đủ thông tin');
            return Redirect::to('checkout');
        }

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/payment');
    }

    public function payment(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }

    public function order(Request $request){
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = "Đang chờ xử lý";
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = "Đang chờ xử lý";
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        $content = Cart::content();
        foreach($content as $v_content){
            $order_detail_data['order_id'] = $order_id;
            $order_detail_data['product_id'] = $v_content->id;
            $order_detail_data['product_name'] = $v_content->name;
            $order_detail_data['product_price'] = $v_content->price;
            $order_detail_data['product_quantity'] = $v_content->qty;
            DB::table('tbl_order_detail')->insert($order_detail_data);
        }

        if($data['payment_method'] == 1){
            echo 'Thanh toán thẻ ATM';
        }else{
            Cart::destroy();
            $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();
            return view('pages.checkout.cash')->with('category',$cate_product)->with('brand',$brand_product);
        }

        return Redirect::to('/payment');
    }

    public function authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        } else{
            return Redirect::to('admin')->send();
        }
    }

    public function manage_order(){
        $this->authlogin();
        $all_order = DB::table('tbl_order')
            ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
            ->select('tbl_order.*','tbl_customers.customer_name')
            ->orderby('tbl_order.order_id','desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }

    public function view_order($orderId){
        $this->authlogin();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
            ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
            ->join('tbl_order_detail','tbl_order.order_id','=','tbl_order_detail.order_id')
            ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_detail.*')
            ->first();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order',$manager_order_by_id);
    }
}
