<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'class_id',
        'examination_id',
        'subject_id',
        'exam_date',
        'start_time',
        'end_time',
        'duration_time',
        'room_no',
        'full_mark',
        'pass_mark',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class, 'examination_id', 'id');
    }
}
