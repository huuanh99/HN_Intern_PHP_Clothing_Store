@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <h2>{{ __('listcategory') }}</h2>
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>{{ __('id') }}</th>
                        <th>{{ __('name') }}</th>
                        <th>{{ __('slug') }}</th>
                        <th>{{ __('action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $key => $item)
                    <tr class="odd gradeX">
                        <td>{{ $key }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->slug }}</td>
                        <td><a href="{{ route('catedit', ['id' => $item->id]) }}">{{ __('edit') }}</a> || <a  href="{{ route('catdelete', ['id' => $item->id]) }}">{{ __('delete') }}</a></td>
                    </tr>
                    @endforeach            
                </tbody>
            </table>
        </div>
    </div>
</div>        
@endsection

