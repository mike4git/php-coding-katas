<?php declare(strict_types=1);

namespace Kata\Tests;

use Kata\FourInARow;
use PHPUnit\Framework\TestCase;

class FourInARowTest extends TestCase {
    /**
     * @var FourInARow
     */
    private $game;

    protected function setUp(): void
    {
        $this->game = new FourInARow();
    }

    /**
     * @test
     */
    public function gameStart(): void
    {
        self::assertSame("Spieler 1 ist an der Reihe.", $this->game->status());
    }

    /**
     * @test
     */
    public function changePlayer(): void
    {
        $this->game->makeDraw(1);
        self::assertSame("Spieler 2 ist an der Reihe.", $this->game->status());
        $this->game->makeDraw(1);
        self::assertSame("Spieler 1 ist an der Reihe.", $this->game->status());
    }

    /**
     * @test
     */
    public function fullColumn(): void
    {
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);

        self::assertSame("Spieler 1 ist an der Reihe.", $this->game->status());
    }

    /**
     * @test
     */
    public function multipleColumns(): void
    {
        $this->game->makeDraw(1);
        // up to 7 columns
        $this->game->makeDraw(rand(2, 7));
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);
        $this->game->makeDraw(1);

        self::assertSame("Spieler 2 ist an der Reihe.", $this->game->status());
    }

    /**
     * @test
     */
    public function verticalWin(): void
    {
        $this->game->makeDraw(1);
        $this->game->makeDraw(2);
        $this->game->makeDraw(1);
        $this->game->makeDraw(2);
        $this->game->makeDraw(1);
        $this->game->makeDraw(2);
        $this->game->makeDraw(1);
        self::assertSame("Spieler 1 hat gewonnen.", $this->game->status());
    }


}
