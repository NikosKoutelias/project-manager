<?php

namespace App\Models\SubDomains;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasUlids, HasFactory;

    protected $table = 'projects';
    protected $fillable = ['name', 'description'];
}
