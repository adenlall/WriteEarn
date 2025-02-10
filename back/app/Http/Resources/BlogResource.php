<?php

namespace App\Http\Resources;

use App\Models\User;
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
        $index_route = $request->route()->named('blogs.index');
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "description"=>$this->when(
                $index_route,
                mb_substr($this->description, 0, 80)."...",
                $this->description
            ),
            "publisher_id"=>$this->publisher_id,
            "publisher"=>$this->when(!$index_route,UserResource::make(User::find($this->publisher_id))),
            "posts"=>$this->when(!$index_route, $this->posts),
        ];
    }
}
