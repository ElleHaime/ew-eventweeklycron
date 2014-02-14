<?php
/**
 * @namespace
 */
namespace Cron\Job\Test;

use CronManager\Manager\Executable;

/**
 * Class Test
 * @package Cron\Job\Test
 */
class Test extends Executable
{	
	public function process1()
	{
		for($i = 0; !$this->isTerminated() && $i < 10; $i++) {
			ob_start();
			echo "Test(one) message: ".$i . "\n";
			ob_end_flush();
			sleep(1);
		}
	}

    public function process2()
    {
        for($i = 0; !$this->isTerminated() && $i < 20; $i++) {
            ob_start();
            echo "Test(two) message: ".$i . "\n";
            ob_end_flush();
            sleep(1);
        }
    }

    public function process3()
    {
        for($i = 0; !$this->isTerminated() && $i < 30; $i++) {
            ob_start();
            echo "Test(three) message: ".$i . "\n";
            ob_end_flush();
            sleep(1);
        }
    }
}

