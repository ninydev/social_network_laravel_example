<?php

namespace App\Services\Profile;

use App\Repositories\UserRepository;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Http\UploadedFile;

class AvatarService
{

    public function __construct(private UserRepository $userRepository, private AvatarStorageService $storageService)
    {
    }

    public function uploadAvatar(int $user_id, UploadedFile $file)
    {
        $this->storageService->putFromContent($user_id, 'original', $file->getContent());
    }

    public function optimizeAvatar(int $user_id)
    {
        // Прочитать файл и сделать из него аватарки
        \Laravel\Prompts\info("Optimize");

    }


    /**
     * Получает случайные аватарки
     * @param int $user_id
     * @return array
     */
    private function getRandomAvatar(int $user_id)
    {
        return [];
    }

    /**
     * Выполняет поиск автврки
     * @param int $user_id
     * @return array
     */
    public function createAvatar(int $user_id)
    {
        $user = $this->userRepository->findOrFail($user_id);

        $email = strtolower(trim($user->email));

        if (Gravatar::exists($email)) {
            return $this->getAvatarFromGravatar($user_id, $email);
        } else {
            return $this->getRandomAvatar($user_id);
        }
    }

    /**
     * Получает автарки с сайта
     * @param int $user_id
     * @param string $email
     * @return array
     */
    private function getAvatarFromGravatar(int $user_id, string $email)
    {

        $url_original = Gravatar::get($email, 'original');
        $this->storageService->storeAvatarFromUrl($user_id, 'original', $url_original);
        $url_medium = Gravatar::get($email, 'medium');
        $this->storageService->storeAvatarFromUrl($user_id, 'medium', $url_medium);
        $url_small = Gravatar::get($email, 'small');
        $this->storageService->storeAvatarFromUrl($user_id, 'small', $url_small);

        return [$url_original, $url_medium, $url_small];
    }

}
