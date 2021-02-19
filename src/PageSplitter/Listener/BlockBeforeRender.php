<?php

namespace A3020\PageSplitter\Listener;

use A3020\PageSplitter\AreaService;
use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;

class BlockBeforeRender implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var AreaService
     */
    private $areaService;

    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
    }

    public function handle(\Concrete\Core\Block\Events\BlockBeforeRender $event)
    {
        $block = $event->getBlock();

        // This can occur when adding a new block.
        if (!is_object($block)) {
            return $event;
        }

        // Always show the block in edit mode
        $page = $block->getBlockCollectionObject();
        if ($page->isEditMode()) {
            return $event;
        }

        // Each area can have it's own pagination
        // meaning that some blocks may / should be invisible.
        if (!$this->areaService->shouldShow($block)) {
            $event->preventRendering();
        }

        return $event;
    }
}
