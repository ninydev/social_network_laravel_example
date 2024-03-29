<?php

namespace App\Services\Profile;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarStorageService
{
    public function storeAvatarFromUrl(int $user_id, string $avatar_type, string $avatar_url)
    {
        // Получить содержимое изображения по URL
        $imageContent = file_get_contents($avatar_url);

        // Сгенерировать уникальное имя файла
        $path = $user_id . '/' . $avatar_type . '.webp';

        // Сохранить изображение в storage/app/public
        Storage::disk('avatars')->put($path, $imageContent);
    }

    public function putFromContent(int $user_id,  string $avatar_type, string $avatar_content)
    {
        $path = $user_id . '/' . $avatar_type . '.webp';

        info ($path);

        // Сохранить изображение в storage/app/public
        Storage::disk('avatars')->put($path, $avatar_content);
    }

}
