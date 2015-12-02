<?php

namespace App\Console\Commands;

use Log;
use Lang;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\LockHandler;
use App\Console\ReturnCode as ConsoleReturnCode;

class BaseCommand extends Command
{
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
        ini_set('memory_limit', '512M');

        $lock = null;
        if ($this->isSingle) {
            $lock = $this->getLockHandler();
            if (!$lock->lock()) {
//                $output->writeln('The command is already running in another process.');
                Log::info(Lang::get('console.already'));
                return ConsoleReturnCode::SUCCESS;
            }
        }

        $returnCode = parent::run($input, $output);

        if ($returnCode === ConsoleReturnCode::SUCCESS) {
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
