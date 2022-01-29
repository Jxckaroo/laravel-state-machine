<?php

namespace Jxckaroo\StateMachine\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class State extends Model
{
    /**
     * Constants
     */
    public const PREVIOUS_STATE = 0;
    public const NEXT_STATE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'model_type',
        'model_id'
    ];

    /**
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return array
     */
    public function getRulesAttribute(): array
    {
        try {
            return collect($this->model()->first()->states())
                ->filter(fn ($item, $key) => $key == $this->name)
                ->values()
                ->toArray();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * @return MorphMany
     */
    public function history(): MorphMany
    {
        return $this->morphMany(StateHistory::class, 'model');
    }
}
