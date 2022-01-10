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
                    <form class="form-horizontal poststars" id="addStar" action="{{ route('rating') }}" method="post">
                        @csrf
                        <input type="hidden" name="productId" value="{{ $product->id }}">
                        <div class="form-group required">
                            <div class="col-sm-12">
                                <input class="star star-5" value="5" id="star-5" type="radio" name="star"/>
                                <label class="star star-5" for="star-5"></label>
                                <input class="star star-4" value="4" id="star-4" type="radio" name="star"/>
                                <label class="star star-4" for="star-4"></label>
                                <input class="star star-3" value="3" id="star-3" type="radio" name="star"/>
                                <label class="star star-3" for="star-3"></label>
                                <input class="star star-2" value="2" id="star-2" type="radio" name="star"/>
                                <label class="star star-2" for="star-2"></label>
                                <input class="star star-1" value="1" id="star-1" type="radio" name="star"/>
                                <label class="star star-1" for="star-1"></label>
                            </div>
                        </div>
                    </form>
                    <div>
                        <span class="numberstar">{{ $fivestar }}</span>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <br><br><br>
                    <div>
                        <span class="numberstar">{{ $fourstar }}</span>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <br>
                    <div>
                        <span class="numberstar">{{ $threestar }}</span>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <br>
                    <div>
                        <span class="numberstar">{{ $twostar }}</span>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <br>
                    <div>
                        <span class="numberstar">{{ $onestar }}</span>
                        <i class="fa fa-star"></i>
                    </div>
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
                                </ul>
                            </div>
                        </div>            
                    @endforeach        
                </section>
            </div>    
        </div>
    </div>
</div>
@endsection
