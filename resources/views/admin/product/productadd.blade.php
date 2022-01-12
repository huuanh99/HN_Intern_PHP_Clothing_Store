@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <h2>{{ __('addproduct') }}</h2>
        <span class="success">
            @if (Session::get('message')!=null)
            {{ Session::get('message') }}
            @endif
        </span>
        <div class="block">
            <x-auth-validation-errors :errors="$errors" />
            <form action="{{ route('addproduct') }}" method="post" enctype="multipart/form-data">
                @csrf
                <table class="form">
                    <tr>
                        <td>
                            <label>{{ __('name') }}</label>
                        </td>
                        <td>
                            <input required name="name" type="text" placeholder="{{ __('name') }}" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('quantity') }}</label>
                        </td>
                        <td>
                            <input required name="quantity" type="number" placeholder="{{ __('quantity') }}" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('category') }}</label>
                        </td>
                        <td>
                            <select required id="select" name="category">
                                @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>{{ __('description') }}</label>
                        </td>
                        <td>
                            <textarea required name="description" class="tynymce"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('price') }}</label>
                        </td>
                        <td>
                            <input required name="price" type="number" placeholder="{{ __('price') }}" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('image') }}</label>
                        </td>
                        <td>
                            <input required type="file" name="upload[]" multiple/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
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
