<x-mail::message>
{{-- Greeting --}}
# Xin chào {{ $fullname }},

{{-- Intro Lines --}}
Tài khoản của bạn đã được nâng cấp VIP thành công!<br />

Thông tin VIP<br />
------------------------ <br />
Ngày bắt đầu    :  **{{$subscription_start_date}}** <br/>
Ngày kết thúc    : **{{$subscription_end_date}}**  <br/>
------------------------ <br />
<br />
Thông tin thanh toán<br />
------------------------ <br />
Mã Order                :  **{{$order_code}}** <br/>
Thời gian VIP           : **{{$month}} tháng**  <br/>
Phương thức thanh toán  : **{{$payment_method}}** <br/>
Tổng tiền               : **{{$order_total}}**<br/>
Trạng thái              : **Đã thanh toán**<br/>
------------------------ <br />

Chân thành cảm ơn quý khách đã sử dụng ứng dụng!<br>
{{ config('app.name') }}
</x-mail::message>
