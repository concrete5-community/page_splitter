<?php

namespace A3020\PageSplitter\Pagination;

use A3020\PageSplitter\Area;

/**
 * A custom adapter is being used because all the concrete5
 * adapters are used icw e.g. Doctrine / entities / item lists.
 *
 * We just want a basic implementation to adhere to the typehints.
 */
class PaginationAdapter implements \Pagerfanta\Adapter\AdapterInterface
{
    /**
     * @var Area
     */
    private $area;

    public function __construct(Area $area)
    {
        $this->area = $area;
    }

    /**
     * @inheritdoc
     */
    public function getNbResults()
    {
        return $this->area->getNumberOfPages();
    }

    /**
     * @inheritdoc
     */
    public function getSlice($offset, $length)
    {
        // Not relevant

        return [];
    }
}
