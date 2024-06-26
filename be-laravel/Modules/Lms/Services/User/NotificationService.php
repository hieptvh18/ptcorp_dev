<?php

namespace Modules\Lms\Services\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Illuminate\Support\Arr;
use Modules\Lms\Models\ClassRoom;
use Modules\Lms\Models\Notification;
use Modules\Lms\Repositories\ClassRoomRepository;
use Modules\Lms\Repositories\NotificationConfigRepository;

class NotificationService extends BaseService
{
    /**
     * @var NotificationConfigRepository
     */
    protected $notificationConfigRepository;
    /**
     * @var ClassRoomRepository
     */
    protected $classRoomRepository;

    /**
     * @param NotificationConfigRepository $notificationConfigRepository
     * @param ClassRoomRepository $classRoomRepository
     */
    public function __construct(
        NotificationConfigRepository $notificationConfigRepository,
        ClassRoomRepository $classRoomRepository
    )
    {
        $this->notificationConfigRepository = $notificationConfigRepository;
        $this->classRoomRepository = $classRoomRepository;
    }

    public function handleNotificationToUser(){
        $configs = $this->notificationConfigRepository
            ->select('id','title','description','file_attach_url','link_attach_url','published_at','type')
            ->where([
                ['is_active',true],
                ['published_at','>=',Carbon::now('Asia/Ho_Chi_Minh')->subMinutes(1)],
                ['published_at','<=',Carbon::now('Asia/Ho_Chi_Minh')]
            ])->get();

        // mapping configs available
        foreach($configs as $config){
            $classRoomIds = array();
            foreach ($config->modeOptions as $option){
                if($option->notification_typeable == ClassRoom::class){
                    $classRoomIds[] = $option->notification_typeable_id;
                }
            }

            // get class member & render record notification to member & call push notification
           if(!empty($classRoomIds)){
               $userInClass = $this->classRoomRepository
                   ->whereIn('id',$classRoomIds)
                   ->has('members')
                   ->with(['members'])
                   ->get();

               $userIds = array_unique(Arr::flatten($userInClass->map(function($val){
                   return $val->members->pluck('user_id');
               })));
               $memberIds = array_unique(Arr::flatten($userInClass->map(function($val){
                   return $val->members->pluck('id');
               })));

                foreach ($memberIds as $memberId){
                    $notification = new Notification([
                        'notification_config_id'=>$config->id,
                        'member_id'=> $memberId,
                        'title'=>$config->title,
                        'description'=>$config->description
                    ]);
                    $config->notifications()->save($notification);
                }

                if(!empty($userIds)){
                    $apiData = $this->prepareDataCurl($config,$userIds);
                    $this->callCurlSendNotification($apiData);
                }
           }
        }
    }

    protected function prepareDataCurl($configs,$userIds){
        $data = [
            'user_ids'=>$userIds,
            'title'=>$configs->title,
            'body'=>$configs->description,
            'topic'=>'noti1',
            'custom_data'=>[
                'file_attach_url'=>$configs->file_attach_url,
                'link_attach_url'=>$configs->link_attach_url,
            ],
            'bizapp_alias'=>'EDULMS'
        ];

        return json_encode($data) ;
    }

    protected function callCurlSendNotification($data){
        try{
            $curl = curl_init();

            curl_setopt_array($curl, array(
//                CURLOPT_URL => 'http://localhost:8001/notification/api/v1/public/push-notification',
                CURLOPT_URL => 'https://notification-dev.103-170-122-18.flashvps.xyz/notification/api/v1/public/push-notification',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$data,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;
        }catch (\Exception $e){
            return null;
        }
    }
}
