<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * 外部に見せないカラム
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型変換
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // =========================
    // リレーション
    // =========================

    /**
     * ユーザーが出品した商品
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * ユーザーの購入履歴
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * お気に入り登録した商品
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * ユーザーのプロフィール情報
     * → profiles テーブルと1対1
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * ユーザーの住所情報
     * → addresses テーブルと1対1
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }


    //いいね
    public function likedItems()
{
    return $this->belongsToMany(
        \App\Models\Item::class,
        'likes'
    )->withTimestamps();
}

}

