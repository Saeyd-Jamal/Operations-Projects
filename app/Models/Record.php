<?php

namespace App\Models;

use App\Observers\RecordObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'name',
        'financier_number',
        'age',
        'patient_ID',
        'phone_number1',
        'phone_number2',
        'operation',
        'doctor',
        'amount',
        'doctor_share',
        'anesthesiologists_share',
        'anesthesia',
        'bed',
        'private',
        'done',
        'notes',
        'notes_2',
        'user_id',
        'user_name',
    ];

    protected static function boot()
    {
        parent::boot();

        // تسجيل الـ Observer
        static::observe(RecordObserver::class);
    }
}
