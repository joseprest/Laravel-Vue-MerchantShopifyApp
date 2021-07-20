<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;
use Osiset\ShopifyApp\Traits\ShopModel;

class User extends Authenticatable implements IShopModel
{
    use Notifiable, ShopModel;

    protected $fillable = [
        'name', 'email', 'password', 'current_merchant'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['first_name'];

    public function merchant()
    {
        return $this->hasOne(Merchant::class, 'id', 'current_merchant');
    }

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_user')->withPivot('role', 'created_at');
    }

    public function merchantsList()
    {
        return $this->merchants()->get()->each->setAppends([]);
    }

    public function getFirstNameAttribute()
    {
        return $this->name ? explode(' ', $this->name)[0] : $this->name;
    }
}
