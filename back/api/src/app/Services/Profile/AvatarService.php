<?php

namespace App\Services\Profile;

use App\Repositories\UserRepository;
use Creativeorange\Gravatar\Facades\Gravatar;

class AvatarService
{

    public function __construct(
        private UserRepository $userRepository)
    {
    }

    public function getAvatarFromGravatar(int $user_id)
    {
        $user = $this->userRepository->findOrFail($user_id);

        $email = strtolower(trim($user->email));

        if(Gravatar::exists($email)) {
            $url_original = Gravatar::get($email, 'original');
            $url_medium = Gravatar::get($email, 'medium');
            $url_small = Gravatar::get($email, 'small');



//            return [
//                $url_original, $url_medium, $url_small
//            ];
        }
    }

}
