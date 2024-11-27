<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function assignedSubjects()
    {
        return $this->hasMany(AssignSubjectToClass::class, 'class_id');
    }
}
