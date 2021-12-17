@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <h2>{{ __('editcategory') }}</h2>
        <div class="block copyblock">
            <span class="success">
                @if (Session::get('message')!=null)
                {{ Session::get('message') }}
                @endif
            </span>
            <x-auth-validation-errors :errors="$errors" />
            <form action="{{ route('editcategory') }}" method="POST">
                @csrf
                <table class="form">
                    <input name="id" type="hidden" value="{{ $cat->id }}" />
                    <tr>
                        <td>
                            <input value="{{ $cat->name }}" name="name" type="text" placeholder="{{ __('addcategory') }}" class="medium" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input value="{{ $cat->slug }}" name="slug" type="text" placeholder="{{ __('addslug') }}" class="medium" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <select required id="select" name="parent">
                                        <option disabled>{{ __('selectparentcategory') }}</option>
                                        <option selected value="">NULL</option>
                                        @foreach ($category as $item)
                                            @if ($cat->parent_id == $item->id)
                                                <option selected value="{{ $item->id }}">{{ $item->name }}</option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                        
                                </select>
                        </td>
                </tr>
                    <tr>
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
