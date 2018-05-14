<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/
defined('_JEXEC') or die();
?>

<div class="joms-page">
    <div class="joms-list__search">
        <div class="joms-list__search-title">
            <h3 class="joms-page__title"><?php echo 'Golf Course'; ?></h3>
        </div>
        <div class="joms-list__utilities">
            <form method="get" class="joms-inline--desktop">
                <span>
                    <input type="text" name="searchkey" class="joms-input--search" value="<?php echo ($fields['searchkey']) ? $fields['searchkey'] : ''; ?>"
                       placeholder="<?php echo JText::_('Search Course'); ?>">
                </span>
                <span>
                    <button class="joms-button--neutral"><?php echo JText::_('COM_COMMUNITY_SEARCH_GO'); ?></button>
                </span>
                <input type="hidden" name="search" value="course">
                <input type="hidden" name="option" value="com_community" />
                <input type="hidden" name="view" value="courses" />
                <input type="hidden" name="Itemid" value="<?php echo CRoute::_getDefaultItemid();?>">
            </form>
        </div>
    </div>

    <?php //echo $submenu;?>

    <div class="joms-gap"></div>

    <div class="joms-tab__content">
    	
	<table class="table table-bordered table-hover">
	<thead>
		<tr class="title">
			<th>
				<?php echo JText::_('Name'); ?>
			</th>
			<th width="20%">
				<?php echo JText::_('City'); ?>
			</th>
            <th width="20%">
				<?php echo JText::_('State'); ?>
			</th>
			<th width="15%">
				<?php echo JText::_('Last Update'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('Status'); ?>
			</th>
            <th width="5%">
				
			</th>
		</tr>
	</thead>
	<?php $i = 0; ?>
	<?php
		if( empty( $rows ) )
		{
	?>
	<tr>
		<td colspan="7" align="center"><?php echo JText::_('Course Not Available');?></td>
	</tr>
	<?php
		}
	?>
	<?php foreach( $rows as $row ): ?>
	<tr>
		<td>
			<a href="javascript:void(0);" onclick="window.location='<?php echo CRoute::_('index.php?option=com_community&view=courses&courseid='.$row->uid); ?>';" >
				<?php echo $row->Name; ?>
			</a>
		</td>
		<td>
			<?php echo $row->City; ?>
		</td>
        <td>
			<?php echo $row->State; ?>
		</td>
		<td>
			<?php echo $row->Updated; ?>
		</td>
        <td>
			<?php if($row->Status==1) echo 'Publish'; else echo 'Unpublish'; ?>
		</td>
        <td>
			<a href="javascript:void(0);" onclick="window.location='<?php echo CRoute::_('index.php?option=com_community&view=courses&task=editcourses&courseid='.$row->uid); ?>';" >
				Edit
			</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
    </div>
</div>
