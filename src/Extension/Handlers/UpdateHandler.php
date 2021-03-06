<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-03 15:33
 */
namespace Notadd\Foundation\Extension\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class UpdateHandler.
 */
class UpdateHandler extends SetHandler
{
    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;

    /**
     * UpdateHandler constructor.
     *
     * @param \Illuminate\Container\Container               $container
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function __construct(Container $container, ExtensionManager $manager)
    {
        parent::__construct($container);
        $this->manager = $manager;
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans(''),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $extension = $this->manager->get($this->request->input('name'));
        if ($extension && method_exists($provider = $extension->getEntry(), 'update')) {
            return call_user_func([
                $provider,
                'update',
            ]);
        }

        return false;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}
