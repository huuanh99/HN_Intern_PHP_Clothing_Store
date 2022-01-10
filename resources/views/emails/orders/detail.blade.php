@component('mail::message')
    <h3>{{ __('name') }}    : {{ $data->user->name }}</h3>
    <h3>{{ __('address') }} : {{ $data->address }}</h3>
    <h3>{{ __('phone') }}   : {{ $data->phone }}</h3>
@component('mail::table')
    |     #      |    {{ __('name') }}      |     {{ __('price') }}       |{{ __('quantity') }} |
    |------------|--------------------------|-----------------------------|---------------------|
@foreach ($data->orderDetails as $key => $item)
    |  {{ ++$key }}  |  {{ $item->product->name }}  |  {{ vndFormat($item->price) }}  |  {{ $item->quantity }}  |
@endforeach
@endcomponent
    <h3 style="float: right; background: rgb(38, 148, 38); padding: 5px 10px; color: white">
        {{ __('totalprice') }} : {{ vndFormat($data->total) }}
    </h3>
    {{ __('thanks') }},<br>
    {{ config('app.name') }}
@endcomponent
