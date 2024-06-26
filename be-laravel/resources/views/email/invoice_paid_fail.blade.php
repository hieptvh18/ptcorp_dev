<x-mail::message>
{{-- Greeting --}}
# Xin chào {{ $fullname }},

{{-- Intro Lines --}}
Nâng cấp tài khoản Vip thất bại !!!<br />

<x-mail::button :url="$actionUrl" >
{{ $actionText }}
</x-mail::button>

Chân thành cảm ơn quý khách đã sử dụng ứng dụng!<br>
{{ config('app.name') }}
</x-mail::message>
