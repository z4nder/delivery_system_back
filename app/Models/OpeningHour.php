<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    use HasFactory;

    protected $table = 'establishment_opening_hours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'start_time', 'end_time', 'day'
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
}
