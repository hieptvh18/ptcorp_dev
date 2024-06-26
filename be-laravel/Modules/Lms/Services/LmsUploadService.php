<?php

namespace Modules\Lms\Services;

use App\Exceptions\ApiException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LmsUploadService
{

    public function upload(Request $request)
    {
        $user = auth()->user();
        $file = $request->file('file');
        $type = $request->post('type');
        $path = "/workspace";
        $workspace_alias = $request->header('workspace');
        if ($type === 'AVATAR_WORKSPACE') {
            $path = $path . "/$workspace_alias/avatar_workspace_tmp";
            return $this->handleUpload($file, $path);
        } elseif ($type === 'BACKGROUND_WORKSPACE') {
            $path = $path . '/' . $workspace_alias . '/background_workspace_tmp';
            return $this->handleUpload($file, $path);
        } elseif ($type === 'WORKSPACE_WEBSITE_LOGO') {
            // $alias = $user->currentTeam->teamable->alias;
            $path = "/$workspace_alias/workspace_website_logo_tmp";
            return $this->handleUpload($file, $path);
        } elseif ($type === 'WORKSPACE_WEBSITE_FAVICON') {
            $alias = $user->currentTeam->teamable->alias;
            $path = "/$workspace_alias/workspace_website_favicon_tmp";
            return $this->handleUpload($file, $path);
        }elseif($type === 'FILE_ATTACH_NOTIFICATION_CONFIG'){
            $path = "/workspace/$workspace_alias/file_attach_notification_tmp";
            return $this->handleUpload($file, $path,'file',10,'FILE_');
        }elseif($type === 'SUBJECT_AVATAR_URL'){
            $path = "/workspace/$workspace_alias/subject_avatar_tmp";
            return $this->handleUpload($file, $path);
        }

        return false;
    }

    public function handleUpload($file, $path,$type='image',$maxSize=50,$prefixName = 'IMG_')
    {
        if ($file) {
            $allowedExtension = ['jpg', 'png', 'jpeg']; // type = image
            $extension = $file->getClientOriginalExtension();
            $name = $prefixName . Carbon::now()->timestamp . '.' . $extension;

            $size = $file->getSize();
            if ($file->isValid()) { // nếu ảnh không lỗi
                if($type == 'file'){
                    $allowedExtension = ['pdf','doc','docx','rtf','txt','csv','xls','xlsx','ppt','jpg','png','jpeg'];
                }
                if (in_array($extension, $allowedExtension)) { // nếu đúng định dạng ảnh
                    if ($size < 1048576 * $maxSize) {
                        $filename = Storage::disk('s3')->putFileAs($path, $file, $name, 'public');
                        return $filename;
                    } else {
                        throw new ApiException("$name vượt quá dung lượng ".$maxSize."Mb, vui lòng kiểm tra lại", 400);
                    }
                } else {
                    throw new ApiException("$name lỗi định dạng ảnh, vui lòng kiểm tra lại", 400);
                }
            } else {
                throw new ApiException("$name đã bị lỗi, vui lòng kiểm tra lại", 400);
            }
        } else {
            throw new ApiException('Bạn chưa chọn file tải lên', 400);
        }
    }
}
