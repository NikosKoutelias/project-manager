<?php

namespace App\Models\Domain;

use App\Casts\CountryOfOperationCast;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = ['name', 'description', 'country_of_operation'];

    protected function casts(): array
    {
        return [
            'country_of_operation' => CountryOfOperationCast::class,
        ];
    }
}
