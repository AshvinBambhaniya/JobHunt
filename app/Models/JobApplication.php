<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'role',
        'location',
        'status',
        'applied_date',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
