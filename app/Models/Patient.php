<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
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
        'nickname',
        'cpf',
        'birth_date',
        'gender',
        'blood_type',
        'allergy',
        'address',
        'email',
        'phone_number',
        'picture',
        'contact_name',
        'contact_phone_number',
    ];
    
     /**
     * Defining Relationships
     */
    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }
}
