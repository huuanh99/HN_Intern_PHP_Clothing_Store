@extends('layout')
@section('content')
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<h2>Chi tiết hóa đơn</h2>
				<table class="tblone">
					<tr>
						<th width="20%">{{ __('name') }}</th>
						<th width="20%">{{ __('image') }}</th>
						<th width="15%">{{ __('price') }}</th>
						<th width="25%">{{ __('quantity') }}</th>
						<th width="20%">{{ __('totalprice') }}</th>
					</tr>
					<?php $subtotal =0 ?>
					@foreach ($orderdetails as $item)
					<tr>
						<td>{{ $item->product->name }}</td>
						<td> <a href="{{ route('details',['id'=>$item->product->id]) }}">
								<img height="80" src="{{ asset('uploads/') }}/{{ $item->product->productImages[0]->path }}" alt="" />
							</a>
						</td>
						<td>{{ vndFormat($item->product->price) }}</td>
						<td>{{ $item->quantity }}</td>
						<td>{{ vndFormat($item->product->price*$item->quantity) }}</td>
					</tr>
					<?php $subtotal += $item->product->price*$item->quantity?>
					@endforeach
				</table>
			
	
			</div>
			<div class="shopping">
				<div class="shopleft">
					<a href="index.php"> <img src="images/shop.png" alt="" /></a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
@endsection