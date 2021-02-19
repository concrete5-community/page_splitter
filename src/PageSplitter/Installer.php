<?php

namespace A3020\PageSplitter;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;

class Installer
{
    /**
     * @param \Concrete\Core\Package\Package $pkg
     */
    public function install($pkg)
    {
        $this->installBlockTypes($pkg);
        $this->dashboardPages($pkg);
    }

    private function installBlockTypes($pkg)
    {
        if (BlockType::getByHandle('page_splitter')) {
            return;
        }

        BlockType::installBlockType('page_splitter', $pkg);
    }

    private function dashboardPages($pkg)
    {
        $pages = [
            '/dashboard/system/page_splitter' => t('Page Splitter'),
            '/dashboard/system/page_splitter/settings' => t('Settings'),
        ];

        foreach ($pages as $path => $name) {
            /** @var Page $page */
            $page = Page::getByPath($path);
            if ($page && !$page->isError()) {
                continue;
            }

            $singlePage = Single::add($path, $pkg);
            $singlePage->update([
                'cName' => $name,
            ]);
        }
    }
}
