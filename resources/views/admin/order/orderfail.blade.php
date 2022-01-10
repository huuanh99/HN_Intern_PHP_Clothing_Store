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
                        <th>{{ __('phone') }}</th>
                        <th>{{ __('address') }}</th>
                        <th>{{ __('totalprice') }}</th>
                        <th>{{ __('timeorder') }}</th>
                        <th>{{ __('detail') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $item)
                    <tr class="odd gradeX">
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ vndFormat($item->total) }}</td>
                        <td>{{ formatDate($item->created_at) }}</td>
                        <td><a href="{{ route('adminorderdetail', ['id' => $item->id]) }}">{{ __('detail') }}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
