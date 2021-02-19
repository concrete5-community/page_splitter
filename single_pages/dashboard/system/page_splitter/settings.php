<?php
defined('C5_EXECUTE') or die('Access Denied.');

/** @var \Concrete\Core\Validation\CSRF\Token $token */
/** @var bool $isEnabled */
?>

<div class="ccm-dashboard-content-inner">
    <form method="post" action="<?php echo $this->action('save'); ?>">
        <?php
        echo $token->output('a3020.page_splitter.settings');
        ?>

        <div class="form-group">
            <label class="control-label launch-tooltip"
               title="<?php echo t('If disabled, %s will be completely turned off.', t('Page Splitter')) ?>"
               for="isEnabled">
                <?php
                echo $form->checkbox('isEnabled', 1, $isEnabled);
                ?>
                <?php echo t(/*i18n: where %s is the name of the add-on */'Enable %s', t('Page Splitter')); ?>
            </label>
        </div>

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <button class="pull-right btn btn-primary" type="submit"><?php echo t('Save') ?></button>
            </div>
        </div>
    </form>
</div>
