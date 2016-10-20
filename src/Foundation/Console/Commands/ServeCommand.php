<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 10:49
 */
namespace Notadd\Foundation\Console\Commands;
use Notadd\Foundation\Console\Abstracts\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\ProcessUtils;
/**
 * Class ServeCommand
 * @package Notadd\Foundation\Console\Commands
 */
class ServeCommand extends Command {
    /**
     * @return void
     */
    public function configure() {
        $this->addOption('host', null, InputOption::VALUE_OPTIONAL, 'The host address to serve the application on.', 'localhost');
        $this->addOption('port', null, InputOption::VALUE_OPTIONAL, 'The port to serve the application on.', 8000);
        $this->setDescription('Serve the application on the PHP development server');
        $this->setName('serve');
    }
    /**
     * @return void
     */
    public function fire() {
        chdir($this->container->publicPath());
        $host = $this->input->getOption('host');
        $port = $this->input->getOption('port');
        $base = ProcessUtils::escapeArgument($this->container->basePath());
        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));
        $this->info("Laravel development server started on http://{$host}:{$port}/");
        passthru("{$binary} -S {$host}:{$port} {$base}/server.php");
    }
}