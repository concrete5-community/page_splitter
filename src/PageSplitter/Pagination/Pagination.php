<?php

namespace A3020\PageSplitter\Pagination;

use Concrete\Core\Support\Facade\Application;

class Pagination extends \Concrete\Core\Search\Pagination\Pagination
{
    protected $blockId = 0;

    /**
     * Overridden to remove unneeded GET parameters and to add a block ID parameter.
     *
     * @return \Closure
     */
    public function getRouteCollectionFunction()
    {
        $app = Application::getFacadeApplication();
        $urlHelper = $app->make('helper/url');

        $list = $this->getItemListObject();

        $blockId = $this->blockId;

        $routeCollectionFunction = function ($page) use ($blockId, $list, $urlHelper) {
            // By using the block id in the parameter,
            // we'd support multiple paginations on a page.
            $args = [
                'ccm_paging_ps_' . $blockId => $page,
            ];

            if ($this->baseURL) {
                $url = $urlHelper->setVariable($args, false, $this->baseURL);
            } else {
                $url = $urlHelper->setVariable($args);
            }

            return h($url);
        };

        return $routeCollectionFunction;
    }

    public function setBlockId($blockId)
    {
        $this->blockId = (int) $blockId;
    }
}
