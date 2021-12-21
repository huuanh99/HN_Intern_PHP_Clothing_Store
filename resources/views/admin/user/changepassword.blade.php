@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <h2>{{ __('changeUserPassword') }}</h2>
        <div class="block">
            <x-auth-validation-errors :errors="$errors" />
            <span class="success">
                @if (Session::get('message')!=null)
                {{ Session::get('message') }}
                @endif
            </span>
            <form action="{{ route('changePasswordUser') }}" method="POST">
                @csrf
                <table class="form">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <tr>
                        <td>
                            <label>{{ __('newPassword') }}</label>
                        </td>
                        <td>
                            <input required type="password" name="password" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('confirmpass') }}</label>
                        </td>
                        <td>
                            <input required type="password" name="password_confirmation" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input type="submit" name="submit" Value="{{ __('update') }}" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection
