<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadUserAvatarRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => ['required|file|mimes:jpeg,png,jpg,gif,webp|max:8096'],
        ];
    }
}
