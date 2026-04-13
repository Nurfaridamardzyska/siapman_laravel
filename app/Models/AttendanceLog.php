<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = [
        'employee_id',
        'attendance_date',
        'check_in_at',
        'check_out_at',
        'status_id',
        'check_in_photo_path',
        'check_out_photo_path',
        'note'
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

        public function employee()
    {
        return $this->belongsTo(\App\Models\User::class, 'employee_id');
    }

    public function status()
    {
        return $this->belongsTo(AttendanceLogStatus::class, 'status_id');
    }
}