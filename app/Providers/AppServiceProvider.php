<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\ServiceProvider;
use App\Models\Product;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       view()->composer('*',function($view){
        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        $min_price_range =$min_price - 50000;
        $max_price_range =$max_price + 100000;
        $category = Category::where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand = Brand::where('brand_status','0')->orderby('brand_id','desc')->get();

        $view->with('min_price',$min_price)->with('max_price',$max_price)
        ->with('max_price_range',$max_price_range)->with('min_price_range',$min_price_range)
        ->with('category',$category)
        ->with('brand',$brand);
       });
    }
}
