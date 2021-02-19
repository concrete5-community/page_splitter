<?php

namespace Concrete\Package\PageSplitter\Controller\SinglePage\Dashboard\System;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

final class PageSplitter extends DashboardPageController
{
    public function view()
    {
        return Redirect::to('/dashboard/system/page_splitter/settings');
    }
}
