<?php
/**
 * @package	LongCMS.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<div class="module_block<?php echo $this->pageclass_sfx?>">
    <div class="login_body">
        <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="login_title">
            <?php echo $this->escape($this->params->get('page_heading')); ?>
        </div>
        <?php endif; ?>
    
        <form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>" method="post" class="form-validate">
    
            <?php foreach ($this->form->getFieldsets() as $fieldset): ?>
            <div class="login_desc">
				<?php echo JText::_($fieldset->label); ?>
            </div>
            <fieldset>
            	<div class="reset_items">
                    <div class="login-fields">
                    <?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field): ?>
                        <div class="reset_label">
							<?php echo $field->label; ?>
                        </div>
                        <div class="reset_input">
							<?php echo $field->input; ?>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </fieldset>
            <?php endforeach; ?>
    
            <div class="reset_but">
                <button type="submit" class="send_button validate"><?php //echo JText::_('JSUBMIT'); ?></button>
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </form>
    </div>
</div>
