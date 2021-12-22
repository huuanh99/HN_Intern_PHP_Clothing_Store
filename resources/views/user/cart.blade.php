@extends('layout')
@section('content')
<div class="main">
	<span class="success">
        @if (Session::get('success') != null)
        {{ Session::get('success') }}
        @endif
    </span>
	<span class="fail">
        @if (Session::get('fail') != null)
        {{ Session::get('fail') }}
        @endif
    </span>
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">
                <table class="tblone">
                    <tr>
                        <th width="15%">{{ __('name') }}</th>
                        <th width="15%">{{ __('image') }}</th>
                        <th width="15%">{{ __('price') }}</th>
                        <th width="20%">{{ __('quantity') }}</th>
                        <th width="20%">{{ __('totalprice') }}</th>
                        <th width="15%">{{ __('action') }}</th>
                    </tr>
                    @if (Session::get('cart')!=null)
                        @foreach (Session::get('cart') as $index => $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td> 
                                    <a href="{{ route('details',['id'=>$item->id]) }}">
                                        <img height="80" src="{{ asset('uploads') }}/{{ $item->productImages[0]->path }}" alt="" />
                                    </a>
                                </td>
                                <td>{{ vndFormat($item->price) }}</td>
                                <td>
                                    <form action="{{ route('updatecart') }}" method="post">
                                        @csrf
                                        <input min="1" max="{{ $item->totalquantity }}" type="number" name="quantity" value="{{ $item->quantity }}" />
                                        <input type="hidden" name="id" value="{{ $item->id }}" />
                                        <input type="submit" name="submit" value="Update" />
                                    </form>
                                </td>
                                <td>{{ vndFormat($item->price*$item->quantity) }}</td>
                                <td><a href="{{ route('deletecart',['id'=>$item->id]) }}">Xóa</a></td>
                            </tr>
                        @endforeach
                    @endif
                </table>
                <table>
                    <tr>
                        <th>{{ __('totalprice') }} : </th>
                        <td>{{ vndFormat(Session::get('subtotal')) }}</td>
                    </tr>
                </table>
            </div>
            <div class="shopping">
                <div class="shopleft">
                    <a href="{{ route('index') }}"> <img src="{{ asset('uploads') }}/shop.png" alt="" /></a>
                </div>
                <div class="shopright">
                    <a href="{{ route('payment') }}"> <img src="{{ asset('uploads') }}/check.png" alt="" /></a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>    
@endsection
