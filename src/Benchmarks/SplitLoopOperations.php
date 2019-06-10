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
    public function firstForLoop(): void
    {
        for($i = 0; $i < 100; $i++) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     */
    public function secondForLoop(): void
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
    public function firstForeachLoop(): void
    {
        foreach(range(1, 100) as $i) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     */
    public function secondForeachLoop(): void
    {
        foreach(range(1, 100) as $i) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
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
        $this->firstForLoop();
        $this->secondForLoop();
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
        $this->firstForeachLoop();
        $this->secondForeachLoop();
    }
}
