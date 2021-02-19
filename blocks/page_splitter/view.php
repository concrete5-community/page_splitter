<?php

defined('C5_EXECUTE') or die('Access Denied.');

/** @var \Concrete\Core\Page\Page $c */
/** @var string|null $pagination */

if ($c->isEditMode()) {
    ?>
    <div class="page-splitter"
        style="
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #bce8f1;
        border-radius: 4px;
        background: #d9edf7;
        color: #31708f;
    ">
        <?php
        echo t('Page Splitter')
            . ' - '
            . t('The blocks before this block will be put on their own page.');
        ?>
    </div>
    <?php
    return;
}

if ($pagination) {
    echo $pagination;
}
