<x-mail::message :type='$type'>
{{-- Greeting --}}
# Thông báo,

Khách hàng {{$contact->name}} vừa đăng ký tư vấn.

Số điện thoại khách hàng: {{$contact->mobile}}

Nội dung: {{$contact->message}}

{{ config('app.name') }}
</x-mail::message>
