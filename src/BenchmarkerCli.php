<?php

namespace ChrGriffin\PHPBenchmarks;

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

class BenchmarkerCli extends CLI
{
    /**
     * @const string
     */
    const CLI_INDENT = '  ';

    /**
     * @var Benchmarker
     */
    protected $benchmarker;

    /**
     * @inheritdoc
     */
    public function __construct(bool $autocatch = true)
    {
        parent::__construct($autocatch);
        $this->benchmarker = new Benchmarker();
    }

    /**
     * @inheritdoc
     */
    protected function setup(Options $options)
    {
        $options->setHelp('Runs a specified PHP benchmark.');
        $options->registerOption('version', 'Print version.', 'v');

        $options->registerCommand('benchmark', 'Benchmark a list of files.');
        $options->registerArgument(
            'classes',
            'A comma-separated list of fully-qualified class names to benchmark.',
            true,
            'benchmark'
        );

        $options->registerOption(
            'bootstrap',
            'Path to a bootstrapper or autoloader to include external benchmark classes, if desired.',
            'b',
            null,
            'benchmark'
        );
    }

    /**
     * @inheritdoc
     * @throws Exceptions\BenchmarkNotFoundException
     * @throws \ReflectionException
     */
    public function main(Options $options)
    {
        if($options->getOpt('version')) {
            $this->info('1.0.0');
            return;
        }

        if($options->getOpt('bootstrap')) {
            require_once $options->getOpt('bootstrap');
        }

        $classes = explode(',', $options->getArgs()[0]);
        foreach($classes as $class) {
            $this->benchmarker->addBenchmark($class);
        }
        $this->benchmarker->runBenchmarks();

        $this->printResults();
    }

    /**
     * Print benchmark results to the console.
     *
     * @return void
     */
    protected function printResults()
    {
        foreach($this->benchmarker->getBenchmarkGroups() as $class => $groups) {

            $this->print("\n");
            $this->print($class . ':', null);
            $this->print("\n");

            foreach($groups as $group => $methods) {

                $this->print($group . ':', null, 1);
                foreach($methods as $method) {
                    $this->print(
                        $method['readable']
                        . ': '
                        . $this->colors->wrap($method['time'], 'green'),
                        null,
                        2
                    );
                }

                $this->print("\n");
            }

            $this->print("\n");
        }
    }

    /**
     * Print a line to the console.
     *
     * @param $string
     * @param null|string $color
     * @param int $indent
     * @return void
     */
    protected function print(string $string, ?string $color = null, int $indent = 0)
    {
        if($indent > 0) {
            for($i = 0; $i < $indent; $i++) {
                $string = self::CLI_INDENT . $string;
            }
        }

        if($color) {
            $string = $this->colors->wrap($string, $color);
        }

        echo "$string\n";
    }
}