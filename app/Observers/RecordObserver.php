<?php

namespace App\Observers;

use App\Models\Logs;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;

class RecordObserver
{
    /**
     * Handle the Record "created" event.
     */
    public function created(Record $record): void
    {
        Logs::create([
            'type' => 'create',
            'message' => 'تم أضافة مريض جديد : ' . $record->name,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Record "updated" event.
     */
    public function updated(Record $record): void
    {
        Logs::create([
            'type' => 'update',
            'message' => 'تم  تعديل بيانات مريض : ' . $record->name,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Record "deleted" event.
     */
    public function deleted(Record $record): void
    {
        //
    }

    /**
     * Handle the Record "restored" event.
     */
    public function restored(Record $record): void
    {
        //
    }

    /**
     * Handle the Record "force deleted" event.
     */
    public function forceDeleted(Record $record): void
    {
        //
    }
}
