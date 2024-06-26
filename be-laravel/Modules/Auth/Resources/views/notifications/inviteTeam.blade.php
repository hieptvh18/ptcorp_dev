<x-mail::message>
{{-- Greeting --}}
# Xin chào,

Bạn đã nhận được lời mời vào nhóm {{$team->name}}  <br />

Nhấn vào đây để xem chi tiết: <a href="{{ $url }}"> Tham Gia </a>

Chân thành cảm ơn quý khách đã sử dụng ứng dụng!<br>
{{ config('app.name') }}
</x-mail::message>
