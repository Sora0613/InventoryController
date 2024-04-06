<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail;


class User extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmail, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isLineExists(): bool
    {
        // ログインユーザーのLINE情報を取得
        $line = LineInformation::where('user_id', $this->id)->first();
        if ($line) {
            return true;
        }
        return false;
    }

    public function getLineId()
    {
        // ログインユーザーのLINE情報を取得
        $line = LineInformation::where('user_id', $this->id)->first();
        if ($line) {
            return $line->line_user_id;
        }
        return null;
    }

    public function isDarkMode()
    {
        return $this->is_dark_mode;
    }

    // すでにダークモードならlightモードに、逆も然り。変更が終わったらリロード。
    public function changeTheme()
    {
        $this->is_dark_mode = !$this->is_dark_mode;
        $this->save();
    }

    public function isShared(): bool
    {
        return $this->share_id !== null;
    }
}
