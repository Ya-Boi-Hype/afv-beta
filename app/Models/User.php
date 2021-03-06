<?php

namespace App\Models;

use App\Http\Controllers\AfvApiController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

    public function discord()
    {
        return $this->hasOne(Discord_Account::class);
    }

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
                $permissions = AfvApiController::getPermissions($this->id);
                $permissions = array_diff($permissions, [
                    'User Permission Read',
                ]);

                return $permissions;
            });
        } catch (\Exception $e) {
            Log::warn('AFV Permissions Request failed');

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
