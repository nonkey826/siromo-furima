<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Item extends Model
{
    use HasFactory;

    /**
     * itemsテーブルに存在するカラムと完全一致させる
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'image',
        'is_sold',
        'category',
        'status',
        'brand',
    ];

    /**
     * 出品者（usersテーブル）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * お気に入りしたユーザー（favorites 中間テーブル）
     */
    public function favoritedUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
     * 商品へのコメント（commentsテーブル）
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
