<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'avatar' => $this->avatar,
            'phone' => $this->phone,
            'role_id' => $this->role_id,
            'role_name' => $this->roles->name,
            'user_store' => UserStoreResource::collection($this->user_store),
            'subscription_name' => $this->subscriber->subscription->name ?? "",
            'subscription_start_at' => $this->subscriber->start_at ?? "",
            'subscription_stopped_at' => $this->subscriber->stopped_at ?? ""
        ];
    }
}
