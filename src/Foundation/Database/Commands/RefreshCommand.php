<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-18 15:27
 */
namespace Notadd\Foundation\Database\Commands;
use Notadd\Foundation\Console\Abstracts\Command;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class RefreshCommand
 * @package Notadd\Foundation\Database\Commands
 */
class RefreshCommand extends Command {
    /**
     * @return void
     */
    protected function configure() {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.');
        $this->addOption('force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.');
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'The path of migrations files to be executed.');
        $this->addOption('seed', null, InputOption::VALUE_NONE, 'Indicates if the seed task should be re-run.');
        $this->addOption('seeder', null, InputOption::VALUE_OPTIONAL, 'The class name of the root seeder.');
        $this->addOption('step', null, InputOption::VALUE_OPTIONAL, 'The number of migrations to be reverted & re-run.');
        $this->setDescription('Reset and re-run all migrations');
        $this->setName('migrate:refresh');
    }
    /**
     * @return void
     */
    protected function fire() {
        $database = $this->input->getOption('database');
        $force = $this->input->getOption('force');
        $path = $this->input->getOption('path');
        $step = $this->input->getOption('step') ?: 0;
        if($step > 0) {
            $this->call('migrate:rollback', [
                '--database' => $database,
                '--force' => $force,
                '--path' => $path,
                '--step' => $step,
            ]);
        } else {
            $this->call('migrate:reset', [
                '--database' => $database,
                '--force' => $force,
                '--path' => $path,
            ]);
        }
        $this->call('migrate', [
            '--database' => $database,
            '--force' => $force,
            '--path' => $path,
        ]);
        if($this->needsSeeding()) {
            $this->runSeeder($database);
        }
    }
    /**
     * @return bool
     */
    protected function needsSeeding() {
        return $this->input->getOption('seed') || $this->input->getOption('seeder');
    }
    /**
     * @param $database
     */
    protected function runSeeder($database) {
        $class = $this->input->getOption('seeder') ?: 'DatabaseSeeder';
        $force = $this->input->getOption('force');
        $this->call('db:seed', [
            '--database' => $database,
            '--class' => $class,
            '--force' => $force,
        ]);
    }
}