<?php

namespace ChrGriffin\PHPBenchmarks\Benchmarks;

class SplitLoopOperations
{
    /**
     * @return void
     */
    public function bothLoops(): void
    {
        for($i = 0; $i < 100; $i++) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     */
    public function firstLoop(): void
    {
        for($i = 0; $i < 100; $i++) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     */
    public function secondLoop(): void
    {
        for($i = 0; $i < 100; $i++) {
            $math = (1 * 2 * 3 * 4 * 5 * 6 * 7 * 8 * 9);
        }
    }

    /**
     * @return void
     * @benchmarkGroup splitLoopVersusUnifiedLoop
     */
    public function benchmarkUnifiedLoop(): void
    {
        $this->bothLoops();
    }

    /**
     * @return void
     * @benchmarkGroup splitLoopVersusUnifiedLoop
     */
    public function benchmarkSplitLoop(): void
    {
        $this->firstLoop();
        $this->secondLoop();
    }
}
