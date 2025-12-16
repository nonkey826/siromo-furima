<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\Favorite;
use App\Models\Profile;
use App\Models\Address;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 一括代入を許可するカラム（← 登録エラーの原因）
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
     * 型変換（Laravel 12 推奨）
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // =========================
    // リレーション（ここはそのまま）
    // =========================

    // 出品した商品
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // 購入履歴
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // お気に入り
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // プロフィール
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // 住所
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}

