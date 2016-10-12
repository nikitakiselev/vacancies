<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'hh_area_id'];

    /**
     * Vacancies of this area
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }
}
