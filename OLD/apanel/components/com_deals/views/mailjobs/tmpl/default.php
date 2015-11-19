<?php
/**
 * @package     	LongCMS.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$user			= JFactory::getUser();
$userId		= $user->get('id');
$listOrder		= $this->escape($this->state->get('list.ordering'));
$listDirn		= $this->escape($this->state->get('list.direction'));
$canOrder		= $user->authorise('core.edit.state', JCOMPONENT.'.city');
$saveOrder	= $listOrder=='ordering';
$params		= (isset($this->state->params)) ? $this->state->params : new JObject();

?>
<form action="<?php echo JRoute::_('index.php?option='.JCOMPONENT.'&view=cities'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" class="filter_reset" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_DEALS_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="$$('.filter_reset').set('value', '');this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">

			<select name="filter_state" class="inputbox filter_reset" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_DEALS_SELECT_STATUS');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived'=>false, 'trash'=>false, 'all'=>false)), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>

		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_DEALS_HEADING_SUBJECT', 'a.subject', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'COM_DEALS_HEADING_CREATE_DATE', 'a.create_date', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_DEALS_HEADING_PROGRESS', 'progress', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_DEALS_HEADING_REMAINING', 'a.remaining', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_DEALS_HEADING_LASTRUN_DATE', 'a.last_run_date', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_DEALS_HEADING_BODY', 'a.body', $listDirn, $listOrder); ?>
				</th>
				<th width="5%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_DEALS_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		foreach ($this->items as $i => $item) :
			$jdate = JFactory::getDate($item->create_date);
			$jdate->setTimeZone('Asia/Tbilisi');
			$create_date = $jdate->format(null, true);

			if (!empty($item->last_run_date) && $item->last_run_date != '0000-00-00 00:00:00') {
				$jdate = JFactory::getDate($item->last_run_date);
				$jdate->setTimeZone('Asia/Tbilisi');
				$last_run_date = $jdate->format(null, true);
			} else {
				$last_run_date = 'None';
			}

			$subject = $this->escape($item->subject);
			$body = 'View body';

			if ($item->finished) {
				$progress = 'Finished';
			} else {
				$diff = $item->total - $item->remaining;
				$diff2 = $diff / $item->total;
				$progress = round($diff2 * 100, 2);
				$progress = $progress.'%';
			}



			$remaining = $item->remaining;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td>
					<?php echo $subject; ?>
				</td>
				<td class="center">
					<?php echo $create_date; ?>
				</td>
				<td class="center">
					<?php echo $progress; ?>
				</td>
				<td class="center">
					<?php echo $remaining; ?>
				</td>
				<td class="center">
					<?php echo $last_run_date; ?>
				</td>
				<td class="center">
					<?php echo $body; ?>
				</td>
				<td class="center">
					<?php echo $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php
