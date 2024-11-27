<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    public static function getEmailSingle($column, $value)
    {
        return self::where($column, $value)->first();
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);  // 'ClassModel' is the name of the class model.
    }

    public function academiYear()
    {
        return $this->belongsTo(AcademiYear::class, 'acdemi_year_id');
    }

    // A student belongs to a parent
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // A parent has many students
    public function students()
    {
        return $this->hasMany(User::class, 'parent_id');
    }
}
