<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignSubjectToClass extends Model
{
    //
    use HasFactory;

    protected $table = 'assign_subject_to_classes';

    protected $fillable = [
        'class_id',
        'subject_id',
        'status',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
