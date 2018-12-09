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
     * ArrayMaxIndex constructor.
     *
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
    protected function makeAssociativeArray(int $length)
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
     * @benchmarkGroup smallNumericArray
     */
    public function benchmarkForeachLoopSmallNumericArray()
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
     * @benchmarkGroup smallNumericArray
     */
    public function benchmarkForLoopSmallNumericArray()
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
     * @benchmarkGroup smallNumericArray
     */
    public function benchmarkArray_flipSmallNumericArray()
    {
        $array = $this->smallNumericArray;
        $maxKey = array_flip($array)[max($array)];
    }

    /**
     * @benchmarkGroup largeNumericArray
     */
    public function benchmarkForeachLoopLargeNumericArray()
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
     * @benchmarkGroup largeNumericArray
     */
    public function benchmarkForLoopLargeNumericArray()
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
     * @benchmarkGroup largeNumericArray
     */
    public function benchmarkArray_flipLargeNumericArray()
    {
        $maxKey = array_flip($this->largeNumericArray)[max($this->largeNumericArray)];
    }

    /**
     * @benchmarkGroup smallAssociativeArray
     */
    public function benchmarkForeachLoopSmallAssociativeArray()
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
     * @benchmarkGroup smallAssociativeArray
     */
    public function benchmarkArray_flipSmallAssociativeArray()
    {
        $maxKey = array_flip($this->smallAssociativeArray)[max($this->smallAssociativeArray)];
    }

    /**
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
     * @benchmarkGroup largeAssociativeArray
     */
    public function benchmarkArray_flipLargeAssociativeArray()
    {
        $maxKey = array_flip($this->largeAssociativeArray)[max($this->largeAssociativeArray)];
    }
}