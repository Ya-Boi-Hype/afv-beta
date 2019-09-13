<?php

namespace App\Models;

use App\Events\UserApproved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\AfvApiController;

class Approval extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['approved_at' => 'timestamp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setAsAvailable()
    {
        $this->available_for_next_event = true;
        $this->save();
    }

    public function resetAvailability()
    {
        $this->available_for_next_event = null;
        $this->save();
    }

    public function approve($impersonate = true)
    {
        if ($this->banned) {
            throw new \Exception('User is banned from the beta');
        }
        $data = ['Username' => (string) $this->user_id, 'Enabled' => true];
        AfvApiController::doPUT('users/enabled', [$data], $impersonate); // Throws Exception if fails

        $this->approved_at = now();
        $this->save();

        event(new UserApproved($this));

        return $this;
    }

    public function revoke($impersonate = true)
    {
        $data = ['Username' => (string) $this->user_id, 'Enabled' => false];
        AfvApiController::doPUT('users/enabled', [$data], $impersonate); // Throws Exception if fails

        $this->approved_at = null;
        $this->save();

        return $this;
    }

    public function getApprovedAttribute()
    {
        return (bool) $this->approved_at;
    }

    public function getAvailableAttribute()
    {
        return (bool) ! is_null($this->available_for_next_event);
    }

    public function getBannedAttribute()
    {
        return (bool) ! is_null($this->banned_on);
    }

    public function scopeApproved(Builder $query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopePending(Builder $query)
    {
        return $query->whereNull('approved_at')
                     ->whereNull('banned_on'); // Prevents banned people from being approved
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->where('available_for_next_event', true)
                     ->whereNull('banned_on'); // Prevents banned people from being approved
    }
}
