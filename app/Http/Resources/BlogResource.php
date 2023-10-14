<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'îd' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'blog_name' => $this->category->name,
            'content' => $this->content,
            'seo_keywords' => $this->seo_keywords,
            'seo_description' => $this->seo_description,
            'status' => $this->status->value,
            'created_at' => $this->created_at,
        ];
    }
}
