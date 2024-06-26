<?php

namespace Modules\Auth\Services\Admin;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Modules\Auth\Models\Teamwork;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Repositories\WorkspaceWebsiteRepository;
use Modules\Auth\Events\EventWorkspaceInfoServiceCreateAfter;

class AdminWorkspaceWebsiteService extends BaseService
{
    public function __construct(WorkspaceWebsiteRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function create(Request $request)
    {
        try {
            $images_logo_tmp = Storage::disk('s3')->allFiles('workspace/alias/workspace_website_logo_tmp');
            $logo_url = '';
            foreach ($images_logo_tmp as $image_logo_tmp) {
                if ($request->logo_url === $image_logo_tmp) {
                    $logo_url = str_replace('workspace/alias/workspace_website_logo_tmp', 'workspace/alias/workspace_website_logo', $image_logo_tmp);
                    Storage::disk('s3')->move($image_logo_tmp, $logo_url);
                    Storage::disk('s3')->deleteDirectory('workspace/alias/workspace_website_logo_tmp');
                }
            };

            $images_favicon_tmp = Storage::disk('s3')->allFiles('workspace/alias/workspace_website_favicon_tmp');
            $favicon_url = '';
            foreach ($images_favicon_tmp as $image_favicon_tmp) {
                if ($request->favicon === $image_favicon_tmp) {
                    $favicon_url = str_replace('workspace/alias/workspace_website_favicon_tmp', 'workspace/alias/workspace_website_favicon', $image_favicon_tmp);
                    Storage::disk('s3')->move($image_favicon_tmp, $favicon_url);
                    Storage::disk('s3')->deleteDirectory('workspace/alias/workspace_website_favicon_tmp');
                }
            }

            if (!$favicon_url) {
                $favicon = $request->favicon;
            }

            DB::beginTransaction();
            $data = $request->all();
            $data['logo_url'] = $logo_url;
            $data['favicon'] = $favicon;
            $item = $this->baseRepository->create($data);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (in_array('update', $this->allowPolicies)) {
                $this->authorize('update', $id);
            }
            $images_logo_tmp = Storage::disk('s3')->allFiles('workspace/alias/workspace_website_logo_tmp');
            $logo_url = '';
            foreach ($images_logo_tmp as $image_logo_tmp) {
                if ($request->logo_url === $image_logo_tmp) {
                    $logo_url = str_replace('workspace/alias/workspace_website_logo_tmp', 'workspace/alias/workspace_website_logo', $image_logo_tmp);
                    Storage::disk('s3')->move($image_logo_tmp, $logo_url);
                    Storage::disk('s3')->deleteDirectory('workspace_website_logo_tmp');
                }
            }

            if (!$logo_url) {
                $logo_url = $request->logo_url;
            }

            $images_favicon_tmp = Storage::disk('s3')->allFiles('workspace/alias/workspace_website_favicon_tmp');
            $favicon_url = '';
            foreach ($images_favicon_tmp as $image_favicon_tmp) {
                if ($request->favicon === $image_favicon_tmp) {
                    $favicon_url = str_replace('workspace/alias/workspace_website_favicon_tmp', 'workspace/alias/workspace_website_favicon', $image_favicon_tmp);
                    Storage::disk('s3')->move($image_favicon_tmp, $favicon_url);
                    Storage::disk('s3')->deleteDirectory('workspace/alias/workspace_website_favicon_tmp');
                }
            }

            if (!$favicon_url) {
                $favicon = $request->favicon;
            }

            DB::beginTransaction();
            $data = $request->all();
            $data['logo_url'] = $logo_url;
            $data['favicon'] = $favicon;
            $item = $this->baseRepository->update($data, $id);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getWPWebsiteDomain($website_id){
        $wp_website = $this->baseRepository->find($website_id);
        $data = $wp_website->websiteDomain;
        return $data;
    }

}
