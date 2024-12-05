@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới nhất</h2>
    @foreach($all_product as $key => $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            {{-- click hiển thị thông tin chi tiết --}}
            
            <div class="single-products">
                    <div class="productinfo text-center">
                        <form action="{{URL::to('/save-cart')}}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="productid_hidden" class="product_id_{{$product->product_id}}" value="{{$product->product_id}}">
                            <input type="hidden" class="product_name_{{$product->product_id}}" value="{{$product->product_name}}">
                            <input type="hidden" class="product_image_{{$product->product_id}}" value="{{$product->product_image}}">
                            <input type="hidden" class="product_price_{{$product->product_id}}" value="{{$product->product_price}}">
                            <input type="hidden" name="qty" class="product_qty_{{$product->product_id}}" value="1"> 
                            
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">
                                <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                <h2>{{$product->product_name}}</h2>
                                <h5>{{number_format($product->product_price,0,',','.').' '.'VNĐ'}}</h5>
                            </a>

                            <button type="submit"  class="btn btn-default add-to-cart" name="add-to-cart" data-id_product="{{$product->product_id}}">
                                <i class="fa fa-shopping-cart"></i>
                                Thêm giỏ hàng
                            </button>
                        </form>
                    </div>
                    
            </div>
        
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích home</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div><!--features_items-->
        <!--/recommended_items-->
@endsection