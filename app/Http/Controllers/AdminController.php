<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
    	return view('admin_login');
    }
    public function show_dashboard(){
        $this->AuthLogin();
    	return view('admin.dashboard');
    }
    public function dashboard(Request $request){
    	$admin_email = $request->admin_email;
    	$admin_password = md5($request->admin_password);

    	$result = Admin::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    	if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return  redirect()->route('admin.dashboard');
        }else{
            Session::put('message','Mật khẩu hoặc tài khoản bị sai.Làm ơn nhập lại');
            return redirect()->route('admin.login');
        }

    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return redirect()->route('admin.login');
    }
}
