<?php

namespace App\Http\Requests;

use App\Models\Resource;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:32'],
            'description' => ['nullable', 'string', 'max:65535'],
            'youtube_video_id' => ['nullable', 'string', 'max:255'],
            'engine_release_id' => ['nullable', 'exists:engine_releases,id'],
            'resource_type_id' => ['required', 'exists:resource_types,id'],
            'links.0' => ['required'],
            'links.*' => ['nullable', 'url', 'distinct:strict', 'max:255'],
            'links' => ['required', 'array', 'max:3'],
        ];
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'uploader_id' => Auth::id(),
            'slug' => Str::slug($this->title) . '-' . Resource::max('id') + 1,
            'links' => array_map(function ($link) {
                return ['url' => $link];
            }, array_filter($this->links)),
        ]);
    }

    public function attributes()
    {
        return [
            'links.*' => 'link',
        ];
    }
}
