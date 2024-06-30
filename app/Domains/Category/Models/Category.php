<?php

namespace App\Domains\Category\Models;

use App\Domains\Microsite\Models\Microsite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function microsites()
    {
        return $this->hasMany(Microsite::class);
    }
}
