@component('mail::message')
    <h2>BẢN BÁO CÁO DOANH THU</h2>
    <h3>Doanh thu cửa hàng trong ngày {{ $day }}</h3>
    <h3>Tổng doanh thu : {{ vndFormat($total) }}</h3>
    Chúc bạn có 1 ngày làm việc hiệu quả,<br>
    {{ config('app.name') }}
@endcomponent
