<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-30 13:58
 */
namespace Notadd\Foundation\Console\Commands;
use ClassPreloader\Exceptions\VisitorExceptionInterface;
use ClassPreloader\Factory;
use Illuminate\Support\Collection;
use Notadd\Foundation\Console\Abstracts\Command;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class OptimizeCommand
 * @package Notadd\Foundation\Console\Commands
 */
class OptimizeCommand extends Command {
    /**
     * @var array
     */
    protected $complies = [
        '/src/Foundation/Abstracts/Server.php',
        '/src/Foundation/Http/Server.php',
        '/vendor/illuminate/contracts/Container/Container.php',
        '/vendor/illuminate/container/Container.php',
        '/vendor/illuminate/contracts/Foundation/Application.php',
        '/src/Foundation/Contracts/Application.php',
        '/src/Foundation/Application.php',
        '/vendor/illuminate/support/ServiceProvider.php',
        '/vendor/illuminate/events/EventServiceProvider.php',
        '/vendor/illuminate/support/Traits/Macroable.php',
        '/vendor/illuminate/support/Arr.php',
        '/vendor/illuminate/contracts/Events/Dispatcher.php',
        '/vendor/illuminate/events/Dispatcher.php',
        '/vendor/illuminate/contracts/Config/Repository.php',
        '/vendor/illuminate/config/Repository.php',
        '/vendor/illuminate/support/Str.php',
        '/vendor/illuminate/contracts/Encryption/Encrypter.php',
        '/vendor/illuminate/encryption/Encrypter.php',
        '/vendor/illuminate/contracts/Hashing/Hasher.php',
        '/vendor/illuminate/hashing/BcryptHasher.php',
        '/vendor/psr/log/Psr/Log/LoggerInterface.php',
        '/vendor/monolog/monolog/src/Monolog/Logger.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/HandlerInterface.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/AbstractHandler.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/AbstractProcessingHandler.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/StreamHandler.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/RotatingFileHandler.php',
        '/vendor/monolog/monolog/src/Monolog/Formatter/FormatterInterface.php',
        '/vendor/monolog/monolog/src/Monolog/Formatter/NormalizerFormatter.php',
        '/vendor/monolog/monolog/src/Monolog/Formatter/LineFormatter.php',
        '/vendor/illuminate/bus/BusServiceProvider.php',
        '/src/Foundation/Auth/AuthServiceProvider.php',
        '/vendor/illuminate/cache/CacheServiceProvider.php',
        '/src/Foundation/Cookie/CookieServiceProvider.php',
        '/vendor/illuminate/database/DatabaseServiceProvider.php',
        '/src/Foundation/Database/DatabaseServiceProvider.php',
        '/vendor/illuminate/contracts/Support/Arrayable.php',
        '/vendor/illuminate/contracts/Support/Jsonable.php',
        '/vendor/illuminate/contracts/Queue/QueueableEntity.php',
        '/vendor/illuminate/contracts/Routing/UrlRoutable.php',
        '/vendor/illuminate/database/Eloquent/Model.php',
        '/vendor/illuminate/filesystem/FilesystemServiceProvider.php',
        '/vendor/illuminate/hashing/HashServiceProvider.php',
        '/vendor/illuminate/mail/MailServiceProvider.php',
        '/src/Foundation/Passport/PassportServiceProvider.php',
        '/src/Passport/PassportServiceProvider.php',
        '/src/Foundation/Auth/Traits/CreatesUserProviders.php',
        '/vendor/illuminate/contracts/Auth/Factory.php',
        '/src/Foundation/Auth/AuthManager.php',
        '/src/Foundation/Routing/RouterServiceProvider.php',
        '/vendor/illuminate/session/SessionServiceProvider.php',
        '/src/Foundation/Session/SessionServiceProvider.php',
        '/vendor/illuminate/validation/ValidationServiceProvider.php',
        '/vendor/illuminate/view/ViewServiceProvider.php',
        '/src/Foundation/Abstracts/ServiceProvider.php',
        '/src/Setting/SettingServiceProvider.php',
        '/src/Foundation/Routing/Router.php',
        '/vendor/illuminate/view/Engines/EngineResolver.php',
        '/vendor/illuminate/view/ViewFinderInterface.php',
        '/vendor/illuminate/view/FileViewFinder.php',
        '/vendor/illuminate/filesystem/Filesystem.php',
        '/vendor/illuminate/contracts/View/Factory.php',
        '/vendor/illuminate/view/Factory.php',
        '/vendor/illuminate/view/Engines/EngineInterface.php',
        '/vendor/illuminate/view/Engines/PhpEngine.php',
        '/vendor/illuminate/view/Engines/CompilerEngine.php',
        '/vendor/illuminate/view/Compilers/Compiler.php',
        '/vendor/illuminate/view/Compilers/CompilerInterface.php',
        '/vendor/illuminate/view/Compilers/BladeCompiler.php',
        '/src/Setting/Contracts/SettingsRepository.php',
        '/src/Setting/MemoryCacheSettingsRepository.php',
        '/src/Setting/DatabaseSettingsRepository.php',
        '/vendor/illuminate/database/ConnectionResolverInterface.php',
        '/vendor/illuminate/database/DatabaseManager.php',
        '/vendor/illuminate/database/Connectors/ConnectionFactory.php',
        '/vendor/illuminate/database/DetectsDeadlocks.php',
        '/vendor/illuminate/database/DetectsLostConnections.php',
        '/vendor/illuminate/database/ConnectionInterface.php',
        '/vendor/illuminate/database/Connection.php',
        '/vendor/illuminate/database/MySqlConnection.php',
        '/vendor/illuminate/database/Grammar.php',
        '/vendor/illuminate/database/Query/Grammars/Grammar.php',
        '/vendor/illuminate/database/Query/Grammars/MySqlGrammar.php',
        '/vendor/illuminate/database/Query/Processors/Processor.php',
        '/vendor/illuminate/database/Query/Processors/MySqlProcessor.php',
        '/vendor/illuminate/database/Query/Builder.php',
        '/vendor/illuminate/database/Connectors/Connector.php',
        '/vendor/illuminate/database/Connectors/ConnectorInterface.php',
        '/vendor/illuminate/database/Connectors/MySqlConnector.php',
        '/vendor/doctrine/dbal/lib/Doctrine/DBAL/Driver/Connection.php',
        '/vendor/doctrine/dbal/lib/Doctrine/DBAL/Driver/ServerInfoAwareConnection.php',
        '/vendor/doctrine/dbal/lib/Doctrine/DBAL/Driver/PDOConnection.php',
        '/vendor/doctrine/dbal/lib/Doctrine/DBAL/Driver/ResultStatement.php',
        '/vendor/doctrine/dbal/lib/Doctrine/DBAL/Driver/Statement.php',
        '/vendor/doctrine/dbal/lib/Doctrine/DBAL/Driver/PDOStatement.php',
        '/vendor/illuminate/database/Events/QueryExecuted.php',
        '/vendor/illuminate/support/Collection.php',
        '/src/Foundation/Http/HttpServiceProvider.php',
        '/src/Admin/AdminServiceProvider.php',
        '/src/Extension/ExtensionServiceProvider.php',
        '/src/Foundation/Console/Abstracts/CommandRegistrar.php',
        '/src/Foundation/Database/Listeners/CommandRegistrar.php',
        '/src/Passport/Listeners/CommandRegistrar.php',
        '/src/Member/MemberServiceProvider.php',
        '/src/Foundation/Abstracts/EventSubscriber.php',
        '/src/Foundation/Routing/Abstracts/RouteRegistrar.php',
        '/src/Foundation/Http/Listeners/RouteRegistrar.php',
        '/src/Admin/Listeners/RouteRegistrar.php',
        '/src/Extension/ExtensionManager.php',
        '/vendor/symfony/finder/Finder.php',
        '/vendor/symfony/finder/Iterator/FilterIterator.php',
        '/vendor/symfony/finder/Iterator/FileTypeFilterIterator.php',
        '/vendor/symfony/finder/Comparator/Comparator.php',
        '/vendor/symfony/finder/Comparator/NumberComparator.php',
        '/vendor/symfony/finder/Iterator/RecursiveDirectoryIterator.php',
        '/vendor/symfony/finder/Iterator/ExcludeDirectoryFilterIterator.php',
        '/vendor/symfony/finder/Iterator/DepthRangeFilterIterator.php',
        '/vendor/symfony/finder/Iterator/MultiplePcreFilterIterator.php',
        '/vendor/symfony/finder/Iterator/PathFilterIterator.php',
        '/vendor/symfony/finder/SplFileInfo.php',
        '/src/Extension/Abstracts/ExtensionRegistrar.php',
        '/src/Extension/Contracts/Extension.php',
        '/src/Member/Listeners/RouteRegistrar.php',
        '/vendor/zendframework/zend-diactoros/src/Server.php',
        '/vendor/zendframework/zend-stratigility/src/MiddlewareInterface.php',
        '/src/Foundation/Http/Pipelines/JsonBodyParser.php',
        '/vendor/zendframework/zend-stratigility/src/Route.php',
        '/src/Foundation/Http/Pipelines/SessionStarter.php',
        '/vendor/illuminate/support/Manager.php',
        '/src/Foundation/Session/SessionManager.php',
        '/src/Foundation/Http/Events/PipelineInjection.php',
        '/src/Foundation/Http/Pipelines/RouteDispatcher.php',
        '/vendor/zendframework/zend-stratigility/src/ErrorMiddlewareInterface.php',
        '/vendor/zendframework/zend-diactoros/src/ServerRequestFactory.php',
        '/vendor/zendframework/zend-diactoros/src/MessageTrait.php',
        '/vendor/zendframework/zend-diactoros/src/RequestTrait.php',
        '/vendor/psr/http-message/src/MessageInterface.php',
        '/vendor/psr/http-message/src/RequestInterface.php',
        '/vendor/psr/http-message/src/UriInterface.php',
        '/vendor/psr/http-message/src/StreamInterface.php',
        '/vendor/zendframework/zend-diactoros/src/Stream.php',
        '/vendor/zendframework/zend-diactoros/src/HeaderSecurity.php',
        '/vendor/psr/http-message/src/ResponseInterface.php',
        '/vendor/psr/http-message/src/ServerRequestInterface.php',
        '/vendor/zendframework/zend-stratigility/src/Http/Request.php',
        '/vendor/zendframework/zend-stratigility/src/Http/ResponseInterface.php',
        '/vendor/zendframework/zend-stratigility/src/FinalHandler.php',
        '/vendor/zendframework/zend-stratigility/src/Next.php',
        '/vendor/zendframework/zend-stratigility/src/Dispatch.php',
        '/vendor/illuminate/session/FileSessionHandler.php',
        '/vendor/symfony/http-foundation/Session/SessionInterface.php',
        '/vendor/illuminate/session/SessionInterface.php',
        '/src/Foundation/Session/Contracts/Session.php',
        '/vendor/symfony/http-foundation/Session/SessionBagInterface.php',
        '/vendor/nesbot/carbon/src/Carbon/Carbon.php',
        '/src/Foundation/Routing/Events/RouteRegister.php',
        '/src/Foundation/Routing/Registrars/ResourceRegistrar.php',
        '/vendor/illuminate/support/Pluralizer.php',
        '/vendor/doctrine/inflector/lib/Doctrine/Common/Inflector/Inflector.php',
        '/src/Foundation/Routing/Traits/ResolveDependency.php',
        '/src/Foundation/Routing/Contracts/Controller.php',
        '/src/Foundation/Routing/Abstracts/Controller.php',
        '/src/Foundation/Routing/Redirector.php',
        '/src/Foundation/Routing/UrlGenerator.php',
        '/vendor/illuminate/contracts/Support/Renderable.php',
        '/vendor/illuminate/contracts/View/View.php',
        '/vendor/dflydev/fig-cookies/src/Dflydev/FigCookies/FigResponseCookies.php',
        '/vendor/dflydev/fig-cookies/src/Dflydev/FigCookies/SetCookie.php',
        '/vendor/dflydev/fig-cookies/src/Dflydev/FigCookies/SetCookies.php',
        '/vendor/zendframework/zend-diactoros/src/Response/SapiEmitterTrait.php',
        '/vendor/zendframework/zend-diactoros/src/Response/EmitterInterface.php',
        '/vendor/zendframework/zend-diactoros/src/Response/SapiEmitter.php',
        '/vendor/illuminate/view/View.php',
        '/src/Foundation/Routing/Dispatchers/ControllerDispatcher.php',
        '/vendor/symfony/http-foundation/Session/Storage/MetadataBag.php',
        '/vendor/illuminate/session/Store.php',
        '/vendor/illuminate/session/EncryptedStore.php',
        '/src/Foundation/Session/EncryptedStore.php',
        '/vendor/zendframework/zend-stratigility/src/Http/Response.php',
        '/vendor/zendframework/zend-diactoros/src/Response.php',
        '/vendor/zendframework/zend-diactoros/src/PhpInputStream.php',
        '/vendor/zendframework/zend-diactoros/src/Uri.php',
        '/vendor/zendframework/zend-diactoros/src/ServerRequest.php',
        '/src/Foundation/Http/Pipelines/ErrorHandler.php',
        '/vendor/illuminate/session/SessionManager.php',
        '/vendor/zendframework/zend-stratigility/src/MiddlewarePipe.php',
        '/src/Extension/Extension.php',
    ];
    /**
     * @return void
     */
    protected function compileClasses() {
        $loader = (new Factory)->create(['skip' => true]);
        $handle = $loader->prepareOutput(storage_path('/caches/compiled.php'));
        foreach ($this->getClassFiles() as $file) {
            try {
                fwrite($handle, $loader->getCode($file, false)."\n");
            } catch (VisitorExceptionInterface $e) {
            }
        }
        fclose($handle);
    }
    /**
     * @return void
     */
    public function configure() {
        $this->addOption('force', null, InputOption::VALUE_NONE, 'Force the compiled class file to be written.');
        $this->addOption('psr', null, InputOption::VALUE_NONE, 'Do not optimize Composer dump-autoload.');
        $this->setDescription('Optimize the framework for better performance');
        $this->setName('optimize');
    }
    /**
     * @return void
     */
    public function fire() {
        $this->info('Generating optimized class loader');
        $complies = $this->getClassFiles();
        if($this->input->getOption('force') || !call_user_func([$this->container, 'inDebugMode'])) {
            $this->info('Compiling common classes');
            $this->compileClasses();
        }
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getClassFiles() {
        $basePath = call_user_func([
            $this->container,
            'basePath'
        ]);
        $complies = new Collection($this->complies);
        $complies->transform(function ($value) use ($basePath) {
            return $basePath . $value;
        });
        (new Collection(array_keys(call_user_func([
            $this->container,
            'getLoadedProviders'
        ]))))->each(function ($provider) use ($complies) {
            foreach((array)forward_static_call([
                $provider,
                'compiles'
            ]) as $value) {
                $complies->push($value);
            }
        });
        return $complies;
    }
}