<?php

namespace Humanity\Entities\Vacation\Models;

use Humanity\Entities\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    const TABLE = 'vacations';

    const ID = 'id';
    const NAME = 'name';
    const USER_ID = 'user_id';
    const APPROVED = 'approved';

    public $timestamps = false;

    protected $fillable = [
        self::ID,
        self::NAME,
        self::USER_ID,
        self::APPROVED
    ];

    /**
     * Dates for vacation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dates()
    {
        return $this->hasMany(VacationDate::class, VacationDate::VACATION_ID, Vacation::ID);
    }

    /**
     * Dates for vacation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, self::USER_ID, User::ID);
    }
}
