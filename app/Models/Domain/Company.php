<?php

namespace App\Models\Domain;

use App\Casts\CountryOfOperationCast;
use App\Models\SubDomains\Project;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasUlids, HasFactory;

    protected $table = 'companies';
    protected $fillable = ['name', 'description', 'country_of_operation'];

    public function projects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'projects');
    }

    protected function casts(): array
    {
        return [
            'country_of_operation' => CountryOfOperationCast::class,
        ];
    }
}
