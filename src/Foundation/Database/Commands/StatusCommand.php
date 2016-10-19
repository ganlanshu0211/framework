<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-18 13:43
 */
namespace Notadd\Foundation\Database\Commands;
use Illuminate\Support\Collection;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Database\Migrations\Migrator;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class StatusCommand
 * @package Notadd\Foundation\Database\Commands
 */
class StatusCommand extends Command {
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
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'The path of migrations files to use.');
        $this->setDescription('Show the status of each migration');
        $this->setName('migrate:status');
    }
    /**
     * @return mixed
     */
    protected function fire() {
        if(!$this->migrator->repositoryExists()) {
            return $this->error('No migrations found.');
        }
        $this->migrator->setConnection($this->input->getOption('database'));
        $ran = $this->migrator->getRepository()->getRan();
        $migrations = Collection::make($this->getAllMigrationFiles())->map(function ($migration) use ($ran) {
            return in_array($this->migrator->getMigrationName($migration), $ran) ? [
                '<info>Y</info>',
                $this->migrator->getMigrationName($migration)
            ] : [
                '<fg=red>N</fg=red>',
                $this->migrator->getMigrationName($migration)
            ];
        });
        if (count($migrations) > 0) {
            return $this->table(['Ran?', 'Migration'], $migrations);
        } else {
            return $this->error('No migrations found');
        }
    }
    /**
     * @return array
     */
    protected function getAllMigrationFiles() {
        return $this->migrator->getMigrationFiles($this->getMigrationPath());
    }
    /**
     * @return string
     */
    protected function getMigrationPath() {
        if(!is_null($targetPath = $this->input->getOption('path'))) {
            return call_user_func([
                $this->container,
                'basePath'
            ]) . '/' . $targetPath;
        }
        return realpath(__DIR__ . '/../../../../resources/migrations');
    }
}