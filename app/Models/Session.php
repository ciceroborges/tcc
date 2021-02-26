<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appointment_id',
        'title',
        'description',
        'status',
        'date',
    ];
    
     /**
     * Defining Relationships
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
