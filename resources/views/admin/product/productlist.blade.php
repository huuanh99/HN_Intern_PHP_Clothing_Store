@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <h2>{{ __('listproduct') }}</h2>
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th width="5%">{{ __('id') }}</th>
                        <th width="25%">{{ __('name') }}</th>
                        <th width="15%">{{ __('price') }}</th>
                        <th width="15%">{{ __('image') }}</th>
                        <th width="15%">{{ __('category') }}</th>
                        <th width="10%">{{ __('quantity') }}</th>
                        <th width="15%">{{ __('action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $item)
                    <tr class="odd gradeX">
                        <td>{{ ++$key }}</td>
                        <td>{{ textShorten($item->name, config('const.nameshorten')) }}</td>
                        <td>{{ vndFormat($item->price) }}</td>
                        <td>
                            <a href="{{ route('details',['id'=>$item->id]) }}">
                                <img height="80" width="80" src="{{ asset('uploads') }}/{{ $item->productImages[0]->path }}" alt="" />
                            </a>
                        </td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td><a href="{{ route('showEditProductView', ['id' => $item->id]) }}">{{ __('edit') }}</a> ||
                            <a href="{{ route('deleteProduct', ['id' => $item->id]) }}">{{ __('delete') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
