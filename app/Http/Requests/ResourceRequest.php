<?php

namespace App\Http\Requests;

use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ResourceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:32'],
            'description' => ['nullable', 'string', 'max:5000'],
            'preview_url' => [
                'nullable', 'url', 'max:191', 'regex:/\.(?:jpe?g|png)$/i',
            ],
            'youtube_video_id' => [
                'nullable', 'string', 'max:191', 'regex:/^\w+$/',
            ],
            'engine_release_id' => ['nullable', 'exists:engine_releases,id'],
            'resource_type_id' => ['required', 'exists:resource_types,id'],
            'links.0' => ['required'],
            'links.*' => ['nullable', 'url', 'distinct:strict', 'max:191'],
            'links' => ['required', 'array', 'max:3'],
        ];
    }

    public function validated()
    {
        $data = parent::validated();

        if ($this->resource) {
            return array_merge($data, [
                'links' => $this->getLinks($data),
            ]);
        }

        return array_merge($data, [
            'uploader_id' => $this->user()->id,
            'slug' => $this->getSlug($data),
            'links' => $this->getLinks($data),
        ]);
    }

    public function attributes()
    {
        return [
            'links.*' => 'link',
        ];
    }

    protected function getSlug($data) {
        return Str::slug($data['title']) . '-' . Resource::max('id') + 1;
    }

    protected function getLinks($data) {
        return array_map(function ($link) {
            return ['url' => $link];
        }, array_filter($data['links']));
    }
}
