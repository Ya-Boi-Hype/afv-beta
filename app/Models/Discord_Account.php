<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discord_Account extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'id', 'mode', 'nickname'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNameAttribute()
    {
        return mb_convert_case(mb_strtolower($this->user->full_name.' - '.$this->user->id), MB_CASE_TITLE, 'UTF-8');
        /*switch($this->mode)
        {
            case 0: return $this->mode0;
            case 1: return $this->mode1;
            case 2: return $this->mode2;
            default: return $this->mode0;
        }*/
    }

    /*public function getMode0Attribute() // Name Surname - CID
    {
        return mb_convert_case(mb_strtolower($this->user->full_name.' - '.$this->user->id), MB_CASE_TITLE, 'UTF-8');
    }
    
    public function getMode1Attribute() // Name - CID
    {
        return mb_convert_case(mb_strtolower($this->user->name_first.' - '.$this->user->id), MB_CASE_TITLE, 'UTF-8');
    }
    
    public function getMode2Attribute() // CID
    {
        return (string) $this->user->id;
    }*/
}
