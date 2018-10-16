<?php

namespace Humanity\Entities\Vacation\Models;

use Illuminate\Database\Eloquent\Model;

class VacationDate extends Model
{
    const TABLE = 'vacation_dates';

    const ID = 'id';
    const VACATION_ID = 'vacation_id';
    const DATE = 'date';

    public $timestamps = false;

    protected $fillable = [
        self::ID,
        self::VACATION_ID,
        self::DATE
    ];

    /**
     * Dates for vacation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vacation()
    {
        return $this->belongsTo(Vacation::class, self::VACATION_ID, Vacation::ID);
    }
}
