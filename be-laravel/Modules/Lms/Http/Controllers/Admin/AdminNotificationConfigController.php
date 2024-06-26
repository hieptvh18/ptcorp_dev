<?php

namespace Modules\Lms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Lms\Http\Requests\Admin\NotificationConfigSaveRequest;

/**
 * @group Module Lms
 *
 * APIs for managing config notification
 *
 * @subgroup Notification Config
 * @subgroupDescription AdminNotificationConfigController
 */
class AdminNotificationConfigController extends ApiController
{
    protected $notificationConfig;

    public function __construct(\Modules\Lms\Services\Admin\AdminNotificationConfigService $adminNotificationConfigService)
    {
        $this->notificationConfig = $adminNotificationConfigService;
    }

    /**
     * Admin xem danh sách cấu hình thông báo.
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->notificationConfig->getList($request);
        return $this->json($item);
    }

    /**
     * Admin lưu cấu hình thông báo
     * @param NotificationConfigSaveRequest $request
     * @return Response
     */
    public function store(NotificationConfigSaveRequest $request)
    {
        $item = $this->notificationConfig->create($request);
        $data = [
            'message' => __('cms::message.notification_config.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xem chi tiết cấu hình thông báo
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->notificationConfig->find($id);
        return $this->json($item);
    }

    /**
     * Admin cập nhật cấu hình thông báo
     * @param NotificationConfigSaveRequest $request
     * @param int $id
     * @return Response
     */
    public function update(NotificationConfigSaveRequest $request, $id)
    {
        $item = $this->notificationConfig->update($request,$id);
        $data = [
            'message' => __('cms::message.notification_config.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa cấu hình thông báo
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->notificationConfig->delete($id);
        $data = [
            'message' => __("cms::message.notification_config.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
