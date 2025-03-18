<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = ['name', 'description'];
}
