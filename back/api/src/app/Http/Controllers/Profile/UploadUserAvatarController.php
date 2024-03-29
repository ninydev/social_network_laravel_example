<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UploadUserAvatarRequest;
use App\Jobs\Profile\CreateAvatarJob;
use App\Jobs\Profile\OptimizeAvatarJob;
use App\Services\Profile\AvatarService;
use App\Services\Socket\SocketService;

class UploadUserAvatarController extends Controller
{

    public function __construct()
    {
    }

    public function __invoke(
        SocketService $socketService,
        AvatarService $avatarService,
        UploadUserAvatarRequest $request)
    {
        $avatarService->uploadAvatar($request->user()->id, $request->file('avatar'));
        OptimizeAvatarJob::dispatch($request->user()->id);
        // В момент запроса у меня еще нет файла автатарки
        // Я не знаю, когда он будет готов

        // Как фронт (клиент) узнает, что у него появилась аватарка?
        // $socketService->emit('socket.php', date('Y-m-d H:i:s'));

        // CreateAvatarJob::dispatch($request->user()->id);
        // return response()->json($this->avatarService->createAvatar($request->user()->id));
    }

}
