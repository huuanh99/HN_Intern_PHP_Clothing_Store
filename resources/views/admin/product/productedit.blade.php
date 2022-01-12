@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <h2>{{ __('editproduct') }}</h2>
        <span class="success">
            @if (Session::get('message')!=null)
            {{ Session::get('message') }}
            @endif
        </span>
        <div class="block">
            <form action="{{ route('editproduct') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <table class="form">
                    <tr>
                        <td>
                            <label>{{ __('name') }}</label>
                        </td>
                        <td>
                            <input value="{{ $product->name }}" required name="name" type="text" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('quantity') }}</label>
                        </td>
                        <td>
                            <input value="{{ $product->quantity }}" required name="quantity" type="number" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('category') }}</label>
                        </td>
                        <td>
                            <select required id="select" name="category">
                                <option>{{ __('selectcategory') }}</option>
                                @foreach ($categories as $item)
                                <option
                                @if ($product->category_id == $item->id)
                                        selected
                                @endif
                                value="{{ $item->id }}">{{ $item->name }}</option>        
                                @endforeach
                                     
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>{{ __('description') }}</label>
                        </td>
                        <td>
                            <textarea required name="description" class="tynymce">{{ $product->description }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('price') }}</label>
                        </td>
                        <td>
                            <input value="{{ $product->price }}" required name="price" type="number" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>{{ __('image') }}</label>
                        </td>
                        <td>
                            <input type="file" name="upload[]" multiple />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
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
