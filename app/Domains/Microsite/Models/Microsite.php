<?php

namespace App\Domains\Microsite\Models;

use App\Domains\Category\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Microsite extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'category_id', 'currency', 'payment_expiration', 'type',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
