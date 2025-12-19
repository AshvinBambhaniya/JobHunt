<?php

namespace App\Models;

use App\Enums\JobType;
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
        'job_type',
        'expected_salary',
    ];

    protected $casts = [
        'job_type' => JobType::class,
        'applied_date' => 'datetime',
        'expected_salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(JobApplicationLog::class);
    }

    public function latestLog()
    {
        return $this->hasOne(JobApplicationLog::class)->latestOfMany();
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
