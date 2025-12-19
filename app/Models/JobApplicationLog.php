<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'status',
        'event_date',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
