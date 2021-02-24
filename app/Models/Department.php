<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
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
        return $this->hasMany(Appointments::class);
    }
}
