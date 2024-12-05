@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
                        
    @foreach($category_name as $key => $name)
    
    <h2 class="title text-center">{{$name->category_name}}</h2>

    @endforeach
    <div class="row" style="padding: 17px ; margin-bottom: 20px" >    
        <div class="col-md-4">
            <label for="amount">Sắp xếp theo</label>
            <form>
                @csrf
                <select name="sort" id="sort" class="form-control">
                    <option value="{{Request::url()}}?sort_by=none">--lọc--</option>
                    <option value="{{Request::url()}}?sort_by=tang_dan">Theo Giá tăng dần</option>
                    <option value="{{Request::url()}}?sort_by=giam_dan">Theo Giá giảm dần</option>
                    <option value="{{Request::url()}}?sort_by=kytu_az">Theo tên từ A đến Z</option>
                    <option value="{{Request::url()}}?sort_by=kytu_za">Theo tên từ Z đến A</option>
                </select>
            </form>
        </div>
        <div class="col-md-4" style=" margin-left: 280px">
            <label for="amount">Lọc giá theo</label>
            <form>
                <div id="slider-range"></div>
                <input type="text" id="amount" readonly style="border:0; color:#7B68EE; font-weight:bold;">
                <input type="hidden" name="start_price" id="start_price">
                <input type="hidden" name="end_price" id="end_price">
                <br>
                <input type="submit" name="filter_price" value="Lọc" class="btn btn-sm btn-default">
            </form>
        </div>
    </div>
    @foreach($category_by_id as $key => $product)
    {{-- click hiển thị thông tin chi tiết --}}
    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">
    <div class="col-sm-4">
        <div class="product-image-wrapper">

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
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích1</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh1</a></li>
                </ul>
            </div>
        </div>
    </div>
    </a>
    @endforeach
</div><!--features_items-->
        <!--/recommended_items-->
@endsection