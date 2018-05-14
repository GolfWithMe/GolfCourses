<?php
/**
 * @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
 * @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author iJoomla.com <webmaster@ijoomla.com>
 * @url https://www.jomsocial.com/license-agreement
 * The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
 * More info at https://www.jomsocial.com/license-agreement
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
jimport('joomla.utilities.arrayhelper');
jimport('joomla.html.html');

class CommunityViewCourses extends CommunityView {
	
	 /**
     * Display list of courses
     *
     * if no id is set, we're viewing our own groupschedule
     */
    public function courses($data = null) {
        $mainframe = JFactory::getApplication();
		$jinput = $mainframe->input;

        // Load necessary window css / javascript headers.
        CWindow::load();

        $config = CFactory::getConfig();
        $my = CFactory::getUser();

        if ($my->id == 0) {
            $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
            return;
        }
		
		/**
         * Opengraph
         */
        CHeadHelper::setType('website', 'Golf Course');

        //$this->showSubMenu();
		
		//start new requests
		//fields
		$fields=$data->fields;
		//print_r($fields);
		//print_r($_POST);
		//$fieldset = array();
		
		$groupsModel = CFactory::getModel('groups');
		$courseModel = CFactory::getModel('courses');
		
		$step=$fields[stepset];
		$course = $courseModel->getMyCourse($my->id, $fields);
                $mygroups = $groupsModel->getGroupMembership($my->id);
		//print_r($course);
		
        $tmpl = new CTemplate();
        echo $tmpl->set('my', $my)
                ->set('config', $config)
                ->set('rows', $course)
                ->set('groups', $mygroups)
                ->set('step', $step)
                ->set('fields', $fields)
                //->set('pagination', $data->pagination)
		//->set('submenu', $this->showSubmenu(false))
                ->fetch('courses/list');
    }
	
    public function editcourses($data = null) {
        $mainframe = JFactory::getApplication();
		$jinput = $mainframe->input;

        // Load necessary window css / javascript headers.
        CWindow::load();

        $config = CFactory::getConfig();
        $my = CFactory::getUser();

        if ($my->id == 0) {
            $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
            return;
        }

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', 'Edit Golf Course');

        //$this->showSubMenu();

        //fields
        $fields=$data->fields;
        //print_r($fields);
        //print_r($_POST);

        $courseModel = CFactory::getModel('courses');
        $course = $courseModel->getCourseDetails($fields['courseid']);
        if ($my->id != $course->ownerid) {
            $mainframe->enqueueMessage(JText::_('You have not access for edit this course.'), 'error');
            return;
        }
		
        $step=$fields[stepset];

        if($step=="edit") {
                $groupId=$fields[selgroup];
                $course = $courseModel->getUpdateCourse($fields);
                $mainframe->enqueueMessage('Course Edit successfully.', 'success');
                $course = $courseModel->getCourseDetails($fields['courseid']);
        } else {
                $course = $courseModel->getCourseDetails($fields['courseid']);
        }

        $groupsModel = CFactory::getModel('groups');
        $mygroups = $groupsModel->getMyGroups($my->id);
        //print_r($mygroups);
        
        //die();
        //print_r($groups);
                
        $tmpl = new CTemplate();
        echo $tmpl->set('my', $my)
                ->set('config', $config)
                ->set('rows', $course)
                ->set('groups', $mygroups)
                ->set('step', $step)
                ->set('fields', $fields)
                ->fetch('courses/edit');
    }
	
    public function viewall($data = null) {
        $mainframe = JFactory::getApplication();
		$jinput = $mainframe->input;

        // Load necessary window css / javascript headers.
        CWindow::load();

        $config = CFactory::getConfig();
        $my = CFactory::getUser();

        if ($my->id == 0) {
            $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
            return;
        }

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', 'Golf-With-Me View List');

        $this->showSubMenu();
		
		//fields
		$fields=$data->fields;
		//print_r($fields);
		//print_r($_POST);
		//$fieldset = array();
		
		
		//$groupsModel = CFactory::getModel('groups');
		$groupsModel = CFactory::getModel('groupschedule');
		$golfersModel = CFactory::getModel('findgolfers');
		
		
		$step=$fields[stepset];
		if($step=="created") {		
			$rowgroups = $groupsModel->getGroupScheduleList($my->id);
			$rowgolfers = $golfersModel->getFindGolfersList($my->id);
		} else if ($step=="cancel") {
				$savedate = $groupsModel->addGroupScheduleCancel($my->id, $fields);
				$mainframe->enqueueMessage('Schedule cancel successfully.', 'success');
				$schedule = $groupsModel->getPendingSchedule($my->id);
		} else {
			$rowgroups = $groupsModel->getPendingSchedule($my->id);
		}
		
		//print_r($groups);
        $tmpl = new CTemplate();
        echo $tmpl->set('my', $my)
                ->set('config', $config)
                ->set('rowsgroup', $rowgroups)
				->set('rowsgolfers', $rowgolfers)
                //->set('pagination', $data->pagination)
                ->fetch('groupschedule/viewall');
    }
	
	public function recresponse($data = null) {
        $mainframe = JFactory::getApplication();
		$jinput = $mainframe->input;

        // Load necessary window css / javascript headers.
        CWindow::load();

        $config = CFactory::getConfig();
        $my = CFactory::getUser();

        if ($my->id == 0) {
            $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
            return;
        }
		
		//$mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'success');

        //$this->addPathway(JText::_('COM_COMMUNITY_FRIENDS'), CRoute::_('index.php?option=com_community&view=groupschedule'));
        //$this->addPathway(JText::_("COM_COMMUNITY_FRIENDS_WAITING_AUTHORIZATION"), '');

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', 'Golf-With-Me Pending Response');

        //$this->showSubMenu();
		
		//fields
		$fields=$data->fields;
		//print_r($fields);
		//print_r($_POST);
		//$fieldset = array();
		
		
		//$groupsModel = CFactory::getModel('groups');
		$groupsModel = CFactory::getModel('groupschedule');
		
		
		$step=$fields[stepset];
		if($step=="submitresponse") {		
			if($fields[seldate]!='') {
				$savedate = $groupsModel->addGroupScheduleAccept($my->id, $fields);
				$mainframe->enqueueMessage('Schedule response successfully.', 'success');
				$schedule = $groupsModel->getPendingSchedule($my->id);
				
			} else {
				
				$schedule = $groupsModel->getPendingSchedule($my->id);
				//$gsData = $groupsModel->getGroupSchedule($fields['reqid']);
				//print_r($gsData);
				$mainframe->enqueueMessage('Please select date.', 'error');
			}
		} else if ($step=="cancel") {
				$savedate = $groupsModel->addGroupScheduleCancel($my->id, $fields);
				$mainframe->enqueueMessage('Schedule cancel successfully.', 'success');
				$schedule = $groupsModel->getPendingSchedule($my->id);
		} else {
			$schedule = $groupsModel->getPendingSchedule($my->id);
		}
		
		//print_r($groups);
        $tmpl = new CTemplate();
        echo $tmpl->set('my', $my)
                ->set('config', $config)
                ->set('rows', $schedule)
                ->set('pagination', $data->pagination)
                ->fetch('groupschedule/request-received');
    }
	
	public function closerequest($data = null) {
        $mainframe = JFactory::getApplication();
		$jinput = $mainframe->input;

        // Load necessary window css / javascript headers.
        CWindow::load();

        $config = CFactory::getConfig();
        $my = CFactory::getUser();

        if ($my->id == 0) {
            $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
            return;
        }
		
        /**
         * Opengraph
         */
        CHeadHelper::setType('website', 'Requestor Close Request');

        //$this->showSubMenu();
		
		//fields
		$fields=$data->fields;
		//print_r($fields);
		//print_r($_POST);
		//$fieldset = array();
		
		
		//$groupsModel = CFactory::getModel('groups');
		$groupsModel = CFactory::getModel('groupschedule');
		
		
		$step=$fields[stepset];
		if($step=="accept") {
			$savedate = $groupsModel->updateRequestorAccept($my->id, $fields);
			$mainframe->enqueueMessage('Requestor Accept successfully.', 'success');
			$schedule = $groupsModel->getGroupScheduleListClose($my->id);
		} else if ($step=="cancel") {
			$savedate = $groupsModel->updateRequestorCancel($my->id, $fields);
			$mainframe->enqueueMessage('Requestor cancel successfully.', 'success');
			$schedule = $groupsModel->getGroupScheduleListClose($my->id);
		} else if ($step=="acceptcourse") {
			$fieldset['req']=$fields[req];
			$fieldset['sd']=$fields[sd];
			$fieldset['step']=$step;
			$schedule = $groupsModel->getGroupScheduleListClose($my->id);
			
		} else if ($step=="acceptteetime") {
			$fieldset['req']=$fields[req];
			$fieldset['sd']=$fields[sd];
			$fieldset['member']=$fields[member];
			$memcount=count($fields[member]);
			if($memcount<1) {
				$fieldset['step']="acceptcourse";
				$mainframe->enqueueMessage('Please select Golfers.', 'error');
			} else {
				$fieldset['step']=$step;
			}
			$schedule = $groupsModel->getGroupScheduleListClose($my->id);
			
		} else {
			$schedule = $groupsModel->getGroupScheduleListClose($my->id);
		}
		
		//print_r($groups);
        $tmpl = new CTemplate();
        echo $tmpl->set('my', $my)
                ->set('config', $config)
                ->set('rows', $schedule)
				->set('fieldset', $fieldset)
                //->set('pagination', $data->pagination)
                ->fetch('groupschedule/request-closed');
    }
	
	public function acceptrequest($data = null) {
        $mainframe = JFactory::getApplication();
		$jinput = $mainframe->input;

        // Load necessary window css / javascript headers.
        CWindow::load();

        $config = CFactory::getConfig();
        $my = CFactory::getUser();

        if ($my->id == 0) {
            $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
            return;
        }
		
        /**
         * Opengraph
         */
        CHeadHelper::setType('website', 'Requestor Accept Request');

        //$this->showSubMenu();
		
		//fields
		$fields=$data->fields;
		//print_r($fields);
		//print_r($_POST);
		//$fieldset = array();
		
		
		//$groupsModel = CFactory::getModel('groups');
		$groupsModel = CFactory::getModel('groupschedule');
		
		
		$step=$fields[stepset];
		$schedule = $groupsModel->getScheduleRequestorAcceptList($my->id);
		$useraccept = $groupsModel->getGroupScheduleAcceptList($my->id);
		
		//print_r($groups);
        $tmpl = new CTemplate();
        echo $tmpl->set('my', $my)
                ->set('config', $config)
                ->set('rows', $schedule)
				->set('userrows', $useraccept)
                ->set('pagination', $data->pagination)
                ->fetch('groupschedule/request-accept');
    }

    public function _addSubmenu() {

        $mainframe = JFactory::getApplication();
        $jinput = $mainframe->input;
        $task = $jinput->get('task', '');

        if (JFile::exists(JPATH_COMPONENT . '/libraries/advancesearch.php')) {
            require_once (JPATH_COMPONENT . '/libraries/advancesearch.php');
            $mySQLVer = CAdvanceSearch::getMySQLVersion();
        }
		
		$this->addSubmenuItem('index.php?option=com_community&view=groupschedule', JText::_('View All'));
		$this->addSubmenuItem('index.php?option=com_community&view=groupschedule&task=viewall&stepset=created', JText::_('Created Request'));
		$this->addSubmenuItem('index.php?option=com_community&view=groupschedule&task=viewall&stepset=response', JText::_('Response Request'));
		$this->addSubmenuItem('index.php?option=com_community&view=groupschedule&stepset=rejected', JText::_('Rejected Request'));
		$this->addSubmenuItem('index.php?option=com_community&view=groupschedule&task=viewall&stepset=pastevents', JText::_('Past Events'));
		
		/*

        //if($task != 'sent' && $task != 'pending' ) {
            $this->addSubmenuItem('index.php?option=com_community&view=groupschedule', JText::_('COM_COMMUNITY_FRIENDS_VIEW_ALL'));
            //$this->addSubmenuItem('index.php?option=com_community&view=search&task=advancesearch', JText::_('COM_COMMUNITY_CUSTOM_SEARCH'));
            //$this->addSubmenuItem('index.php?option=com_community&view=groupschedule&task=invite', JText::_('COM_COMMUNITY_INVITE_FRIENDS'));
        //}

        $tmpl = new CTemplate();
        $tmpl->set('url', CRoute::_('index.php?option=com_community&view=search'));
        $html = $tmpl->fetch('search.submenu');
        $this->addSubmenuItem('index.php?option=com_community&view=groupschedule&task=sent', JText::_('COM_COMMUNITY_FRIENDS_REQUEST_SENT'));
        $this->addSubmenuItem('index.php?option=com_community&view=groupschedule&task=pending', JText::_('COM_COMMUNITY_FRIENDS_PENDING_APPROVAL'));
		*/
    }

    public function showSubmenu($display=true) {
        $this->_addSubmenu();
        return parent::showSubmenu($display);
    }

   

    /**
     * Search list of friends
     *
     * if no id is set, we're viewing our own friends
     */
    public function friendsearch($data) {

        require_once (JPATH_COMPONENT . '/libraries/profile.php');
        require_once (JPATH_COMPONENT . '/helpers/friends.php');

        $mainframe = JFactory::getApplication();
        $jinput = $mainframe->input;

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', JText::_('COM_COMMUNITY_SEARCH_FRIENDS_TITLE'));

        $avatarOnly = $jinput->get('avatar', '', 'NONE');
        $this->addPathway(JText::_('COM_COMMUNITY_SEARCH_FRIENDS_TITLE'));

        $my = CFactory::getUser();
        $friendsModel = CFactory::getModel('friends');
        $resultRows = array();

        $id = $jinput->getInt('userid', $my->id);

        $user = CFactory::getUser($id);
        $isMine = ( ($id == $my->id) && ($my->id != 0) );

        $pagination = (!empty($data)) ? $data->pagination : '';
        $alreadyfriend = array();

        $tmpl = new CTemplate();

        for ($i = 0; $i < count($data->result); $i++) {
            $row = $data->result[$i];
            $user = CFactory::getUser($row->id);
            $row->profileLink = CRoute::_('index.php?option=com_community&view=profile&userid=' . $row->id);
            $row->friendsCount = $user->getFriendCount();
            $isFriend = CFriendsHelper::isConnected($row->id, $my->id);

            $row->user = $user;
            $row->addFriend = ((!$isFriend) && ($my->id != 0) && $my->id != $row->id) ? true : false;
            if ($row->addFriend) {
                $alreadyfriend[$row->id] = $row->id;
            }

            $resultRows[] = $row;
        }

        $tmpl->set('alreadyfriend', $alreadyfriend);
        $tmpl->set('data', $resultRows);
        $tmpl->set('sortings', '');
        $tmpl->set('pagination', $pagination);

        $featured = new CFeatured(FEATURED_USERS);
        $featuredList = $featured->getItemIds();

        $tmpl->set('featuredList', $featuredList);

        //CFactory::load( 'helpers' , 'owner' );
        $tmpl->set('isCommunityAdmin', COwnerHelper::isCommunityAdmin());
        $tmpl->set('showFeaturedList', false);
        $tmpl->set('my', $my);
        $resultHTML = $tmpl->fetch('people.browse');
        unset($tmpl);

        $searchLinks = parent::getAppSearchLinks('people');

        if ($isMine) {
            $this->showSubmenu();
            /**
             * Opengraph
             */
            CHeadHelper::setType('website', JText::_('COM_COMMUNITY_FRIENDS_MY_FRIENDS'));
        } else {
            $this->addSubmenuItem('index.php?option=com_community&view=profile&userid=' . $user->id, JText::_('COM_COMMUNITY_PROFILE_BACK_TO_PROFILE'));
            $this->addSubmenuItem('index.php?option=com_community&view=groupschedule&userid=' . $user->id, JText::_('COM_COMMUNITY_FRIENDS_VIEW_ALL'));
            $this->addSubmenuItem('index.php?option=com_community&view=groupschedule&task=mutualFriends&userid=' . $user->id . '&filter=mutual', JText::_('COM_COMMUNITY_MUTUAL_FRIENDS'));

            $tmpl = new CTemplate();
            $tmpl->set('view', "groupschedule");
            $tmpl->set('url', CRoute::_('index.php?option=com_community&view=groupschedule&task=viewfriends'));
            $html = $tmpl->fetch('friendsearch.submenu');
            $this->addSubmenuItem('index.php?option=com_community&view=groupschedule&task=viewfriends', JText::_('COM_COMMUNITY_SEARCH_FRIENDS'), 'joms.videos.toggleSearchSubmenu(this)', SUBMENU_LEFT, $html);

           return parent::showSubmenu($display);
            /**
             * Opengraph
             */
            CHeadHelper::setType('website', JText::sprintf('COM_COMMUNITY_FRIENDS_ALL_FRIENDS', $user->getDisplayName()));
        }

        $tmpl = new CTemplate();
        $tmpl->set('avatarOnly', $avatarOnly);
        $tmpl->set('results', $data->result);
        $tmpl->set('resultHTML', $resultHTML);
        $tmpl->set('query', $data->query);
        $tmpl->set('searchLinks', $searchLinks);
        echo $tmpl->fetch('friendsearch');
    }

    public function add($data = null) {

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', JText::_('COM_COMMUNITY_FRIENDS_ADD_NEW_FRIEND'));
        ?>
        <div class="app-box">
            <p><?php echo JText::sprintf('COM_COMMUNITY_ADD_USER_AS_FRIEND', $data->name); ?></p>
            <form name="addfriend" method="post" action="">
                <div>
                    <label><?php echo JText::sprintf('COM_COMMUNITY_INVITE_PERSONAL_MESSAGE_TO', $data->name); ?></label>
                </div>

                <div>
                    <textarea name="msg" class="input textarea"></textarea>
                </div>

                <div>
                    <input type="submit" class="button" name="submit" value="<?php echo JText::_('COM_COMMUNITY_FRIENDS_ADD_BUTTON'); ?>"/>
                    <input type="submit" class="button" name="cancel" value="<?php echo JText::_('COM_COMMUNITY_CANCEL_BUTTON'); ?>"/>
                </div>
                <input type="hidden" class="button" name="id" value="<?php echo $data->id; ?>"/>
            </form>
        </div>
        <?php
    }

    public function online($data = null) {
        // Load the toolbar
        $this->showHeader(JText::_('COM_COMMUNITY_FRIENDS_ONLINE_FRIENDS'), 'generic');
        /**
         * Opengraph
         */
        CHeadHelper::setType('website', JText::_('COM_COMMUNITY_ONLINE_FRIENDS_TITLE'));
        $this->friends('',true);
    }

    public function sent($data = null) {
        $mainframe = JFactory::getApplication();

        // Load necessary window css / javascript headers.
        CWindow::load();

        $config = CFactory::getConfig();
        $my = CFactory::getUser();

        if ($my->id == 0) {
            $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
            return;
        }

        $this->addPathway(JText::_('COM_COMMUNITY_FRIENDS'), CRoute::_('index.php?option=com_community&view=groupschedule'));
        $this->addPathway(JText::_("COM_COMMUNITY_FRIENDS_WAITING_AUTHORIZATION"), '');

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', JText::_('COM_COMMUNITY_FRIENDS_WAITING_AUTHORIZATION'));

        //$this->showSubMenu();

        $friends = CFactory::getModel('friends');

        $rows = !empty($data->sent) ? $data->sent : array();

        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $row->user = CFactory::getUser($row->id);
            $row->user->friendsCount = $row->user->getFriendCount();
            $row->user->profileLink = CUrlHelper::userLink($row->id);
        }

        // Featured
        $featured = new CFeatured(FEATURED_USERS);
        $featuredList = $featured->getItemIds();

        $tmpl = new CTemplate();
        echo $tmpl->set('my', $my)
                ->set('config', $config)
                ->set('rows', $rows)
                ->set('submenu', $this->showSubmenu(false))
                ->set('featuredList', $featuredList)
                ->set('pagination', $data->pagination)
                ->fetch('friends/request-sent');
    }

    public function deleteLink($controller, $method, $id) {
        $deleteLink = '<a class="remove" onClick="if(!confirm(\'' . JText::_('COM_COMMUNITY_CONFIRM_DELETE_FRIEND') . '\'))return false;" href="' . CUrl::build($controller, $method) . '&fid=' . $id . '">&nbsp;</a>';
        return $deleteLink;
    }

    /**
     * Display a list of pending friend requests
     * */
    public function pending($data = null) {
        if (!$this->accessAllowed('registered'))
            return;

        $mainframe = JFactory::getApplication();
        $config = CFactory::getConfig();

        CWindow::load();

        $my = CFactory::getUser();

        if ($my->id == 0) {
            $mainframe->enqueueMessage(JText::_('COM_COMMUNITY_PLEASE_LOGIN_WARNING'), 'error');
            return;
        }

        // Set pathway
        $this->addPathway(JText::_('COM_COMMUNITY_FRIENDS'), CRoute::_('index.php?option=com_community&view=groupschedule'));
        $this->addPathway(JText::_('COM_COMMUNITY_FRIENDS_AWAITING_AUTHORIZATION'), '');

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', JText::_('COM_COMMUNITY_FRIENDS_AWAITING_AUTHORIZATION'));

        // Load submenu
        //$this->showSubMenu();

        $rows = !empty($data->pending) ? $data->pending : array();

        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $row->user = CFactory::getUser($row->id);
            $row->user->friendsCount = $row->user->getFriendCount();
            $row->user->profileLink = CUrlHelper::userLink($row->id);
            $row->msg = $this->escape($row->msg);
        }

        //Featured
        $featured = new CFeatured(FEATURED_USERS);
        $featuredList = $featured->getItemIds();

        $tmpl = new CTemplate();
        echo $tmpl->set('rows', $rows)
                ->setRef('my', $my)
                ->set('config', $config)
                ->set('pagination', $data->pagination)
                ->set('submenu', $this->showSubmenu(false))
                ->set('featuredList', $featuredList)
                ->fetch('friends/request-received');
    }

    public function addSuccess($data = null) {
        $this->addInfo(JText::sprintf('COM_COMMUNITY_FRIENDS_WILL_RECEIVE_REQUEST', $data->name));

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', JText::_('COM_COMMUNITY_FRIEND_ADDED_SUCCESSFULLY_TITLE'));
    }

    /**
     * Show the invite window
     */
    public function invite() {
        $mainframe = JFactory::getApplication();
        $jinput = $mainframe->input;

        $jConfig = JFactory::getConfig();

        /**
         * Opengraph
         */
        CHeadHelper::setType('website', JText::sprintf('COM_COMMUNITY_FRIENDS_INVITE_FRIENDS_TITLE', $jConfig->get('sitename')));

        $my = CFactory::getUser();

        //$this->showSubmenu();

        $post = ($jinput->post->get('action', '', 'STRING') == 'invite') ? $jinput->post->getArray() : array('message' => '', 'emails' => '');

        $pathway = $mainframe->getPathway();
        $this->addPathway(JText::_('COM_COMMUNITY_FRIENDS'), CRoute::_('index.php?option=com_community&view=groupschedule'));
        $this->addPathway(JText::_('COM_COMMUNITY_INVITE_FRIENDS'), '');

        // Process the Suggest Friends
        // Load required filterbar library that will be used to display the filtering and sorting.

        $id = $jinput->getInt('userid', $my->id);
        $user = CFactory::getUser($id);
        $sorted = $jinput->get->get('sort', 'suggestion', 'STRING');
        $filter = $jinput->get->get('filter', 'suggestion', 'STRING');
        $friends = CFactory::getModel('friends');

        $rows = $friends->getFriends($id, $sorted, true, $filter);
        $resultRows = array();

        foreach ($rows as $row) {
            $user = CFactory::getUser($row->id);

            $obj = clone($row);
            $obj->friendsCount = $user->getFriendCount();
            $obj->profileLink = CUrlHelper::userLink($row->id);
            $obj->isFriend = true;
            $resultRows[] = $obj;
        }

        unset($rows);

        $app = CAppPlugins::getInstance();
        $appFields = $app->triggerEvent('onFormDisplay', array('jsform-friends-invite'));
        $beforeFormDisplay = CFormElement::renderElements($appFields, 'before');
        $afterFormDisplay = CFormElement::renderElements($appFields, 'after');

        $tmpl = new CTemplate();
        $config = CFactory::getConfig();
        $isLimit = $config->get('invite_only', 0) && (intval( $config->get('invite_registation_limit', 0) ) > 0) && !COwnerHelper::isCommunityAdmin();
        $limit = intval( $config->get('invite_registation_limit') );

        // substract limit with invitation sent
        $invitationTable = JTable::getInstance('invitation', 'CTable');
        $invitationTable->load($my->id);
        $invited = $invitationTable->getTotalInvitedUsers();
        $limit = max(0, $limit - $invited);

        echo $tmpl->set('beforeFormDisplay', $beforeFormDisplay)
                ->set('afterFormDisplay', $afterFormDisplay)
                ->set('my', $my)
                ->set('post', $post)
                ->setRef('friends', $resultRows)
                ->set('config', CFactory::getConfig())
                ->set('submenu', $this->showSubmenu(false))
                ->set('isLimit', $isLimit)
                ->set('limit', $limit)
                ->set('isAdmin', COwnerHelper::isCommunityAdmin())
                ->fetch('friends.invite');
    }

    public function news() {
        /**
         * Opengraph
         */
        CHeadHelper::setType('website', JText::_('COM_COMMUNITY_FRIENDS_FRIENDS_NEWS'));
    }

}
