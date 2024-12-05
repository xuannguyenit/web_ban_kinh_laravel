<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
session_start();

class CategoryProductController extends Controller
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
        // lấy ra toàn bộ danh mục
        $this->AuthLogin();
    	// $all_category_product = DB::table('tbl_category_product')->get();
        $all_category_product = Category::orderBy('category_id','DESC')->get();
    	$manager_category_product  = view('admin.all_category_product')->with('all_category_product',$all_category_product);
    	return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }
    public function add(){
        // hiển thị form thêm danh mục
        $this->AuthLogin();
    	return view('admin.add_category_product');
    }

    public function create(Request $request){
        // thực hiện thêm danh mục sản phẩm
        $this->AuthLogin();
    	// $data = array();
    	// $data['category_name'] = $request->category_product_name;
        // $data['slug_category_product'] = $request->slug_category_product;
    	// $data['category_desc'] = $request->category_product_desc;
    	// $data['category_status'] = $request->category_product_status;

    	// DB::table('tbl_category_product')->insert($data);

        $data = $request ->all();
        $category = new Category();
        $category->category_name = $data['category_product_name'];
        $category->slug_category_product = Str::slug($request->input('category_product_name'));
        // $category->slug_category_product = $data['slug_category_product'];
        $category->category_desc = $data['category_product_desc'];
        $category->category_status = $data['category_product_status'];
        $category->save();
    	Session::put('message','Thêm danh mục sản phẩm thành công');
    	return redirect()->route('admin.category.add');
    }
    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        //DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Category::where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return redirect()->route('admin.category');

    }
    public function active_category_product($category_product_id){
        $this->AuthLogin();
        // DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Category::where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Kích hoạt danh mục sản phẩm thành công');
        return redirect()->route('admin.category');
    }
    public function edit($category_product_id){
        // lấy ra sản danh mục và hiển thị form danh mục
        $this->AuthLogin();
        $edit_category_product = Category::where('category_id',$category_product_id)->get();
        $manager_category_product  = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }
    public function update(Request $request,$category_product_id){
        // thực hiện sửa danh mục
        $this->AuthLogin();
        // $data = array();
        // $data['category_name'] = $request->category_product_name;
        // $data['slug_category_product'] = $request->slug_category_product;
        // $data['category_desc'] = $request->category_product_desc;
        // DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        $data = $request ->all();
        $category = Category::find($category_product_id);
        $category->category_name = $data['category_product_name'];
        // $category->slug_category_product = $data['slug_category_product'];
        $category->slug_category_product = Str::slug($request->input('category_product_name'));
        $category->category_desc = $data['category_product_desc'];
        $category->save();
        Session::put('message','Cập nhật danh mục sản phẩm thành công');
        return redirect()->route('admin.category');
    }
    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        Category::where('category_id',$category_product_id)->delete();
        Session::put('message','Xóa danh mục sản phẩm thành công');
        return redirect()->route('admin.category');
    }
    // hiển thị trên giao diện theo từng danh mục
    //End Function Admin Page
    public function show_category_home($slug_category_product){
        $cate_product = Category::where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = Brand::where('brand_status','0')->orderby('brand_id','desc')->get(); 

        $category_by_slug = Category::where('slug_category_product',$slug_category_product)->get();
        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        $min_price_range =$min_price - 50000;
        $max_price_range =$max_price + 100000;
        foreach($category_by_slug as $key => $cate){
            $category_id = $cate->category_id;
        }
        if(isset($_GET['sort_by'])){
                $sort_by = $_GET['sort_by'];
                if($sort_by == 'giam_dan'){
                    $category_by_id = Product::with('category')
                    ->where('category_id',$category_id)
                    ->orderBy('product_price','DESC')
                    ->paginate(6)->appends(request()->query());
                }elseif($sort_by == 'tang_dan'){
                    $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_price','ASC')->paginate(6)->appends(request()->query());
                }elseif($sort_by == 'kytu_za'){
                    $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','DESC')->paginate(6)->appends(request()->query());
                }elseif($sort_by == 'kytu_az'){
                    $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','ASC')->paginate(6)->appends(request()->query());
                };
        }
        elseif(isset($_GET['start_price']) && $_GET['end_price']){
                $min_price = $_GET['start_price'];
                $max_price = $_GET['end_price'];
                //CLICK LỌC
                $category_by_id = Product::with('category')
                ->whereBetween('product_price',[$min_price,$max_price])->where('category_id',$category_id)
                ->orderBy('product_price','ASC')->paginate(6);
        }
        else{
            $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_id','DESC')->paginate(6);
           
        };
        
        // $category_by_id = DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_category_product.slug_category_product',$slug_category_product)->get();
        
        $category_name = Category::where('tbl_category_product.slug_category_product',$slug_category_product)->limit(1)->get();

        return view('pages.category.show_category')
            ->with('category',$cate_product)
            ->with('brand',$brand_product)
            ->with('category_by_id',$category_by_id)
            ->with('category_name',$category_name)
            ->with('min_price',$min_price)
            ->with('max_price',$max_price)
            ->with('max_price_range',$max_price_range)
            ->with('min_price_range',$min_price_range);
            
    }

}
