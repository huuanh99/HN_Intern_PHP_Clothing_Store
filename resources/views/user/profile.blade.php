@extends('layout')
@section('content')
<div class="main">
  <div class="content">
    <div class="section group">
      <div class="content_top">
        <div class="heading">
          <x-auth-validation-errors :errors="$errors" />
        </div>
        <div class="clear"></div>
      </div>
      <form action="{{ route('updatecustomer') }}" method="post" enctype="multipart/form-data">
      @csrf
      <table class="tblone">
        <tr>
          <td>{{ __('name') }}</td>
          <td>:</td>
          <td>
            <input required type="text" name="name" value="{{ Auth::user()->name }}">
          </td>
        </tr>
        <tr>
          <td>{{ __('email') }}</td>
          <td>:</td>
          <td><input required type="email" name="email" value="{{ Auth::user()->email}}"></td>
        </tr>
        <tr>
          <td>{{ __('address') }}</td>
          <td>:</td>
          <td><input required type="text" name="address" value="{{ Auth::user()->address }}"></td>
        </tr>
        <tr>
          <td>{{ __('phone') }}</td>
          <td>:</td>
          <td><input required type="text" name="phone" value="{{ Auth::user()->phone }}"></td>
        </tr>
        <tr>
          <td>{{ __('image') }}</td>
          <td>:</td>
          <td><input type="file" name="image"></td>
          <img width="300" src="{{ asset('uploads') }}/{{ Auth::user()->image }}" alt=""><br/>
        </tr>
        <tr>
        <td colspan="3"><input type="submit" name="update" value="{{ __('update') }}"> </td>
        </tr>
        <tr>
        </tr>
      </table>
      </form>
     
    </div>
  </div>
</div>
@endsection


