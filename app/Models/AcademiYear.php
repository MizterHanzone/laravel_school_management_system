<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademiYear extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->hasMany(User::class,  'acdemi_year_id');
    }
}
