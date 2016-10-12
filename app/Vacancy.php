<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'url',
        'title',
        'company',
        'experience',
        'description',
        'employment_mode',
    ];

    /**
     * Make id non incremental
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Area of the vacancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
