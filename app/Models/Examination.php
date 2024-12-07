<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "name",
        "type",
        "description",
        "status",
    ];

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }
}
