<?php

namespace ChrGriffin\PHPBenchmarks;

use ChrGriffin\PHPBenchmarks\Benchmarks\ArrayMaxIndex;
use ChrGriffin\PHPBenchmarks\Exceptions\BenchmarkNotFoundException;
use phpDocumentor\Reflection\DocBlockFactory;
use Ubench;

class Benchmarker
{
    /**
     * @var int
     */
    protected $benchmarkLoops = 1000000;

    /**
     * @var DocBlockFactory
     */
    protected $docBlocker;

    /**
     * @var Ubench
     */
    protected $benchmarker;

    /**
     * @var array
     */
    protected $benchmarkClasses = [];

    /**
     * @var array
     */
    protected $benchmarkGroups = [];

    /**
     * @return array
     */
    public function getBenchmarkGroups(): array
    {
        return $this->benchmarkGroups;
    }

    /**
     * @return void
     */
    public function __construct()
    {
        $this->benchmarker = new Ubench;
        $this->docBlocker = DocBlockFactory::createInstance();
    }

    /**
     * @param string $class
     * @return Benchmarker
     * @throws BenchmarkNotFoundException
     */
    public function addBenchmark(string $class): Benchmarker
    {
        if(!class_exists($class)) {
            throw new BenchmarkNotFoundException('Class ' . $class . ' does not exist.');
        }

        $this->benchmarkClasses[] = $class;
        return $this;
    }

    /**
     * @return void
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function runBenchmarks(): void
    {
        $this->mapBenchmarkMethods();
        $this->benchmarkClasses();
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function mapBenchmarkMethods(): void
    {
        foreach($this->benchmarkClasses as $class) {

            $reflector = new \ReflectionClass($class);
            foreach($reflector->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $docBlock = $this->docBlocker->create(
                    $reflector->getMethod($method->name)->getDocComment()
                );

                if(
                    !$docBlock->hasTag('benchmarkGroup')
                    || substr($method->name, 0, 9) !== 'benchmark'
                ) {
                    continue;
                }

                foreach($docBlock->getTagsByName('benchmarkGroup') as $benchmarkGroup) {

                    $readable = trim(strtolower(
                        implode(
                            ' ',
                            preg_split(
                                '/(?=[A-Z])/',
                                preg_replace(
                                    '/' . ucfirst($benchmarkGroup) . '/',
                                    '',
                                    substr($method->name,9)
                                )
                            )
                        )
                    ));

                    $this->benchmarkGroups
                        [$class]
                        [$benchmarkGroup->getDescription()->render()]
                        [] = [
                            'method' => $method->name,
                            'readable' => $readable,
                            'time' => null,
                        ];
                }
            }
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function benchmarkClasses(): void
    {
        foreach($this->benchmarkGroups as $benchmarkClass => $benchmarkGroups) {

            $class = (new $benchmarkClass);
            foreach($benchmarkGroups as $group => $methods) {

                foreach($methods as $method => $methodDetails) {

                    $this->benchmarker->start();
                    for($i = 0; $i < $this->benchmarkLoops; $i++) {
                        $class->{$methodDetails['method']}();
                    }
                    $this->benchmarker->end();

                    $this->benchmarkGroups
                        [$benchmarkClass]
                        [$group]
                        [$method]
                        ['time'] = $this->benchmarker->getTime(true);
                }
            }
        }
    }
}
