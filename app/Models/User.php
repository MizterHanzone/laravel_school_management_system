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

    // get class
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    // get acdemic year
    public function academiYear()
    {
        return $this->belongsTo(AcademiYear::class, 'acdemi_year_id');
    }

    // assign student to parent
    // A student belongs to a parent
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // assign student to parent
    // A parent has many students
    public function students()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    // assign class teacher
    // public function teachers()
    // {
    //     return $this->belongsToMany(User::class, 'assign_class_teacher', 'class_id', 'user_id');
    // }

    // assign class teacher
    // public function classes()
    // {
    //     return $this->belongsToMany(Classes::class, 'assign_class_teacher', 'user_id', 'class_id');
    // }

    // assign class teacher
    public function assignedClasses()
    {
        return $this->hasMany(AssignClassToTeacher::class, 'user_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_teacher', 'user_id', 'class_id', 'assign_class_student');
    }

    // show teacher class subject
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'class_teacher', 'class_id', 'user_id');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'assign_subject_to_classes', 'user_id', 'subject_id');
    }
    
}
