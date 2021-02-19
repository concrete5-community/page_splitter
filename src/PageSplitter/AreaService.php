<?php

namespace A3020\PageSplitter;

use Concrete\Core\Block\Block;
use Concrete\Core\Http\Request;

class AreaService
{
    /**
     * @var Request
     */
    private $request;

    /**
     * List of area objects.
     *
     * @var Area[]
     */
    protected $areas = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Register a block in a certain area.
     *
     * @param $areaHandle
     * @param Block $block
     */
    public function addBlock($areaHandle, Block $block)
    {
        if (!isset($this->areas[$areaHandle])) {
            $this->areas[$areaHandle] = new Area();
        }

        // Set the page number if pagination has been used in this area.
        $param = 'ccm_paging_ps_' . $block->getBlockID();
        if ($this->request->query->has($param)) {
            $this->areas[$areaHandle]->setRequestedPage(
                (int) $this->request->query->get($param)
            );
        }

        $this->areas[$areaHandle]->add($block);
    }

    /**
     * @param Block $block
     *
     * @return bool
     */
    public function shouldShow(Block $block)
    {
        // Because this is triggered on page view
        // we can assume the area is present.

        return $this->getArea($block)
            ->shouldShow($block);
    }

    /**
     * @param Block $block
     *
     * @return Area|null
     */
    public function getArea(Block $block)
    {
        // E.g. if you add a block, there won't be an area set.
        if (!$block->getAreaHandle()) {
            return null;
        }

        return $this->areas[$block->getAreaHandle()];
    }
}
