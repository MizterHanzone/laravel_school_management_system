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

    // assign subject to class
    public function assignedClasses()
    {
        return $this->hasMany(AssignSubjectToClass::class, 'subject_id');
    }

    // show student subject
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'assign_subject_to_classes', 'subject_id', 'class_id');
    }

    public function timeTables()
    {
        return $this->hasMany(TimeTable::class, 'subject_id');
    }
}
