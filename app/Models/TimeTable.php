<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'day_id',
        'subject_id',
        'start_time',
        'end_time',
        'room_no',
    ];

    // Define the relationship to the Class
    // public function class()
    // {
    //     return $this->belongsTo(Classes::class);
    // }

    // // Define the relationship to the Subject
    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class);
    // }

    // // Define the relationship to Day
    // public function day()
    // {
    //     return $this->belongsTo(Day::class);
    // }

    public function timeTables()
    {
        return $this->hasMany(TimeTable::class, 'class_id', 'class_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id');
    }
}
