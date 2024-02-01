<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UploadUserAvatarRequest;
use App\Services\Profile\AvatarService;

class UploadUserAvatarController extends Controller
{

    public function __construct(
        private AvatarService $avatarService)
    {
    }

    public function __invoke(UploadUserAvatarRequest $request)
    {
        return response()->json($this->avatarService->getAvatarFromGravatar($request->user()->id));
    }

}
