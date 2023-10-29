<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'author' => $this->author,
            'writer' => new UserResource($this->whenLoaded('writer')) // ?? new UserResource($this->whenLoaded('')) atau jiak tidak ada data yang di load maka akan mengembalikan null
            // whenLoaded() digunakan untuk memastikan bahwa data yang di load tidak null
            // jika mau di panggil di controller maka gunakan $post->load('writer') untuk mengambil data writer dari post atau $post->loadMissing('writer') untuk mengambil data writer dari post jika data writer tidak ada maka akan mengembalikan null
            // atau pakai $post->with('writer') untuk mengambil data writer dari post
            // 'writer' => $this->writer,
        ];
    }
}
