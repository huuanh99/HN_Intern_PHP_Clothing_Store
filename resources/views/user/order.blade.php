@extends('layout')
@section('content')
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<table class="tblone">
					<tr>
						<th width="30%">{{ __('totalprice') }}</th>
						<th width="40%">{{ __('timeorder') }}</th>
						<th width="30%">{{ __('detail') }}</th>
					</tr>
					@foreach ($orders as $item)
					<tr>
						<td>{{ vndFormat($item->total) }}</td>
						<td>{{ formatDate($item->created_at) }}</td>
						<td><a href="{{ route('orderdetail',['id'=>$item->id]) }}">{{ __('detail') }}</a></td>
					</tr>
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