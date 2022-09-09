<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laravel\Sanctum\HasApiTokens;
use Tinify\Source;
use Tinify\Tinify;

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
        'photo',
        'phone',
        'position_id',
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
    ];


    public function position()
    {
        return $this->belongsTo(Position::class,'position_id','id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setPhotoAttribute($value)
    {
        $this->attributes['photo'] = Storage::disk('public')->put('images', $value);
        Image::make(public_path('storage/' . $this->attributes['photo']))->crop(70, 70)->save();
        Tinify::setKey('Ldj9nJdmLWzwdCKzCXwYbRCRJrGFtg3c');
        $file = public_path('storage/' . $this->attributes['photo']);
        $source = Source::fromFile($file);
        $source->toFile($file);
    }
}
