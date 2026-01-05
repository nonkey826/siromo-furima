<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 既存の $fillable や $hidden があればそのままでOK

    /**
     * このユーザーのいいね一覧
     */
    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    /**
     * このユーザーがいいねした商品一覧
     */
    public function likedItems()
    {
        return $this->belongsToMany(
            \App\Models\Item::class,
            'likes'
        )->withTimestamps();
    }
}
