<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $auth = $request->user();
        $same_user = $request->user()?->id === $this?->id;
        $index_route = $request->route()->named('users.index');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->when(!$index_route, $this->role),
            'username' => $this->username,
            'created_at' => $this->when($auth, $this->created_at),
            'updated_at' => $this->when($auth || $same_user, $this->updated_at),
            'stripe_customer_id' => $this->when($same_user&&!$index_route, $this->stripe_customer_id),
            'stripe_account_id' => $this->when($same_user&&!$index_route, $this->stripe_account_id),
        ];
    }
}
