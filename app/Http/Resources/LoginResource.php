<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    private $token;
    public function __construct($resource,$token)
    {
        $this->token = $token;
        parent::__construct($resource);
    }
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'token' => $this->token
        ];
    }
}
