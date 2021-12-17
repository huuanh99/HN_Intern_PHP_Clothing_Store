@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <h2>{{ __('addproduct') }}</h2>
        <div class="block copyblock">
            <span class="success">
                @if (Session::get('message')!=null)
                {{ Session::get('message') }}
                @endif
            </span>
            <x-auth-validation-errors :errors="$errors" />
            <form action="{{ route('addcategory') }}" method="POST">
                @csrf
                <table class="form">
                    <tr>
                        <td>
                            <input name="name" type="text" placeholder="{{ __('addcategory') }}" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="slug" type="text" placeholder="{{ __('addslug') }}" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select required id="select" name="parent">
                                <option disabled>{{ __('selectparentcategory') }}</option>
                                <option value="">NULL</option>
                                @foreach ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" Value="{{ __('save') }}" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection
