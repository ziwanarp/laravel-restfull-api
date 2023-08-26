<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['address'];

    public function address()
    {
        return $this->hasMany(Addresses::class);
    }
}
