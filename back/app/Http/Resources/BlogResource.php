<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $index_route = $request->route()->named('blogs.index');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->whenHas($this->slug, $this->slug, Str::slug($this->title)),
            'description' => $this->when(
                $index_route,
                mb_substr($this->description, 0, 80).'...',
                $this->description
            ),
            'user_id' => $this->user_id,
            'user' => $this->when(! $index_route, UserResource::make(User::find($this->user_id))),
            'posts' => $this->when(! $index_route, $this->posts),
        ];
    }
}
