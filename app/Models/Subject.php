<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];

    public function assignedClasses()
    {
        return $this->hasMany(AssignSubjectToClass::class, 'subject_id');
    }
}
