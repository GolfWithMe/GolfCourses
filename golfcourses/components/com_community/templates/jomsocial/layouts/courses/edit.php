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

$course = $rows;
?>

<div class="joms-page">
    <div class="joms-list__search">
        <div class="joms-list__search-title">
            <h3 class="joms-page__title"><?php echo 'Edit Golf Course'; ?></h3>
        </div>
    </div>

    <?php //echo $submenu;?>

    <div class="joms-gap"></div>

    <div class="joms-tab__content">
    	
	<form name="editcourse" action="" method="post" id="editcourse">
<!--<div class="alert alert-info">
    <?php //echo JText::_('Editing Course');?>
</div>-->
<table cellspacing="2" cellpadding="2"  border="0" width="100%">
    <tbody>
        <tr >
            <td width="20%" style="padding:5px;" ><?php echo JText::_('Course Name'); ?></td>
            <td width="80%" style="padding:5px;">
                <input type="text" name="Name" value="<?php echo $course->Name; ?>" style="width: 400px;" />
            </td>
        </tr>
        <tr>
            <td style="padding:5px;" ><?php echo JText::_('Address 1'); ?></td>
            <td style="padding:5px;" >
                <input type="text" name="Address1" value="<?php echo $course->Address1; ?>" style="width: 200px;" />
            </td>
        </tr>
        <tr>
            <td style="padding:5px;" ><?php echo JText::_('Address 2'); ?></td>
            <td style="padding:5px;" >
                <input type="text" name="Address2" value="<?php echo $course->Address2; ?>" style="width: 200px;" />
            </td>
        </tr>
        <tr>
            <td style="padding:5px;" ><?php echo JText::_('City, State, Zip'); ?></td>
            <td style="padding:5px;">
                <table cellspacing="0" border="0" width="100%">
                <tr>
                    <td width="30%" ><input type="text" name="City" value="<?php echo $course->City; ?>" style="width: 200px;" /></td>
                    <td width="30%"><input type="text" name="State" value="<?php echo $course->State; ?>" style="width: 200px;" /></td>
                    <td width="30%" ><input type="text" name="ZipCode" value="<?php echo $course->ZipCode; ?>" style="width: 200px;" /></td>
                 </tr>
                 </table>
            </td>
        </tr>
        <tr>
            <td style="padding:5px;" ><?php echo JText::_('Main Phone'); ?></td>
            <td style="padding:5px;">
                <input type="text" name="Phone" value="<?php echo $course->Phone; ?>" style="width: 200px;" />
            </td>
        </tr><tr>
            <td style="padding:5px;" ><?php echo JText::_('Booking Phone'); ?></td>
            <td style="padding:5px;">
                <input type="text" name="BPhone" value="<?php echo $course->BPhone; ?>" style="width: 200px;" />
            </td>
        </tr><tr>
            <td style="padding:5px;" ><?php echo JText::_('Main Site URL'); ?></td>
            <td style="padding:5px;">
                <input type="text" name="URL" value="<?php echo $course->URL; ?>" style="width: 200px;" />
            </td>
        </tr><tr>
            <td style="padding:5px;" ><?php echo JText::_('Booking URL'); ?></td>
            <td style="padding:5px;">
                <input type="text" name="BURL" value="<?php echo $course->BURL; ?>" style="width: 200px;" />
            </td>
        </tr>
        <tr>
            <td style="padding:5px;"><?php echo JText::_('Map URL'); ?></td>
            <td style="padding:5px;">
                <input type="text" name="locMap" value="<?php echo $course->locMap; ?>" style="width: 200px;" />
            </td>
        </tr>
        <tr>
            <td style="padding:5px;"><?php echo JText::_('Price Range'); ?></td>
            <td style="padding:5px;">
                <input type="text" name="priceRange" value="<?php echo $course->priceRange; ?>" style="width: 200px;" />
            </td>
        </tr>
        <tr>
            <td style="padding:5px;" ><?php echo JText::_('Holes'); ?></td>
            <td style="padding:5px;">
                <input type="text" name="Holes" value="<?php echo $course->Holes; ?>" style="width: 200px;" />
            </td>
        </tr><tr>
            <td style="padding:5px;" ><?php echo JText::_('Course Type'); ?></td>
            <td style="padding:5px;">
                <select name='CourseType'>
                    <option value='Links Courses' <?php echo ($course->CourseType == "Links Courses" ) ? ' selected="selected"' : '';?> ><?php echo JText::_('Links Courses');?></option>
                    <option value='Parkland Courses' <?php echo ($course->CourseType == "Parkland Courses" ) ? ' selected="selected"' : '';?> ><?php echo JText::_('Parkland Courses');?></option>
                    <option value='Resort Courses' <?php echo ($course->CourseType == "Resort Courses" ) ? ' selected="selected"' : '';?> ><?php echo JText::_('Resort Courses');?></option>
                    <option value='Heath-Land courses' <?php echo ($course->CourseType == "Heath-Land courses" ) ? ' selected="selected"' : '';?> ><?php echo JText::_('Heath-Land courses');?></option>
                    <option value='Desert Golf courses' <?php echo ($course->CourseType == "Desert Golf courses" ) ? ' selected="selected"' : '';?> ><?php echo JText::_('Desert Golf courses');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="padding:5px;" ><?php echo JText::_('Home Group'); ?></td>
            <td style="padding:5px;">
                
                <select name='HomeGroup'>
                    <?php foreach ( $groups as $rowg ) { ?>
                    <option value='<?= $rowg->id ?>' <?php if ($rowg->id == $course->HomeGroup) echo " SELECTED"?>><?php echo JText::_($rowg->name);?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="padding:5px;" ><?php echo JText::_('Status');?></td>
            <td style="padding:5px;" >
                <select name='Status'>
                    <option value='1' <?php echo ($course->Status == 1 ) ? ' selected="selected"' : '';?> ><?php echo JText::_('Publish');?></option>
                    <option value='2' <?php echo ($course->Status == 2 ) ? ' selected="selected"' : '';?> ><?php echo JText::_('Unpublish');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="padding:5px;" ></td>
            <td style="padding:5px;"><input type="button" class="btn btn-small " onclick="window.location='<?php echo CRoute::_('index.php?option=com_community&view=courses'); ?>';" name="Close" value="Close" /> &nbsp; <input type="submit" class="btn btn-small btn-primary" name="Save" value="Save" /></td>
        </tr>
        
    </tbody>
</table>
<input type="hidden" name="id" value="<?php echo $course->uid;?>" />
<input type="hidden" name="courseid" value="<?php echo $course->uid;?>" />
<input type="hidden" name="option" value="com_community" />
<input type="hidden" name="task" value="editcourses" />
<input type="hidden" name="view" value="courses" />
<input type="hidden" name="stepset" value="edit" />
</form>
    </div>
</div>
