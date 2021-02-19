<?php

namespace A3020\PageSplitter;

use A3020\PageSplitter\Listener\PageView;
use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Provider implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var Repository
     */
    private $config;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        Repository $config
    )
    {
        $this->dispatcher = $dispatcher;
        $this->config = $config;
    }

    public function register()
    {
        // If the add-on is disabled, don't do anything!
        if ($this->config->get('page_splitter.enabled', true) === false) {
            return;
        }

        $this->bindings();
        $this->listeners();
    }

    private function bindings()
    {
        $this->app->singleton(AreaService::class, AreaService::class);
    }

    /**
     * Register event listeners.
     *
     * When a page is viewed:
     * - The number of Page Splitters is counted per area.
     * - The current page number is determined per area.
     *
     * When a block is rendered:
     * - The last Page Splitter is used for pagination.
     * - Blocks that are not on the 'current page' won't be rendered.
     */
    private function listeners()
    {
        $this->dispatcher->addListener('on_page_view', function ($event) {
            /** @var PageView $listener */
            $listener = $this->app->make(PageView::class);
            $listener->handle($event);
        });

        // This event is available in 8.4.0 and higher
        $this->dispatcher->addListener('on_block_before_render', function ($event) {
            /** @var \A3020\PageSplitter\Listener\BlockBeforeRender $listener */
            $listener = $this->app->make(\A3020\PageSplitter\Listener\BlockBeforeRender::class);

            return $listener->handle($event);
        });
    }
}
