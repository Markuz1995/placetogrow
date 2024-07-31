<?php

namespace App\Domains\PaymentRecord\Models;


use App\Domains\Microsite\Models\Microsite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'microsite_id',
        'type',
        'reference',
        'amount',
        'due_date',
    ];

    public function microsite()
    {
        return $this->belongsTo(Microsite::class);
    }
}
