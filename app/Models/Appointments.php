<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointments extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'patient_id',
        'anamnesis',
        'complaint',
        'status',
    ];

    /**
     * Defining Relationships
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function session()
    {
        return $this->hasMany(Session::class);
    }
}
