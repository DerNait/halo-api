<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMatch extends Model
{
    protected $table = 'league_matches';
    public $timestamps = false;

    protected $appends = [
        'homeTeam',
        'awayTeam',
        'matchDate'
    ];

    protected $hidden = [
        'home_team',
        'away_team',
        'match_date'
    ];

    public function getHomeTeamAttribute()
    {
        return $this->attributes['home_team'];
    }

    public function getAwayTeamAttribute()
    {
        return $this->attributes['away_team'];
    }

    public function getMatchDateAttribute()
    {
        return $this->attributes['match_date'];
    }
}