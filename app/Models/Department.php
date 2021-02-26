<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Defining Relationships
     */
    public function user_department()
    {
        return $this->hasMany(UserDepartment::class);
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }
}
