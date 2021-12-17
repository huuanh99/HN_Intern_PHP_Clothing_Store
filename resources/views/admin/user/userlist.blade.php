@extends('admin.layout')
@section('content')
<div class="grid_10">
    <div class="box round first grid">
        <h2>{{ __('listuser') }}</h2>
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th width="5%">{{ __('id') }}</th>
                        <th width="15%">{{ __('name') }}</th>
                        <th width="15%">{{ __('phone') }}</th>
                        <th width="15%">{{ __('address') }}</th>
                        <th width="15%">{{ __('status') }}</th>
                        <th width="15%">{{ __('action') }}</th>
                        <th width="20%">{{ __('providenewpassword') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $item)
                    <tr class="odd gradeX">
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->address }}</td>
                        <td>@if ($item->status == 'active')
                            {{ __('active') }}
                            @else
                            {{ __('locked') }}
                            @endif
                        </td>
                        <td>@if ($item->status == 'active')
                            <a href="{{ route('lockUser', ['id' => $item->id]) }}">{{ __('lock') }}</a>
                            @else
                            <a href="{{ route('unlockUser', ['id' => $item->id]) }}">{{ __('unlock') }}</a>
                            @endif
                        </td>
                        <td>                
                            <a href="{{ route('provideNewPassword', ['id' => $item->id]) }}">{{ __('provide') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
