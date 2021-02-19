<?php

namespace Concrete\Package\PageSplitter\Controller\SinglePage\Dashboard\System\PageSplitter;

use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

final class Settings extends DashboardPageController
{
    public function view()
    {
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);

        $this->set('isEnabled', (bool) $config->get('page_splitter.enabled', true));
    }

    public function save()
    {
        if (!$this->token->validate('a3020.page_splitter.settings')) {
            $this->flash('error', $this->token->getErrorMessage());

            return Redirect::to('/dashboard/system/page_splitter/settings');
        }

        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->save('page_splitter.enabled', (bool) $this->post('isEnabled'));

        $this->flash('success', t('Your settings have been saved.'));

        return Redirect::to('/dashboard/system/page_splitter/settings');
    }
}
