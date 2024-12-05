@extends('layout')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán giỏ hàng</li>
				</ol>
			</div>

			
			<div class="review-payment">
				<h2>Xem lại giỏ hàng</h2>
			</div>
			<div class="table-responsive cart_info">
				<?php
				$content = Cart::content();
				
				?>
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Tên sp</td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tổng</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($content as $v_content)
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" width="90" alt="" /></a>
							</td>
							<td class="cart_description">
								<h5><a href="">{{$v_content->name}}</a></h5>
								<h6>Web ID: 1089772</h6>
							</td>
							<td class="cart_price">
								<h5>{{number_format($v_content->price,0,',','.').' '.'vnđ'}}</h5>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<form action="{{URL::to('/update-cart-quantity')}}" method="POST">
									{{ csrf_field() }}
									<input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" size="2"  >
									<input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
									<input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
									</form>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									
									<?php
									$subtotal = $v_content->price * $v_content->qty;
									echo number_format($subtotal,0,',','.').' '.'vnđ';
									?>
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<div class="total_area">
					<ul>
						<li>Tổng <span>{{Cart::priceTotal(0,',','.').' '.'vnđ'}}</span></li>
						<li>Thuế <span>{{Cart::tax(0,',','.').' '.'vnđ'}}</span></li>
						<li>Giảm giá <span>{{Cart::discount(0,',','.').' '.'vnđ'}}</span></li>
						<li>Phí vận chuyển <span>Free</span></li>
						<li>Thành tiền <span>{{Cart::total(0,',','.').' '.'vnđ'}}</span></li>
						<input type="hidden" value="{{Cart::total(0,',','.')}}" name="total" class="form-control">
					</ul>
				</div>
			</div>
			<div class="col-sm-12">
			<h4 style="margin:40px 0;font-size: 20px;">Chọn hình thức thanh toán</h4>
			<form method="POST" action="{{URL::to('/order-place')}}">
				{{ csrf_field() }}
				<div class="payment-options">
						{{-- <span>
							<label><input name="payment_option" value="1" type="checkbox"> Thanh toán Momo</label>
						</span> --}}
						<span>
							<label><input name="payment_option" value="2" type="checkbox"> Nhận tiền mặt</label>
						</span>
						<span>
							<label><input name="payment_option" value="3" type="checkbox"> Thanh toán thẻ ghi nợ</label>
						</span>
						<input type="submit" value="Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
				</div>
			</form>
			<form action="{{URL::to('/momo-payment')}}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="total_momo"  value="{{Cart::total(0,',','')}}">
				<input type="submit" value="Thanh toán momo" name="payUrl" class="btn btn-primary btn-sm">
			</form>
			</div>
		</div>
	</section> <!--/#cart_items-->

@endsection