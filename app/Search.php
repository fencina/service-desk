<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    public $fillable = [
        'help_desk_id',
        'text'
    ];

    public $timestamps = false;

    public static function store($helpDeskId, $text)
    {
        if ($existentSearch = self::where('help_desk_id', $helpDeskId)->where('text', $text)->first()) {
            $existentSearch->count++;
            $existentSearch->save();
            return;
        }

        self::create([
            'help_desk_id' => $helpDeskId,
            'text' => $text,
        ]);
    }
}
