<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //管理者ロール
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    //イベント主催者
    public function isOrganizer()
    {
        return $this->role === 'organizer';
    }

    //一般ユーザー
    public function isUser()
    {
        return $this->role === 'user';
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (is_null($user->role_id)) {
                $user->role_id = 1;
            }
        });
    }

    //roleリレーション設定
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
