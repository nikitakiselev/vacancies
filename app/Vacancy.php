<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use Searchable;

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
