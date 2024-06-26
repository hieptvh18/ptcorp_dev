@props(['url','type'])
@if(isset($type) && $type == 'cms')
    <tr>
        <td class="header">
            <a href="{{ $url }}" style="display: inline-block;">
                @if (trim($slot) === config('app.name'))
                    <img src="https://dev.educms.vn/assets/logo/EduCMS.png" class="logo">
                    <p style="text-align: center;margin-top: 5px;">EduCMS - Hệ thống quản lý khoá học</p>
                @else
                    {{ $slot }}
                @endif
            </a>
        </td>
    </tr>
@else
    <tr>
        <td class="header">
            <a href="{{ $url }}" style="display: inline-block;">
                @if (trim($slot) === config('app.name'))
                    <img src="https://dev.eduquiz.vn/logo/logo-256.png" class="logo">
                    <p style="text-align: center;margin-top: 5px;">EduQuiz 4.0 - Nền tảng tạo và chia sẻ đề thi trắc nghiệm
                        online</p>
                @else
                    {{ $slot }}
                @endif
            </a>
        </td>
    </tr>
@endif
