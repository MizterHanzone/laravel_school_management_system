<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignClassToTeacher extends Model
{
    use HasFactory;
    protected $table = 'class_teacher';
    protected $fillable = [
        'user_id',
        'class_id',
    ];
    // Relationship to assign classes to teachers
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with Classes
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
