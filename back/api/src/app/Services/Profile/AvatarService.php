<?php

namespace App\Services\Profile;

use App\Repositories\UserRepository;
use Creativeorange\Gravatar\Facades\Gravatar;

class AvatarService
{

    public function __construct(
        private UserRepository $userRepository,
        private AvatarStorageService $storageService)
    {
    }

    public function getAvatarFromGravatar(int $user_id)
    {
        $user = $this->userRepository->findOrFail($user_id);

        $email = strtolower(trim($user->email));

        if(Gravatar::exists($email)) {
            $url_original = Gravatar::get($email, 'original');
            $this->storageService->storeAvatarFromUrl($user_id,  'original', $url_original);
            $url_medium = Gravatar::get($email, 'medium');
            $this->storageService->storeAvatarFromUrl($user_id,  'medium', $url_medium);
            $url_small = Gravatar::get($email, 'small');
            $this->storageService->storeAvatarFromUrl($user_id,  'smaill', $url_small);

            return [
                $url_original, $url_medium, $url_small
            ];
        }

        return [];
    }

}
