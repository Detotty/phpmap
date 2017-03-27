<?php

namespace App\Traits;

use App\Models\Users\Leaderboard;
use App\Repositories\LeaderboardRepository;

trait Boardable
{
    /**
     * @param $points
     */
    public function reward($points)
    {
        return $this->leaderboard()->reward($points);
    }

    /**
     * @param $points
     */
    public function penalize($points)
    {
        return $this->leaderboard()->penalize($points);
    }

    /**
     * @param $multiplier
     */
    public function multiply($multiplier)
    {
        return $this->leaderboard()->multiply($multiplier);
    }

    /**
     * @param $points
     *
     * @throws \App\Exceptions\InsufficientFundsException
     *
     * @return bool
     */
    public function redeem($points)
    {
        return $this->leaderboard()->redeem($points);
    }

    public function blacklist()
    {
        return $this->leaderboard()->blacklist();
    }

    public function whitelist()
    {
        return $this->leaderboard()->whitelist();
    }

    public function reset()
    {
        return $this->leaderboard()->reset();
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->board->points;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->board->rank;
    }

    /**
     * @return mixed
     */
    public function isBlacklisted()
    {
        return $this->board->blacklisted;
    }

    /**
     * @return mixed
     */
    public function board()
    {
        return $this->morphOne(Leaderboard::class, 'boardable');
    }

    /**
     * @return EloquentBoardRepository
     */
    protected function leaderboard()
    {
        return new LeaderboardRepository($this);
    }
}
