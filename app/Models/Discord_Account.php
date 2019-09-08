<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discord_Account extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function display_name()
    {
    }

    public function getMode1Attribute() // Name Surname - CID
    {
        return mb_convert_case(mb_strtolower($this->user->full_name.' - '.$this->user->id), MB_CASE_TITLE, 'UTF-8');
    }

    public function getMode2Attribute() // Name - CID
    {
        return mb_convert_case(mb_strtolower($this->user->name_first.' - '.$this->user->id), MB_CASE_TITLE, 'UTF-8');
    }

    public function getMode3Attribute() // CID
    {
        return (string) $this->user->id;
    }
}
