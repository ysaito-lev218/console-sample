<?php

namespace App\Console\Commands;

use Log;
use Lang;
use Illuminate\Console\Command as LaravelCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\LockHandler;

class Command extends LaravelCommand
{
    /**
     * 正常
     */
    const SUCCESS = 0;

    /**
     * 致命的なエラー
     */
    const FATAL_ERROR = 1;

    /**
     * The console single process.
     *
     * @var bool
     */
    protected $isSingle = true;

    /**
     * The lock file name.
     *
     * @var string
     */
    protected $lockName = '';

    /**
     * The lock file path.
     *
     * @var string
     */
    protected $lockPath = '/tmp/';

    /**
     * Run the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface    $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     *
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        Log::info(Lang::get('console.start', ['name' => $this->name]));

        // set memory limit.
        ini_set('memory_limit', '1024M');

        $lock = null;
        if ($this->isSingle) {
            $lock = $this->getLockHandler();
            if (!$lock->lock()) {
                Log::info(Lang::get('console.already'));
                return self::SUCCESS;
            }
        }

        $returnCode = parent::run($input, $output);

        if ($returnCode === self::SUCCESS) {
            Log::info(Lang::get('console.success', ['name' => $this->name]));
        } else {
            Log::error(Lang::get('console.fail', ['name' => $this->name]));
        }

        if (isset($lock)) {
            $lock->release();
        }

        return $returnCode;
    }

    /**
     * Get the locking helper.
     *
     * @return LockHandler
     */
    private function getLockHandler()
    {
        return new LockHandler($this->getLockName(), $this->lockPath);
    }

    /**
     * Get the lock name.
     *
     * @return string
     */
    private function getLockName()
    {
        return empty($this->lockName) ? $this->name : $this->lockName;
    }
}
