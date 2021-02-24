<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
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
        return $this->hasMany(Appointments::class);
    }
}
