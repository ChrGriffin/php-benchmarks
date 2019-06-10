<?php

namespace ChrGriffin\PHPBenchmarks\Benchmarks;

class SplitLoopOperations
{
    /**
     * @return void
     */
    public function bothForLoops(): void
    {
        for($i = 0; $i < 100; $i++) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     */
    public function oneForLoop(): void
    {
        for($i = 0; $i < 100; $i++) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     */
    public function bothForeachLoops(): void
    {
        foreach(range(1, 100) as $i) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     */
    public function oneForeachLoop(): void
    {
        foreach(range(1, 100) as $i) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     */
    public function bothArrayMaps(): void
    {
        array_map(function (int $i) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
            return $i;
        }, range(1, 100));
    }

    /**
     * @return void
     */
    public function oneArrayMap(): void
    {
        array_map(function (int $i) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
            return $i;
        }, range(1, 100));
    }

    /**
     * @return void
     * @benchmarkGroup splitForLoopVersusUnifiedForLoop
     */
    public function benchmarkUnifiedForLoop(): void
    {
        $this->bothForLoops();
    }

    /**
     * @return void
     * @benchmarkGroup splitForLoopVersusUnifiedForLoop
     */
    public function benchmarkSplitForLoop(): void
    {
        $this->oneForLoop();
        $this->oneForLoop();
    }

    /**
     * @return void
     * @benchmarkGroup splitForeachLoopVersusUnifiedForeachLoop
     */
    public function benchmarkUnifiedForeachLoop(): void
    {
        $this->bothForeachLoops();
    }

    /**
     * @return void
     * @benchmarkGroup splitForeachLoopVersusUnifiedForeachLoop
     */
    public function benchmarkSplitForeachLoop(): void
    {
        $this->oneForeachLoop();
        $this->oneForeachLoop();
    }

    /**
     * @return void
     * @benchmarkGroup splitArrayMapVersusUnifiedArrayMap
     */
    public function benchmarkUnifiedArrayMap(): void
    {
        $this->bothArrayMaps();
    }

    /**
     * @return void
     * @benchmarkGroup splitArrayMapVersusUnifiedArrayMap
     */
    public function benchmarkSplitArrayMap(): void
    {
        $this->oneArrayMap();
        $this->oneArrayMap();
    }
}
