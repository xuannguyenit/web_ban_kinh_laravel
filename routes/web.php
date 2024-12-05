<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MailController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Frontend 
//Route::get('/','HomeController@index' );
Route::get('/',[HomeController::class,'index']);
Route::get('/trang-chu',[HomeController::class,'index']);
Route::post('/tim-kiem',[HomeController::class,'search']);

//Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{slug_category_product}',[CategoryProductController::class,'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_slug}',[BrandProductController::class,'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_slug}',[ProductController::class,'details_product']);

//Backend
Route::prefix('admin')->group(function () {
    Route::get('/',[AdminController::class,'index'])->name('admin.login');// hiển thị form login
    Route::get('/dashboard',[AdminController::class,'show_dashboard'])->name('admin.dashboard');//hiển thị dashboard
    Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout');// logout
    Route::post('/admin-dashboard',[AdminController::class,'dashboard'])->name('admin.admin-dashboard');
    // quản lý danh mục sản phẩm
    Route::prefix('category')->group(function () {
        Route::get('/',[CategoryProductController::class,'index'])->name('admin.category');// hiển thị category
        Route::get('/add',[CategoryProductController::class,'add'])->name('admin.category.add');// hiển thị form thêm danh mục
        Route::post('/create',[CategoryProductController::class,'create'])->name('admin.category.create');// thực hiện thêm danh mục


        Route::get('/edit/{category_product_id}',[CategoryProductController::class,'edit'])->name('admin.category.edit');// hiển thị form sửa danh mục
        Route::post('/update/{category_product_id}',[CategoryProductController::class,'update'])->name('admin.category.update');// thực hiện sửa danh mục

        Route::get('/delete-category-product/{category_product_id}',[CategoryProductController::class,'delete_category_product']);// xóa danh mục
        
        Route::get('/unactive-category-product/{category_product_id}',[CategoryProductController::class,'unactive_category_product']);// un check active
        Route::get('/active-category-product/{category_product_id}',[CategoryProductController::class,'active_category_product']);// check active
        
    });
    //Brand Product
    Route::prefix('brand')->group(function (){
        Route::get('/',[BrandProductController::class,'index'])->name('admin.brand.index');// index brand
        Route::get('/add',[BrandProductController::class,'add'])->name('admin.brand.add');// hiển thị from thêm brand product
        Route::post('/save',[BrandProductController::class,'save'])->name('admin.brand.save');// thêm brand 

        Route::get('/edit/{brand_product_id}',[BrandProductController::class,'edit'])->name('admin.brand.edit'); // hiển thị form sửa brand       
        Route::post('/update/{brand_product_id}',[BrandProductController::class,'update'])->name('admin.brand.update');// update lại brand

        Route::get('/delete/{brand_product_id}',[BrandProductController::class,'delete'])->name('admin.brand.delete');// xóa brand
        
        Route::get('/unactive/{brand_product_id}',[BrandProductController::class,'unactive'])->name('admin.brand.unactive');// 
        Route::get('/active/{brand_product_id}',[BrandProductController::class,'active'])->name('admin.brand.active');
    });
    //product
    Route::prefix('product')->group(function (){
        Route::get('/',[ProductController::class,'index'])->name('admin.product.index');
        Route::get('/add',[ProductController::class,'add'])->name('admin.product.add');
        Route::post('/save',[ProductController::class,'save'])->name('admin.product.save');

        Route::get('/edit/{product_id}',[ProductController::class,'edit'])->name('admin.product.edit');
        Route::post('/update/{product_id}',[ProductController::class,'update'])->name('admin.product.update');

        Route::get('/delete/{product_id}',[ProductController::class,'delete'])->name('admin.product.delete');
        
        Route::get('/unactive/{product_id}',[ProductController::class,'unactive'])->name('admin.product.unactive');
        Route::get('/active/{product_id}',[ProductController::class,'active'])->name('admin.product.active');
    });

});


//Cart
Route::post('/update-cart-quantity',[CartController::class,'update_cart_quantity']);
Route::post('/save-cart',[CartController::class,'save_cart']);
Route::get('/show-cart',[CartController::class,'show_cart']);
Route::get('/delete-to-cart/{rowId}',[CartController::class,'delete_to_cart']);

//Checkout

Route::get('/login-checkout',[CheckoutController::class,'login_checkout']);
Route::get('/logout-checkout',[CheckoutController::class,'logout_checkout']);
Route::post('/add-customer',[CheckoutController::class,'add_customer']);
//thanh toán tiền mặt
Route::post('/order-place',[CheckoutController::class,'order_place']);
//thanh toán momo
Route::post('/momo-payment',[CheckoutController::class,'momo_payment']);
Route::post('/login-customer',[CheckoutController::class,'login_customer']);
Route::get('/checkout',[CheckoutController::class,'checkout']);
Route::get('/payment',[CheckoutController::class,'payment']);
Route::post('/save-checkout-customer',[CheckoutController::class,'save_checkout_customer']);

//Order
Route::get('/manage-order',[CheckoutController::class,'manage_order']);
Route::get('/view-order/{orderId}',[CheckoutController::class,'view_order']);


//Send Mail
Route::get('/send-mail',[MailController::class,'send_mail']);
Route::get('/quen-mat-khau',[MailController::class,'quen_mat_khau']);
Route::get('/update-new-pass',[MailController::class,'update_new_pass']);
Route::post('/recover-pass',[MailController::class,'recover_pass']);
Route::post('/reset-new-pass',[MailController::class,'reset_new_pass']);       