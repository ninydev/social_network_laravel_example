<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UploadUserAvatarRequest;
use App\Jobs\Profile\CreateAvatarJob;
use App\Jobs\Profile\OptimizeAvatarJob;
use App\Services\Profile\AvatarService;

class UploadUserAvatarController extends Controller
{

    public function __construct()
    {
    }

    public function __invoke(
        AvatarService $avatarService,
        UploadUserAvatarRequest $request)
    {
        $avatarService->uploadAvatar($request->user()->id, $request->file('avatar'));
        OptimizeAvatarJob::dispatch($request->user()->id);

        // CreateAvatarJob::dispatch($request->user()->id);
        // return response()->json($this->avatarService->createAvatar($request->user()->id));
    }

}
