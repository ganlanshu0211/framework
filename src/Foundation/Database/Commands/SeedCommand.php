<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-19 11:37
 */
namespace Notadd\Foundation\Database\Commands;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Eloquent\Model;
use Notadd\Foundation\Console\Abstracts\Command;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class SeedCommand
 * @package Notadd\Foundation\Database\Commands
 */
class SeedCommand extends Command {
    /**
     * @var \Illuminate\Database\ConnectionResolverInterface
     */
    protected $resolver;
    /**
     * SeedCommand constructor.
     * @param \Illuminate\Database\ConnectionResolverInterface $resolver
     */
    public function __construct(ConnectionResolverInterface $resolver) {
        parent::__construct();
        $this->resolver = $resolver;
    }
    /**
     * @return void
     */
    protected function configure() {
        $this->addOption('class', null, InputOption::VALUE_OPTIONAL, 'The class name of the root seeder', 'DatabaseSeeder');
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed');
        $this->addOption('force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.');
        $this->setDescription('Seed the database with records');
        $this->setName('db:seed');
    }
    /**
     * @return void
     */
    protected function fire() {
        $this->resolver->setDefaultConnection($this->getDatabase());
        Model::unguarded(function () {
            $this->getSeeder()->run();
        });
        $this->output->writeln("<info>Seeded:</info> {$this->input->getOption('class')}");
    }
    /**
     * @return string
     */
    protected function getDatabase() {
        $database = $this->input->getOption('database');
        return $database ?: $this->container->make('config')->get('database.default');
    }
    /**
     * @return \Illuminate\Database\Seeder
     */
    protected function getSeeder() {
        $class = $this->container->make($this->input->getOption('class'));
        return $class->setContainer($this->container)->setCommand($this);
    }
}