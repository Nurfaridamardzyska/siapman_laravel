<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceDocument extends Model
{
    protected $fillable = [
        'employee_id',
        'document_type',
        'title',
        'file_path',
        'start_date',
        'end_date',
        'status',
        'approved_by',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}