<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
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

    public $appends = [
        'profile_img_url',
    ];



    public function getProfileImgUrlAttribute()
    {

            return $this->defaultAvatar();


    }


    public function defaultAvatar()
    {
        $name = trim($this->name);
        if (strpos($name, ' ') !== false) {
            $parts = explode(' ', $name);
            $initial = $parts[0][0] . $parts[1][0];
        } else {
            $initial = $name[0];
        }
        return route('default-avatar', strtolower($initial));
    }

    public function toApiArray()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['name'] = $this->name ?? '';
        $data['email'] =   $this->email ?? '';
        $data['password'] = $this->password ?? '';

        return $data;
    }

}
