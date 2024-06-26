<?php

namespace Modules\Cms\Services;

use App\Exceptions\ApiException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadService
{

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $type = $request->post('type');
        $user = auth()->user();
        $workspaceAlias = $user->currentTeam->teamable->alias;
        $path = "/workspace/$workspaceAlias/cms";
        if ($type === 'CMS_BANNER') {
            $path = $path.'/cms_banner_tmp';
            return $this->handleUpload($file, $path);
        }elseif($type === 'CMS_FEEDBACK_STUDENT_AVATAR'){
            $path = $path.'/cms_feedback_student_avatar_url_tmp';
            return $this->handleUpload($file, $path);
        }elseif($type === 'CMS_CATEGORY_THUMBNAIL'){
            $path = $path.'/cms_category_thumbnail_url_tmp';
            return $this->handleUpload($file, $path);
        }elseif($type === 'CMS_FAQ_CATEGORY_THUMBNAIL'){
            $path = $path.'/cms_faq_category_url_tmp';
            return $this->handleUpload($file, $path);
        }elseif($type === 'CMS_INSTRUCTOR_AVATAR'){
            $path = $path.'/cms_instructor_avatar_url_tmp';
            return $this->handleUpload($file, $path);
        }elseif($type === 'CMS_BLOG_IMAGE'){
            $path = $path.'/cms_blog_image_tmp';
            return $this->handleUpload($file, $path);
        }elseif($type === 'CMS_COURSE_AVATAR'){
            $path = $path.'/cms_course_avatar_tmp';
            return $this->handleUpload($file, $path);
        }elseif($type === 'CMS_COURSE_PREVIEW_VIDEO'){
            $path = $path.'/cms_course_preview_video_tmp';
            return $this->handleUpload($file, $path,'VIDEO');
        }elseif($type === 'CMS_COURSE_WEBSITE_LOGO'){
            $path = $path.'/cms_course_website_logo_tmp';
            return $this->handleUpload($file, $path);
        }elseif($type === 'CMS_COURSE_WEBSITE_FAVICON'){
            $path = $path.'/cms_course_website_favicon_tmp';
            return $this->handleUpload($file, $path);
        }

        return false;
    }

    public function handleUpload($file, $path, $type='IMAGE')
    {
        if ($file) {
            $allowedExtension = ['jpg', 'png', 'jpeg'];
            $extension = $file->getClientOriginalExtension();
            $name = 'IMG_' . Carbon::now()->timestamp . '.' . $extension;
            $limitVideoSize = 1048576 * 300;// 300MB
            $limitFileSize = 1048576 * 10;// 10MB

            $size = $file->getSize();
            if ($file->isValid()) { // nếu file không lỗi
                if($type == "VIDEO") {
                    $allowedExtension = ['mp4','mov','wmv','avi','webm'];
                    $limitFileSize = $limitVideoSize;
                }
                if (in_array($extension, $allowedExtension)) { // nếu đúng định dạng file
                    if ($size < $limitFileSize) {
                        $filename = Storage::disk('s3')->putFileAs($path, $file, $name, 'public');
                        // $filename = $file->storeAs($path,$name);
                        return $filename;
                    } else {
                        throw new ApiException("$name vượt quá dung lượng (ảnh tối đa 10mb, video tối đa 300mb)", 400);
                    }
                } else {
                    throw new ApiException("$name lỗi định dạng, vui lòng kiểm tra lại", 400);
                }
            } else {
                throw new ApiException("$name đã bị lỗi, vui lòng kiểm tra lại", 400);
            }
        } else {
            throw new ApiException('Bạn chưa chọn file tải lên', 400);
        }
    }
}
