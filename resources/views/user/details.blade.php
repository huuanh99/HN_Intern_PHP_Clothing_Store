@extends('layout')
@section('content')
<div class="main">
	<span class="success">
		@if (Session::get('message')!=null)
		{{ Session::get('message') }}
		@endif
	</span>
	<div class="content">
		<div class="section group">
			<div class="cont-desc span_1_of_2">
				<div class="grid images_3_of_2">
					<section class="slider">
						<div class="flexslider">
						  <ul class="slides">
							@foreach ($product->productImages as $item)
							<li><img src="{{ asset('uploads') }}/{{ $item->path }}" alt="" /></li>
							@endforeach
			  
						  </ul>
						</div>
					  </section>
				</div>
				<div class="desc span_3_of_2">
					<h2> {{ $product->name }} </h2>
					<div class="price">
						<p>{{ __('price') }}: <span>{{ vndFormat($product->price) }}</span></p>
						<p>{{ __('categories') }}: <span>{{ $product->category->name }}</span></p>
						<p>{{ __('quantity') }}:<span>{{ $product->quantity }}</span></p>
					</div>
					<div class="add-cart">
						<form action="{{ route('addtocart')}}" method="post">
							@csrf
							<input type="hidden" name="id" value="{{ $product->id }}">
							<input type="number" class="buyfield" name="quantity" value="1" min="1" max="{{ $product->quantity }}"/>
							<input type="submit"  class="buysubmit" name="submit" value="{{ __('addtocart') }}">
						</form>
					</div>
				</div>
				<div class="product-desc">
					<h2>{{ __('detail') }}</h2>
					<p>{{ $product->description }}</p>
				</div>
				<section class="content-item" id="comments">
					<div>
						<div>
							<div>
								<div class="media">
								
									<div class="media-body">
										<form action="{{ route('comment') }}" method="POST">
											@csrf
											<textarea name="content" class="form-control" id="message" placeholder=""
												required=""></textarea>
											<input type="hidden" name="product_id" value="{{ $product->id }}">
											<button type="submit" class="btn btn-normal pull-right">{{ __('sendcomment') }}</button>
										</form>
									</div>
								</div>


							<h3>{{ $comment->count() }} Comments</h3>
							@foreach ($comment as $item)
								<div class="media">
									<a class="pull-left" href="#"><img width="100px" height="100px" class="media-object"
											src="{{ asset('uploads') }}/{{ $item->user->image }}" alt=""></a>
									<div class="media-body">
										<h4 class="media-heading">{{ $item->user->name }}</h4>
										<p>{{ $item->content }}</p>
										<ul class="list-unstyled list-inline media-detail pull-left">
											<li><i class="fa fa-calendar"></i>{{ formatDate($item->created_at) }}</li>
											<li><i class="fa fa-thumbs-up"></i>1</li>
										</ul>
										<ul class="list-unstyled list-inline media-detail pull-right">
											<li class="like"><a href="">Like</a></li>
											<li class="like"><a href="">Reply</a></li>
										</ul>
									</div>
								</div>
							
							@endforeach
						</div>

						</div>
					</div>
				</section>

			</div>
			
		</div>
	</div>

	@endsection