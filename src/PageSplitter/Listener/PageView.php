<?php

namespace A3020\PageSplitter\Listener;

use A3020\PageSplitter\AreaService;
use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Logging\Logger;
use Concrete\Core\Page\Event;
use Exception;

class PageView implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var AreaService
     */
    private $areaService;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(AreaService $areaService, Logger $logger)
    {
        $this->areaService = $areaService;
        $this->logger = $logger;
    }

    public function handle(Event $event)
    {
        try {
            $page = $event->getPageObject();

            /** @var \Concrete\Core\Block\Block $block */
            foreach ($page->getBlocks() as $block) {

                // Make a registry of which blocks are in which areas.
                // We'll also determine the current page number
                // and how many Page Splitters are used per area.
                $this->areaService->addBlock(
                    $block->getAreaHandle(),
                    $block
                );
            }
        } catch (Exception $e) {
            $this->logger->addDebug($e->getMessage());
        }
    }
}
