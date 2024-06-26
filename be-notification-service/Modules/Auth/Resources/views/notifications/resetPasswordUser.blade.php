<x-mail::message>
{{-- Greeting --}}
# Xin chào {{ $name }},

{{-- Intro Lines --}}
{{$subject}} <br />

Thông tin tài khoản <br />

------------------------ <br />
Tên                     :  **{{$name}}** <br/>
Email                   : **{{$email}}**  <br/>
Mật khẩu mới            : **{{$password}}**<br/>
------------------------ <br />

Chân thành cảm ơn quý khách đã sử dụng ứng dụng!<br>
{{ config('app.name') }}
</x-mail::message>
