<?php


use PF\BowlingGame;

class BowlingGameTest extends \PHPUnit\Framework\TestCase
{

    public function testGetScore_withAllZeros_getZeroScore()
    {
        // set up
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(0, $score);
    }

    public function testGetScore_withAllOnes_get20asScore()
    {
        // set up
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(20, $score);
    }

    public function testGetScore_withASpare_returnScoreWithSpareBonus()
    {
        // set up
        $game = new BowlingGame();

        $game->roll(2);
        $game->roll(8);
        $game->roll(5);

        // 2 + 8 + 5 (spare bonus) + 5 + 17
        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(37, $score);
    }

    public function testGetScore_withAStrike_addStrikeBonus()
    {
        // set up
        $game = new BowlingGame();

        $game->roll(10);
        $game->roll(5);
        $game->roll(3);

        // 10 + 5 (bonus) + 3 (bonus) + 5 + 3 + 16
        for ($i = 0; $i < 16; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(42, $score);
    }

    public function testGetScore_withPerfectGame_returns300()
    {
        // set up
        $game = new BowlingGame();

        for ($i = 0; $i < 12; $i++) {
            $game->roll(10);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(300, $score);
    }

    public function testRoll_withScoreOver10_throwsException()
    {
        self::expectException(Exception::class);

        // set up
        $game = new BowlingGame();

        $game->roll(11);
    }

    public function testRoll_withNegativeScore_throwsException()
    {
        self::expectException(Exception::class);

        // set up
        $game = new BowlingGame();

        $game->roll(-2);
    }

    public function testGetScore_withOver10InTwoRolls_throwsException()
    {
        self::expectException(Exception::class);

        // set up
        $game = new BowlingGame();

        $game->roll(5);
        $game->roll(6);

        for ($i = 0; $i < 18; $i++) {
            $game->roll(1);
        }

        $game->getScore();
    }
}