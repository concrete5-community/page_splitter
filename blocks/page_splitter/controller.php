<?php

namespace Concrete\Package\PageSplitter\Block\PageSplitter;

use A3020\PageSplitter\AreaService;
use A3020\PageSplitter\Pagination\Pagination;
use A3020\PageSplitter\Pagination\PaginationAdapter;
use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    protected $btDefaultSet = 'basic';
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = false;
    protected $btCacheBlockOutputOnPost = false;
    protected $btCacheBlockOutputForRegisteredUsers = false;

    public function getBlockTypeName()
    {
        return t('Page Splitter');
    }

    public function getBlockTypeDescription()
    {
        return t('Split content in multiple pages.');
    }

    public function view()
    {
        $this->set('c', $this->request->getCurrentPage());

        $this->set('pagination', $this->getPagination());
    }

    /**
     * If pagination is needed at this point, return the HTML.
     *
     * @return string|null
     */
    private function getPagination()
    {
        /** @var AreaService $areaService */
        $areaService = $this->app->make(AreaService::class);

        $area = $areaService->getArea($this->getBlockObject());

        if (!$area) {
            return null;
        }

        // This is a bogus class that doesn't really do anything
        // but we need it to adhere to typehints...
        $itemList = $this->app->make(\A3020\PageSplitter\Pagination\PageList::class);

        // Set a namespace to prevent collision with other blocks
        $itemList->setNameSpace('ps');

        // The area is passed, so the pagination 'knows'
        // how many pages the pagination should get.
        $paginationAdapter = $this->app->make(PaginationAdapter::class, [
            $area,
        ]);

        /** @var Pagination $pagination */
        $pagination = $this->app->make(Pagination::class, [
            $itemList,
            $paginationAdapter,
        ]);

        $pagination->setBlockId($this->getBlockObject()->getBlockID());
        $pagination->setMaxPerPage(1);
        $pagination->setCurrentPage($area->getRequestedPage());

        /** @var \Concrete\Core\Search\Pagination\View\Manager $manager */
        $manager = $this->app->make('manager/view/pagination');

        $driver = $manager->driver('application');

        /** @var \Concrete\Core\Search\Pagination\View\ViewRenderer $view */
        $view = $this->app->make(\Concrete\Core\Search\Pagination\View\ViewRenderer::class, [
            $pagination,
            $driver
        ]);

        return $view->render([]);
    }
}
