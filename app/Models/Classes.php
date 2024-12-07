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

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'assign_subject_to_classes', 'class_id', 'subject_id');
    }

    public function students()
    {
        return $this->belongsToMany(Subject::class, 'assign_subject_to_classes', 'class_id', 'subject_id');
    }
    // show teacher class subject
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'class_teacher', 'class_id', 'user_id');
    }

    public function assignedTeachers()
    {
        return $this->hasMany(AssignClassToTeacher::class, 'class_id');
    }

    public function timeTables()
    {
        return $this->hasMany(TimeTable::class, 'class_id');
    }

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class, 'class_id', 'id');
    }
}
