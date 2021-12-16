@extends('layout')
@section('content')
<div class = "main">
    <div class = "content">
        <div class = "content_top">
            <div class = "heading"></div>
            <div class = "clear"></div>
        </div>
        <div class = "section group">
            @foreach ($product as $item)
                <div class = "grid_1_of_4 images_1_of_4">
                    <a href = "{{ route('details', ['id' => $item->id]) }}">
                        <img height = "250" src="{{ asset('uploads') }}/{{ $item->productImages[0]->path }}" alt = "" />
                    </a>
                    <h2>{{ textShorten($item->name, config('const.nameshorten')) }}</h2>
                    <p><span class = "price">{{ vndFormat($item->price) }}</span></p>
                    <div class = "button">
                        <span><a href = "{{ route('details', ['id' => $item->id]) }}" class = "details">{{ __('detail') }}</a></span>
                        <a href="{{ route('addtocarthomeview', ['id'=>$item->id]) }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
