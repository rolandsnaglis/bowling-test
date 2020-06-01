<?php


namespace PF;


use Exception;

class BowlingGame
{
    public array $rolls = [];

    public function roll(int $points): void
    {
        $this->validateRoll($points);

        $this->rolls[] = $points;
    }

    public function getScore(): int
    {
        $score = 0;
        $roll = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($roll)) {
                $score += $this->getPointsForStrike($roll);
                $roll++;

                continue;
            }

            if ($this->isSpare($roll)) {
                $score += $this->getSpareBonus($roll);
            }

            $score += $this->getNormalScore($roll);
            $roll += 2;
        }

        return $score;
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getNormalScore(int $roll): int
    {
        $normalScore = $this->rolls[$roll] + $this->rolls[$roll + 1];

        if ($normalScore > 10) {
            throw new Exception('You cannot roll more than 10 points in one frame!');
        }

        return $normalScore;
    }

    /**
     * @param int $roll
     * @return int
     */
    public function isSpare(int $roll): int
    {
        return $this->getNormalScore($roll) === 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    public function getSpareBonus(int $roll): int
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] === 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    public function getPointsForStrike(int $roll): int
    {
        return 10 + $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

    /**
     * @param int $points
     * @return void
     */
    public function validateRoll(int $points): void
    {
        if ($points > 10) {
            throw new Exception('You cannot roll more than 10 points!');
        }

        if ($points < 0) {
            throw new Exception('Points cannot be a negative number!');
        }
    }
}