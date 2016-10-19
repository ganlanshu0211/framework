<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-18 15:31
 */
namespace Notadd\Foundation\Database\Commands;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Database\Migrations\Migrator;
use Notadd\Foundation\Database\Traits\MigrationPath;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class ResetCommand
 * @package Notadd\Foundation\Database\Commands
 */
class ResetCommand extends Command {
    use MigrationPath;
    /**
     * @var \Notadd\Foundation\Database\Migrations\Migrator
     */
    protected $migrator;
    /**
     * RollbackCommand constructor.
     * @param \Notadd\Foundation\Database\Migrations\Migrator $migrator
     */
    public function __construct(Migrator $migrator) {
        parent::__construct();
        $this->migrator = $migrator;
    }
    /**
     * @return void
     */
    protected function configure() {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.');
        $this->addOption('force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.');
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'The path of migrations files to be executed.');
        $this->addOption('pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.');
        $this->setDescription('Rollback all database migrations');
        $this->setName('migrate:reset');
    }
    /**
     * @return mixed
     */
    protected function fire() {
        $this->migrator->setConnection($this->input->getOption('database'));
        if(!$this->migrator->repositoryExists()) {
            return $this->error('Migration table not found.');
        }
        $this->migrator->reset($this->getMigrationPath(), $this->input->getOption('pretend'));
        foreach($this->migrator->getNotes() as $note) {
            $this->info($note);
        }
        return true;
    }
}