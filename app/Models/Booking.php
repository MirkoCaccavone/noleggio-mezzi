<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // usiamo il campo $fillable per proteggere il modello da assegnazioni di massa non volute
    protected $fillable = [
        'vehicle_id',
        'customer_name',
        'customer_email',
        'start_date',
        'end_date',
        'status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
