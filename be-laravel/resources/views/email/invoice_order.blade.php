<x-mail::message>
{{-- Greeting --}}
# Xin chào {{ $fullname }},

{{-- Intro Lines --}}
Yêu cầu nâng cấp tài khoản VIP của bạn đã được tạo thành công<br />

Thông tin thanh toán<br />
------------------------ <br />
Mã Order                :  **{{$order_code}}** <br/>
Thời gian VIP           : **{{$month}} tháng**  <br/>
Phương thức thanh toán  : **{{$payment_method}}** <br/>
Tổng tiền               : **{{$order_total}}**<br/>
Trạng thái              : **Chưa thanh toán**<br/>
------------------------ <br />

### Quét mã QR để chuyển khoản thanh toán
<img src="{{$qr_code}}" alt="qrcode"/>

### Hướng dẫn chuyển khoản thanh toán
- **Bước 1** : Mở ứng dụng ngân hàng hoặc ví điện tử trên điện thoại của bạn<br/>
    - Chọn chức năng chuyển tiền
- **Bước 2** : Chọn chức năng QR thanh toán hoặc Quét mã
- **Bước 3** : Nhập số tiền chuyển khoản tương ứng và tin nhắn bắt buộc
    - Số tiền chuyển khoản : **{{$order_total}}**
    - Nội dung tin nhắn đi kèm là số hoá đơn: **{{$order_code}}**
    - Vui lòng nhập chính xác số hoá đơn để Admin xác nhận đúng thông tin
- **Bước 4** : Tại màn hình thông tin thanh toán , chọn Xác nhận để hoàn tất quá trình chuyển khoản
- **Bước 5** : Chờ Admin xác nhận hoá đơn
    - Sau khi bạn chuyển khoản thành công , đợi từ 1 phút - 30 phút để Admin xác nhận hoá đơn
    - Thời gian Admin xác nhận trong ngày: từ 8h - 23h

<hr/>
Nếu quý khách gặp bất kỳ khó khăn nào trong lúc thanh toán, vui lòng liên hệ với Admin fanpage <a href="{{config('general.social.fanpage')}}" target="_blank">EduQuiz</a> để được hỗ trợ tốt nhất. <br/><br>
Chân thành cảm ơn quý khách đã sử dụng ứng dụng!<br>
{{ config('app.name') }}
</x-mail::message>
