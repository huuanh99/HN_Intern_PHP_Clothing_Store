@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>{{ __('id') }}</th>
                        <th>{{ __('name') }}</th>
                        <th>{{ __('image') }}</th>
                        <th>{{ __('price') }}</th>
                        <th>{{ __('quantity') }}</th>
                        <th>{{ __('totalprice') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderdetails as $key => $item)
                    <tr class="odd gradeX">
                        <td>{{ ++$key }}</td>
                        <td>{{ textShorten($item->product->name, config('const.nameshorten')) }}</td>
                        <td>
                            <a href="{{ route('details', ['id' => $item->product->id]) }}">
                                <img width="80" height="80" src="{{ asset('uploads') }}/{{ $item->product->productImages[0]->path }}" alt="" />
                            </a>
                        </td>
                        <td>{{ vndFormat($item->product->price) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ vndFormat($item->product->price * $item->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
