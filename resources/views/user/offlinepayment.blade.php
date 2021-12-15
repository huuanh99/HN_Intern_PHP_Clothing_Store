@extends('layout')
@section('content')
<div class="main">
    <div class="content">
        <div class="section group">
            <form action="{{ route('insertOrder') }}" method="post">
                @csrf
                <table class="tblone">
                    <tr>
                        <td>{{ __('name') }}</td>
                        <td>:</td>
                        <td><input required type="text" name="name" id="" value="{{ Auth::user()->name }}"></td>
                    </tr>
                    <tr>
                        <td>{{ __('address') }}</td>
                        <td>:</td>
                        <td><input required type="text" name="address" id="" value="{{ Auth::user()->address }}"></td>
                    </tr>
                    <tr>
                        <td>{{ __('phone') }}</td>
                        <td>:</td>
                        <td><input required type="text" name="phone" id="" value="{{ Auth::user()->phone }}"></td>
                    </tr>
                    <tr>
                        <td>{{ __('email') }}</td>
                        <td>:</td>
                        <td><input required type="text" name="email" id="" value="{{ Auth::user()->email }}"></td>
                    </tr>
                    <tr>
                        <td>{{ __('totalprice') }}</td>
                        <td>:</td>
                        <td>{{ vndFormat(Session::get('subtotal')) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="order" value="{{ __('order') }}"> </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection
