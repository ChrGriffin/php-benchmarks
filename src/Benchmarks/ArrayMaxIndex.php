<?php

namespace ChrGriffin\PHPBenchmarks\Benchmarks;

class ArrayMaxIndex
{
    /**
     * @var array
     */
    protected $smallNumericArray = [];

    /**
     * @var array
     */
    protected $largeNumericArray = [];

    /**
     * @var array
     */
    protected $smallAssociativeArray = [];

    /**
     * @var array
     */
    protected $largeAssociativeArray = [];

    /**
     * @return void
     */
    public function __construct()
    {
        $this->smallNumericArray = range(0, 100);
        $this->largeNumericArray = range(0, 10000);
        $this->smallAssociativeArray = $this->makeAssociativeArray(100);
        $this->largeAssociativeArray = $this->makeAssociativeArray(10000);
    }

    /**
     * Create an associative array of the specified length.
     *
     * @param int $length
     * @return array
     */
    protected function makeAssociativeArray(int $length): array
    {
        $char = 'a';
        $array = [];

        for($i = 0; $i < $length; $i++) {
            $array[$char] = $i;
            $char++;
        }

        return $array;
    }

    /**
     * @return void
     * @benchmarkGroup smallNumericArray
     */
    public function benchmarkForeachLoopSmallNumericArray(): void
    {
        $array = $this->smallNumericArray;
        $max = 0;
        $maxKey = null;
        foreach($array as $k => $v) {
            if($v > $max) {
                $max = $v;
                $maxKey = $k;
            }
        }
    }

    /**
     * @return void
     * @benchmarkGroup smallNumericArray
     */
    public function benchmarkForLoopSmallNumericArray(): void
    {
        $array = $this->smallNumericArray;
        $max = 0;
        $maxKey = null;
        for($i = 0; $i < count($array); $i++) {
            if($array[$i] > $max) {
                $max = $array[$i];
                $maxKey = $i;
            }
        }
    }

    /**
     * @return void
     * @benchmarkGroup smallNumericArray
     */
    public function benchmarkArray_flipSmallNumericArray(): void
    {
        $array = $this->smallNumericArray;
        $maxKey = array_flip($array)[max($array)];
    }

    /**
     * @return void
     * @benchmarkGroup largeNumericArray
     */
    public function benchmarkForeachLoopLargeNumericArray(): void
    {
        $max = 0;
        $maxKey = null;
        foreach($this->largeNumericArray as $k => $v) {
            if($v > $max) {
                $max = $v;
                $maxKey = $k;
            }
        }
    }

    /**
     * @return void
     * @benchmarkGroup largeNumericArray
     */
    public function benchmarkForLoopLargeNumericArray(): void
    {
        $max = 0;
        $maxKey = null;
        for($i = 0; $i < count($this->largeNumericArray); $i++) {
            if($this->largeNumericArray[$i] > $max) {
                $max = $this->largeNumericArray[$i];
                $maxKey = $i;
            }
        }
    }

    /**
     * @return void
     * @benchmarkGroup largeNumericArray
     */
    public function benchmarkArray_flipLargeNumericArray(): void
    {
        $maxKey = array_flip($this->largeNumericArray)[max($this->largeNumericArray)];
    }

    /**
     * @return void
     * @benchmarkGroup smallAssociativeArray
     */
    public function benchmarkForeachLoopSmallAssociativeArray(): void
    {
        $max = 0;
        $maxKey = null;
        foreach($this->smallAssociativeArray as $k => $v) {
            if($v > $max) {
                $max = $v;
                $maxKey = $k;
            }
        }
    }

    /**
     * @return void
     * @benchmarkGroup smallAssociativeArray
     */
    public function benchmarkArray_flipSmallAssociativeArray(): void
    {
        $maxKey = array_flip($this->smallAssociativeArray)[max($this->smallAssociativeArray)];
    }

    /**
     * @return void
     * @benchmarkGroup largeAssociativeArray
     */
    public function benchmarkForeachLoopLargeAssociativeArray()
    {
        $max = 0;
        $maxKey = null;
        foreach($this->largeAssociativeArray as $k => $v) {
            if($v > $max) {
                $max = $v;
                $maxKey = $k;
            }
        }
    }

    /**
     * @return void
     * @benchmarkGroup largeAssociativeArray
     */
    public function benchmarkArray_flipLargeAssociativeArray(): void
    {
        $maxKey = array_flip($this->largeAssociativeArray)[max($this->largeAssociativeArray)];
    }
}
