<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\AfvApiController;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Allow all attributes to be mass assigned.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function approval()
    {
        return $this->hasOne(Approval::class);
    }

    public function getHasRequestAttribute()
    {
        return ! is_null($this->approval);
    }

    public function getFullNameAttribute()
    {
        try {
            return $this->name_first.' '.$this->name_last;
        } catch (Exception $e) {
            return 'Unknown';
        }
    }

    public function getApprovedAttribute()
    {
        return (bool) optional($this->approval()->first())->approved;
    }

    public function getPendingAttribute()
    {
        return (bool) $this->has_request && ! $this->approved;
    }

    public function getPermissionsAttribute()
    {
        try {
            return Cache::rememberForever('permissions'.$this->id, function () {
                Log::info('AFV API Request - User Permissions');

                return AfvApiController::getPermissions($this->id);
            });
        } catch (\Exception $e) {
            Log::warn('AFV API Request - User Permissions failed');

            return [];
        }
    }

    public function scopePending(Builder $query)
    {
        return $query->whereDoesntHave('approval')->orWhereHas('approval', function (Builder $query2) {
            $query2->whereNull('approved_at');
        });
    }

    public function scopeApproved(Builder $query)
    {
        return $query->whereHas('approval', function (Builder $query2) {
            $query2->whereNotNull('approved_at');
        });
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->whereHas('approval', function (Builder $query2) {
            $query2->where('available_for_next_event', true);
        });
    }
}
