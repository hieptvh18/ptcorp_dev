<?php

namespace Modules\Cms\Listeners;

use Illuminate\Support\Facades\Notification;
use Modules\Auth\Repositories\WorkspaceWebsiteRepository;
use Modules\Cms\Repositories\CmsSettingRepository;
use Modules\Cms\Notifications\ClientSendContactNotification;
use Modules\Cms\Events\ClientSendContactAfter;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenserClientSendContactAfter
{
    use InteractsWithQueue;

    protected $websiteRepository;
    protected $settingRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WorkspaceWebsiteRepository $websiteRepository, CmsSettingRepository $cmsSettingRepository)
    {
        $this->websiteRepository = $websiteRepository;
        $this->settingRepository = $cmsSettingRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ClientSendContactAfter  $event
     * @return void
     */
    public function handle(ClientSendContactAfter $event)
    {
        $workspaceAlias = $event->workspaceAlias;
        $emailSetting = $this->getEmailSetting($workspaceAlias);
        $contact = $event->contact;
        if($emailSetting){
            Notification::route('mail', $emailSetting)->notify(new ClientSendContactNotification($contact));
        }
    }

    /**
     * @param $workspaceAlias
     * @return mixed|null
     */
    private function getEmailSetting($workspaceAlias){
       try{
           $website = $this->websiteRepository->select('id')->where('workspace_alias',$workspaceAlias)->first();
           $groupSettingGeneral = 'GENERAL_'.$website->id;
           $setting = $this->settingRepository->select('setting')->where('group',$groupSettingGeneral)->first();
           $emailSetting = collect($setting->setting)->filter(function ($val,$key){
               if($key == 'email') return $val;
           });
           return $emailSetting['email'] ?? null;
       }catch (\Exception $e){
           return null;
       }
    }
}
