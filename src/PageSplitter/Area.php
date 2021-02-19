<?php

namespace A3020\PageSplitter;

/**
 * This is an internal class to keep track of how many page splitters
 * are used in an area. And e.g. which page should be active in the pagination.
 */
class Area
{
    /**
     * Which page in the pagination the user requested
     *
     * This is done with the ccm_paging_ps_p GET parameter.
     *
     * @var int
     */
    protected $requestedPage = 1;

    /**
     * Internal counter of which page we're at.
     *
     * @var int
     */
    protected $pageInPagination = 1;

    /**
     * The number of page splitter blocks in this area.
     *
     * @var int
     */
    protected $splitterBlocks = 0;

    public function add(\Concrete\Core\Block\Block $block)
    {
        if ($block->getBlockTypeHandle() === 'page_splitter') {
            $this->splitterBlocks++;
        }
    }

    /**
     * To render or not to render.
     *
     * @param \Concrete\Core\Block\Block $block
     *
     * @return bool
     */
    public function shouldShow(\Concrete\Core\Block\Block $block)
    {
        // Only show blocks for the requested pagination page.
        $shouldShow = $this->requestedPage === $this->pageInPagination;

        // The Page Splitter indicates the end of a section / page.
        if ($block->getBlockTypeHandle() === 'page_splitter') {

            // Only show the last Page Splitter block.
            // If we don't do this, the page parameter will jump between block ids.
            $shouldShow = $this->pageInPagination === $this->getNumberOfPages();
            $this->pageInPagination++;
        }

        return $shouldShow;
    }

    /**
     * The number of Page Splitter blocks in this area.
     *
     * @return int
     */
    public function getNumberOfPages()
    {
        return $this->splitterBlocks;
    }

    /**
     * The active page number in the pagination.
     *
     * @return int
     */
    public function getRequestedPage()
    {
        return $this->requestedPage;
    }

    /**
     * @param int $requestedPage
     */
    public function setRequestedPage($requestedPage)
    {
        $this->requestedPage = $requestedPage;
    }
}
