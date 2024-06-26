<?php

namespace Modules\Lms\Services\Admin;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Lms\Models\ClassRoom;
use Modules\Lms\Models\Notification;
use Modules\Lms\Models\NotificationConfigMode;
use Modules\Lms\Repositories\ClassRoomRepository;
use Modules\Lms\Repositories\NotificationConfigRepository;

class AdminNotificationConfigService extends BaseService
{
    /**
     * @var NotificationConfigRepository
     */
    protected $baseRepository;
    /**
     * @var ClassRoomRepository
     */
    protected $classRoomRepository;

    /**
     * @param NotificationConfigRepository $repository
     * @param ClassRoomRepository $classRoomRepository
     */
    public function __construct(
        NotificationConfigRepository $repository,
        ClassRoomRepository $classRoomRepository
    )
    {
        $this->baseRepository = $repository;
        $this->classRoomRepository = $classRoomRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     */
    public function getList(Request $request)
    {
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->orderBy($sort, $dir)
            ->paginate($this->limit);
        return $collection;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws Exception
     */
    public function create(Request $request)
    {
        try {
            $requestData = $request->all();
            $requestData['file_attach_url'] = $this->removeTmpFileUpload($request);
            DB::beginTransaction();

            // save config
            $notificationConfig = $this->baseRepository->create($requestData);
            $displayModeOptions = array();
            if(!empty($request->post('mode_options'))){
                if($request->post('mode_options') || $request->post('mode_option_advanceds')){
                    $displayModeOptions = array_merge($request->post('mode_options'), $request->post('mode_option_advanceds'));
                }
            }

            foreach ($displayModeOptions as $optionId){
                $notificationConfigMode = new NotificationConfigMode([
                    'notification_config_id' => $notificationConfig->id,
                    'notification_typeable_id' => $optionId,
                ]);
                switch ($request->post('type')){
                    case 'GROUP':
                        $classRoom = ClassRoom::find($optionId);
                        if ($classRoom) {
                            $classRoom->notificationConfigMode()->save($notificationConfigMode);
                        }
                        break;
                    case 'PERSONAL':
                        break;
                    case 'ROLE':
                        break;

                    default:// CUSTOM
                        break;
                }
            }

            DB::commit();

            return $notificationConfig;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     */
    public function find($id)
    {
        try{
            $config = $this->baseRepository->where('id',$id)->first();
            $modeOptions = array();
            $modeOptionAdvanceds = array();

            if($config->type == 'GROUP'){ // get config mode options
                $classRoomIds = NotificationConfigMode::where('notification_config_id',$config->id)
                    ->pluck('notification_typeable_id')->all();
                foreach ($classRoomIds as $key=>$classRoomId){
                    $class = $this->classRoomRepository->find($classRoomId);
                    if($class->type == 'GROUP'){
                        $modeOptions[] = $class;
                    }
                    if($class->type == 'CLASS'){
                        $modeOptionAdvanceds[] = $class;
                    }
                }
            }
            $config['mode_options'] = $modeOptions;
            $config['mode_option_advanceds'] = $modeOptionAdvanceds;

            return $config;
        }catch(Exception $e){
            return $config;
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        try {
            $requestData = $request->all();
            $file_attach_url = $this->removeTmpFileUpload($request);
            if(!$file_attach_url){
                $file_attach_url = $request->file_attach_url;
            }
            $requestData['file_attach_url'] = $file_attach_url;
            DB::beginTransaction();
            // save config
            $notificationConfig = $this->baseRepository->update($requestData,$id);

            $displayModeOptionIds = array();
            if(!empty($request->post('mode_options'))){
                if($request->post('mode_options') || $request->post('mode_option_advanceds')){
                    $displayModeOptionIds = array_merge($request->post('mode_options'), $request->post('mode_option_advanceds'));
                    $displayModeOptionIds = array_unique($displayModeOptionIds);
                }
            }

            if(!empty($displayModeOptionIds)){
                NotificationConfigMode::where('notification_config_id',$id)->delete();
            }

            foreach ($displayModeOptionIds as $optionId){
                $notificationConfigMode = new NotificationConfigMode([
                    'notification_config_id' => $notificationConfig->id,
                    'notification_typeable_id' => $optionId,
                ]);
                if($request->post('type') == 'GROUP'){
//                  $notificationConfig->modeOptions()->sync($displayModeOptionIds);
                    $classRoom = ClassRoom::find($optionId);
                    $classRoom->notificationConfigMode()->save($notificationConfigMode);
                }
            }

            DB::commit();

            return $notificationConfig;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function removeTmpFileUpload($request)
    {
        $user = auth()->user();
        $alias = $user->currentTeam->teamable->alias;
        $tmps = Storage::disk('s3')->allFiles("workspace/$alias/file_attach_notification_tmp");
        $file_attach_url = '';
        foreach ($tmps as $tmp) {
            if ($request->file_attach_url === $tmp) {
                $file_attach_url = str_replace("workspace/$alias/file_attach_notification_tmp", "workspace/$alias/file_attach_notification", $tmp);
                Storage::disk('s3')->move($tmp, $file_attach_url);
                Storage::disk('s3')->deleteDirectory("workspace/$alias/file_attach_notification_tmp");
            }
        };

        return $file_attach_url;
    }

}
