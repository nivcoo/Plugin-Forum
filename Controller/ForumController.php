<?php
App::uses('ClassRegistry', 'Utility');
class ForumController extends ForumAppController {

    public $components = [
        'Security' => [
            'csrfExpires' => '+1 hour'
        ],
        'Forum.ForumPermission'
    ];

   public function beforeFilter(){
       parent::beforeFilter();
       $this->loadModel('User');
       $this->loadModel('Forum.Punishment');
       $this->loadModel('Forum.Config');

       $this->User->updateAll(array('forum-last_activity' => "'".date("Y-m-d H:i:s")."'"), array('id' => $this->Session->read('user')));
       $this->Security->csrfExpires = '+1 hour';
       if(!in_array($this->request->params['action'], ['banned', 'admin_punishment', 'admin_delete']) && $this->Punishment->get($this->getIdSession())){
           $this->redirect('/forum/banned');
       }
       if(!$this->Config->notempty()){
           $this->install();
       }

       /* update 1.0.1 */
       //$db = ConnectionManager::getDataSource('default');
       //$db->query('ALTER TABLE `forum__profiles` MODIFY `social` TEXT NULL;');
       /* AND update sql */
   }

    public function index() {
        $this->set('title_for_layout', $this->Lang->get('FORUM__TITLE'));
        $this->loadModel('Navbar');
        $this->loadModel('Forum.forums');
        $this->loadModel('Forum.Topic');

        /* Specific */
        $this->loadModel('Forum.Note');
        $this->loadModel('Forum.Historie');

        /*if($this->Config->is('privatemsg')){
            if($this->Navbar->find('count', ['conditions' => ['name' => '<i class="fa fa-envelope" aria-hidden="true"></i>']]) == 0){
                ClassRegistry::init('navbars')->saveAll(['order' => 99, 'name' => '<i class="fa fa-envelope" aria-hidden="true"></i>', 'type' => 1, 'url' => '{"type":"custom", "url":"/message"}', 'open_new_tab' => 0]);
            }
        }else{
            ClassRegistry::init('navbars')->deleteAll(['order' => 99]);
        }*/

        if(!$this->Config->is('forum')){
            throw new NotFoundException();
        }
        $perms = $this->perm_l();
        $forums = $this->Forum->getForum();
        foreach ($forums as $key => $forum) {
            if(isset($this->Topic->determine($forum['Forum']['id'])['Topic']['id_parent'])){
                $forums[$key]['Forum']['nb_discussion'] = $this->Topic->info('nb_topic', $forum['Forum']['id']);
                $forums[$key]['Forum']['nb_message'] = $this->Topic->info('nb_msg', $forum['Forum']['id']);
                $forums[$key]['Forum']['topic_last_id'] = $this->Topic->info('topic_last_id', $forum['Forum']['id']);
                $forums[$key]['Forum']['topic_last_title'] = $this->Topic->info('topic_last_title', $forum['Forum']['id']);
                $forums[$key]['Forum']['topic_last_date'] = $this->date($this->Topic->info('topic_last_date', $forum['Forum']['id']), '%d %B %Y');
                $forums[$key]['Forum']['topic_last_authorid'] = $this->Topic->info('topic_last_authorid', $forum['Forum']['id']);
                $forums[$key]['Forum']['topic_last_author_color'] = $this->ForumPermission->getRankColorDomin($forums[$key]['Forum']['topic_last_authorid']);
                $forums[$key]['Forum']['topic_last_author'] = $this->gUBY($forums[$key]['Forum']['topic_last_authorid']);
            }else{
                $forums[$key]['Forum']['nb_discussion'] = $forums[$key]['Forum']['nb_message'] = 0;
            }
        }
        $active['statistics'] = ($this->Config->is('statistics')) ? true : false;
        $active['useronline'] = ($this->Config->is('useronline')) ? true : false;
        $active['privatemsg'] = ($this->Config->is('privatemsg')) ? true : false;
        $stats = ($this->Config->is('statistics')) ? $this->Topic->stats() : null;
        if($this->Config->is('useronline')){
            $userOnlines = $this->Forum->userOnline($this->User);
            foreach ($userOnlines as $key => $userOnline){
                $userOnlines[$key]['User']['color'] = $this->ForumPermission->getRankColorDomin($userOnline['User']['id']);
            }
        }else{
            $userOnlines = null;
        }
        $my['id'] = $this->getIdSession();
        $my['user'] = $this->gUBY($this->getIdSession());
        $stats['countuser'] = count($userOnlines);
        $theme = $this->theme();

        $this->set(compact('forums', 'stats', 'userOnlines', 'active', 'my', 'perms', 'theme'));
    }

    public function forum($id, $slug){
        $this->loadModel('Forum.forums');
        $this->loadModel('Forum.Topic');
        $this->loadModel('Forum.Vieww');

        if(!$this->Config->is('forum')){
            throw new NotFoundException();
        }

        if($this->Forum->forumExist($id, $this->replaceHyppen($slug))){
            $forums = $this->Forum->getForum('categorie', $id);
            foreach ($forums as $key => $forum) {
                if(isset($this->Topic->determine($forum['Forum']['id'])['Topic']['id_parent'])){
                    $forums[$key]['Forum']['nb_discussion'] = $this->Topic->info('nb_topic', $forums[$key]['Forum']['id']);
                    $forums[$key]['Forum']['nb_message'] = $this->Topic->info('nb_msg', $forums[$key]['Forum']['id']);
                    $forums[$key]['Forum']['forum_last_id'] = $this->Topic->info('topic_last_id', $forums[$key]['Forum']['id']);
                    $forums[$key]['Forum']['forum_last_title'] = $this->Topic->info('topic_last_title', $forums[$key]['Forum']['id']);
                    $forums[$key]['Forum']['forum_last_date'] = $this->date($this->Topic->info('topic_last_date', $forums[$key]['Forum']['id']), '%d %B %Y');
                    $forums[$key]['Forum']['forum_last_authorid'] = $this->Topic->info('topic_last_authorid', $forums[$key]['Forum']['id']);
                    $forums[$key]['Forum']['forum_last_author'] = $this->gUBY($forums[$key]['Forum']['forum_last_authorid']);
                    $forums[$key]['Forum']['forum_last_author_color'] = $this->ForumPermission->getRankColorDomin($forums[$key]['Forum']['forum_last_authorid']);
                }else{
                    $forums[$key]['Forum']['nb_discussion'] = $forums[$key]['Forum']['nb_message'] = 0;
                    $forums[$key]['Forum']['forum_last_id'] = $forums[$key]['Forum']['forum_last_title'] = $forums[$key]['Forum']['forum_last_date'] = $forums[$key]['Forum']['forum_last_authorid'] = $forums[$key]['Forum']['forum_last_author'] = $forums[$key]['Forum']['forum_last_author_color'] = '';
                }
            }

            $topics_stick = $this->Topic->getTopic($id, 'stick');
            foreach ($topics_stick as $key => $topic_stick){
                $topics_stick[$key]['Topic']['forum_last_authorid'] = $this->Topic->getLastedTopic('id', $topic_stick['Topic']['id_topic'])['id_user'];
                $topics_stick[$key]['Topic']['forum_last_author'] =  $this->gUBY($topics_stick[$key]['Topic']['forum_last_authorid']);
                $topics_stick[$key]['Topic']['forum_last_title'] = $this->Topic->getLastedTopic('id', $topics_stick[$key]['Topic']['id_topic'])['name'];
                $topics_stick[$key]['Topic']['forum_last_date'] =  $this->date($this->Topic->getLastedTopic('id', $topic_stick['Topic']['id_topic'])['date']);
                $topics_stick[$key]['Topic']['author'] = $this->gUBY($topic_stick['Topic']['id_user']);
                $topics_stick[$key]['Topic']['date'] = $this->date($topic_stick['Topic']['date'], '%d %B %Y');
                $topics_stick[$key]['Topic']['nb_message'] = $this->Topic->getNbMessage('topic', $topic_stick['Topic']['id_topic']);
                $topics_stick[$key]['Topic']['topic_last_author_color'] = $this->ForumPermission->getRankColorDomin($topics_stick[$key]['Topic']['forum_last_authorid']);
                $topics_stick[$key]['Topic']['total_view'] = $this->Vieww->count($topic_stick['Topic']['id_topic']);
            }

            $topics = $this->Topic->getTopic($id, 'nostick');
            foreach ($topics as $key => $topic){
                $topics[$key]['Topic']['forum_last_authorid'] = $this->Topic->getLastedTopic('id', $topic['Topic']['id_topic'])['id_user'];
                $topics[$key]['Topic']['forum_last_author'] =  $this->gUBY($topics[$key]['Topic']['forum_last_authorid']);
                $topics[$key]['Topic']['forum_last_title'] = $this->Topic->getLastedTopic('id', $topics[$key]['Topic']['id_topic'])['name'];
                $topics[$key]['Topic']['forum_last_date'] =  $this->date($this->Topic->getLastedTopic('id', $topic['Topic']['id_topic'])['date']);
                $topics[$key]['Topic']['author'] = $this->gUBY($topic['Topic']['id_user']);
                $topics[$key]['Topic']['date'] = $this->date($topic['Topic']['date'], '%d %B %Y');
                $topics[$key]['Topic']['nb_message'] = $this->Topic->getNbMessage('topic', $topic['Topic']['id_topic']);
                $topics[$key]['Topic']['topic_last_author_color'] = $this->ForumPermission->getRankColorDomin($topics[$key]['Topic']['forum_last_authorid']);
                $topics[$key]['Topic']['total_view'] = $this->Vieww->count($topic_stick['Topic']['id_topic']);
            }
            $parent['forum_parent']['name'] = $this->replaceHyppen($slug);
            $theme = $this->theme();
            $this->set('title_for_layout', $this->replaceHyppen($slug).' | '.$this->Lang->get('FORUM__TITLE'));
            $this->set(compact('forums', 'slug', 'topics', 'topics_stick', 'parent', 'id', 'theme'));
        }else{
            throw new ForbiddenException();
        }
    }

    public function topic($id, $slug){
        $this->loadModel('Forum.forums');
        $this->loadModel('Forum.Topic');
        $this->loadModel('Forum.Note');
        $this->loadModel('Forum.MsgReport');
        $this->loadModel('Forum.Vieww');

        if(!$this->Config->is('forum')){
            throw new NotFoundException();
        }

        if(!$this->Vieww->exist($this->Util->getIP(), $id)){
           $this->Vieww->addView($this->Util->getIP(), $id);
        }

        if($this->Topic->topicExist($id, $this->replaceHyppen($slug))){
            $lock = $this->Topic->isLock($id);
            $stick = $this->Topic->isStick($id);
            if($this->request->is('ajax')) {
                if($this->isConnected) {
                    $this->autoRender = false;
                    if($this->Config->is('notemsg')){
                        if(!empty($this->request->data['json'])){
                            $idUser = $this->getIdSession();
                            $datas = json_decode($this->request->data['json']);
                            $thumb = $this->Note->search($idUser, $datas->toUser, $datas->id);
                        }
                        if (isset($thumb) && $thumb['Note']['type'] == $datas->type) {
                            if($this->Config->is('notemsg')) {
                                $this->logforum($idUser, 'remove_thumb', $this->gUBY($idUser) . $this->Lang->get('FORUM__PHRASE__HISTORY__ADD__THUMB') . strip_tags(substr($this->Topic->getMessage($datas->id)[0]['Topic']['content'], 0, 30)), '');
                                $this->Note->removeThumb($thumb['Note']['id']);
                            }
                            echo 'reverse';
                        }elseif(isset($thumb) && $thumb['Note']['type'] != $datas->type){
                            if($this->Config->is('notemsg')) {
                                $this->logforum($idUser, 'remove_thumb', $this->gUBY($idUser).$this->Lang->get('FORUM__PHRASE__HISTORY__DELETE_THUMB').strip_tags(substr($this->Topic->getMessage($datas->id)[0]['Topic']['content'], 0, 30)), '');
                                $this->Note->removeThumb($thumb['Note']['id']);
                            }
                            echo 'reset';
                        }elseif (!empty($this->request->data['idUpdate'])){
                            $id = $this->request->data['idUpdate'];
                            $message = $this->Topic->getUniqMessage($id)['content'];
                            echo $message;
                        }else{
                            if($this->Config->is('notemsg')) {
                                $this->logforum($idUser, 'add_thumb', $this->gUBY($idUser) .$this->Lang->get('FORUM__PHRASE__HISTORY__DELETE_THUMB'). strip_tags(substr($this->Topic->getMessage($datas->id)[0]['Topic']['content'], 0, 30)), '');
                                $this->Note->addThumb($idUser, $datas->toUser, $datas->id, $datas->type);
                            }
                            echo 'normal';
                        }
                    }else{
                        throw new ForbiddenException();
                    }
                }else{
                    throw new ForbiddenException();
                }
            }else{
                if($this->request->is('post')){
                    if($this->isConnected){
                        if(!empty($this->request->data['content'])) {
                            if(!$lock || $this->ForumPermission->has('FORUM_TOPIC_LOCK')){
                                $content = $this->word($this->request->data['content']);
                                $this->Topic->addMessage($this->Topic->info('id_parent', $id), $this->getIdSession(), $id, $content, date('Y-m-d H:i:s'));
                                $this->logforum($this->getIdSession(), 'add_message', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__POST__MSG').strip_tags(substr($content, 0, 30)), $content);
                                $this->Session->setFlash($this->Lang->get('FORUM__MESSAGE__SEND'), 'default.success');
                            }
                        }elseif (!empty($this->request->data['content_update'])){
                            $idMessage = $this->request->data['id'];
                            $content = str_replace("'", "\\'", $this->request->data['content_update']);
                            $content = $this->word($content);
                            if($this->ForumPermission->has('FORUM_MSG_EDIT') OR $this->ForumPermission->has('FORUM_MSGMY_EDIT')){
                                if($this->ForumPermission->has('FORUM_MSG_EDIT')){
                                    $state = true;
                                }elseif($this->ForumPermission->has('FORUM_MSGMY_EDIT')){
                                    $state = ($this->Topic->getUserId('id_user', 'id', $idMessage) == $this->getIdSession()) ? true : false;
                                }
                                if($state){
                                    $this->Topic->updateMessage($idMessage, $content);
                                    $this->logforum($this->getIdSession(), 'add_message', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__EDIT__MSG').strip_tags(substr($content, 0, 30)), $content);
                                    $this->Session->setFlash($this->Lang->get('FORUM__MESSAGE__EDITED'), 'default.success');
                                }else{
                                    $this->Session->setFlash($this->Lang->get('FORUM__PERMISSION_NECESSARY'), 'default.error');
                                }
                            }
                        }elseif (!empty($this->request->data['content_report'])){
                            if($this->Config->is('reportmsg')){
                                if($this->ForumPermission->has('FORUM_MSG_REPORT')){
                                    $idMessage = $this->request->data['id'];
                                    if($this->Topic->getUserId('id_user', 'id', $idMessage) != $this->getIdSession()){
                                        $reason = $this->request->data['reason'];
                                        $content = $this->request->data['content_report'];
                                        $this->MsgReport->report($this->getIdSession(), $idMessage, date('Y-m-d H:i:s'), $reason, $content);
                                        $this->logforum($this->getIdSession(), 'add_message', $this->gUBY($this->getIdSession()). $this->Lang->get('FORUM__PHRASE__HISTORY__REPORT__MSG') .strip_tags(substr($content, 0, 30)).$this->Lang->get('FORUM__PHRASE__HISTORY_FOR__REASON').$reason, $content);
                                        $this->Session->setFlash($this->Lang->get('FORUM__REPORT__SEND'), 'default.success');
                                    }
                                }else{
                                    $this->Session->setFlash($this->Lang->get('FORUM__PERMISSION_NECESSARY'), 'default.error');
                                }
                            }else{
                                $this->Session->setFlash($this->Lang->get('FORUM__PHRASE__FLASH__NOTREPORT__MSG'), 'default.error');
                            }
                        }elseif (!empty($this->request->data['delete'])){
                            $idMessage = $this->request->data['delete'];
                            if($this->ForumPermission->has('FORUM_MSG_DELETE') OR $this->ForumPermission->has('FORUM_MSGMY_DELETE')){
                                if($this->ForumPermission->has('FORUM_MSG_DELETE')){
                                    $state = true;
                                }elseif($this->ForumPermission->has('FORUM_MSGMY_DELETE')){
                                    $state = ($this->Topic->getUserId('id_user', 'id', $idMessage) == $this->getIdSession()) ? true : false;
                                }
                                if($state){
                                    if($this->Topic->determineIsTopic($idMessage)){
                                        if($this->ForumPermission->has('FORUM_TOPIC_DELETE') OR $this->ForumPermission->has('FORUM_TOPICMY_DELETE')) {
                                            if($this->ForumPermission->has('FORUM_TOPIC_DELETE')){
                                                $state = true;
                                            }elseif($this->ForumPermission->has('FORUM_TOPICMY_DELETE')){
                                                $state = ($this->Topic->getUserId('id_user', 'id', $idMessage) == $this->getIdSession()) ? true : false;
                                            }
                                            if($state){
                                                $idTopic = $this->Topic->getIdTopic($idMessage);
                                                $title = $this->Topic->getTitleTopic($idTopic);
                                                $this->Topic->deleteMessages($idTopic);
                                                $this->logforum($this->getIdSession(), 'delete_topic', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__DELETE__TOPIC'), $title);
                                                $this->redirect('/forum');
                                            }else{
                                                $this->Session->setFlash($this->Lang->get('FORUM__PERMISSION_NECESSARY'), 'default.error');
                                            }
                                        }else{
                                            $this->Session->setFlash($this->Lang->get('FORUM__PERMISSION_NECESSARY'), 'default.error');
                                        }
                                    }else{
                                        $this->Topic->deleteMessage($idMessage);
                                        $this->logforum($this->getIdSession(), 'delete_message', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__DELETE__MSG'), '');
                                        $this->Session->setFlash($this->Lang->get('FORUM__MESSAGE__DELETE'), 'default.success');
                                    }
                                }else{
                                    $this->Session->setFlash($this->Lang->get('FORUM__PERMISSION_NECESSARY'), 'default.error');
                                }
                            }
                        }elseif(!empty($this->request->data['deleteall'])){
                            if($this->ForumPermission->has('FORUM_TOPIC_DELETE') OR $this->ForumPermission->has('FORUM_TOPICMY_DELETE')){
                                $this->Topic->deleteMessages($id);
                                $this->logforum($this->getIdSession(), 'delete_topic', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__DELETE__TOPIC'), $this->replaceHyppen($slug));
                                $this->redirect('/forum');
                            }else{
                                throw new ForbiddenException();
                            }
                        }elseif(!empty($this->request->data['stick'])){
                            if($this->ForumPermission->has('FORUM_TOPIC_STICK')){
                                if($stick){
                                    $this->Topic->change('unstick', $this->request->data['stick']);
                                    $this->logforum($this->getIdSession(), 'unstick_topic', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__UNSTICK__TOPIC'), $this->replaceHyppen($slug));
                                    $this->Session->setFlash($this->Lang->get('FORUM__TOPIC__UNSTICK'), 'default.success');
                                }else{
                                    $this->Topic->change('stick', $this->request->data['stick']);
                                    $this->logforum($this->getIdSession(), 'stick_topic', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__STICK__TOPIC'), $this->replaceHyppen($slug));
                                    $this->Session->setFlash($this->Lang->get('FORUM__TOPIC__STICK'), 'default.success');
                                }
                                $this->redirect('/topic/'.$slug.'.'.$id.'/');
                            }else{
                                throw new ForbiddenException();
                            }
                        }elseif(!empty($this->request->data['lock'])){
                            if($this->ForumPermission->has('FORUM_TOPIC_LOCK')){
                                if($lock){
                                    $this->Topic->change('unlock', $this->request->data['lock']);
                                    $this->logforum($this->getIdSession(), 'unlock_topic', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__UNLOCK__TOPIC'), $this->replaceHyppen($slug));
                                    $this->Session->setFlash($this->Lang->get('FORUM__TOPIC__UNLOCK'), 'default.success');
                                }else{
                                    $this->Topic->change('lock', $this->request->data['lock']);
                                    $this->logforum($this->getIdSession(), 'lock_topic', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__LOCK__TOPIC'), $this->replaceHyppen($slug));
                                    $this->Session->setFlash($this->Lang->get('FORUM__TOPIC__LOCK'), 'default.success');
                                }
                                $this->redirect('/topic/'.$slug.'.'.$id.'/');
                            }else{
                                throw new ForbiddenException();
                            }
                        }else{
                            $this->Session->setFlash($this->Lang->get('FORUM__TOPIC__MESSAGE_ERROR'), 'default.danger');
                        }
                    }else{
                        throw new ForbiddenException();
                    }
                }

                $msgs = $this->Topic->getMessage($id);
                foreach ($msgs as $key => $msg){
                    $user_id = $msg['Topic']['id_user'];
                    $msgs[$key]['Topic']['thumb_info']['green'] = $this->Note->isNoted('green', $msg['Topic']['id'] , $this->getIdSession());
                    $msgs[$key]['Topic']['thumb_info']['red'] = $this->Note->isNoted('red', $msg['Topic']['id'] , $this->getIdSession());
                    $msgs[$key]['Topic']['author_info']['nb_message'] = $this->Topic->getNbMessage('user', $user_id);
                    $msgs[$key]['Topic']['author_info']['thumb']['green'] = $this->Note->getNbThumb('green', $user_id);
                    $msgs[$key]['Topic']['author_info']['thumb']['red'] = $this->Note->getNbThumb('red', $user_id);
                    $msgs[$key]['Topic']['author_info']['inscription'] = $this->date($this->dateInscription($user_id));
                    $msgs[$key]['Topic']['author_info']['rank'] = $this->ForumPermission->getRank($user_id);
                    $msgs[$key]['Topic']['author_info']['color'] = $this->ForumPermission->getRankColor($user_id);
                    $msgs[$key]['Topic']['author_color'] = $this->ForumPermission->getRankColorDomin($user_id);

                    $msgs[$key]['Topic']['author'] = $this->gUBY($user_id);
                    $msgs[$key]['Topic']['date'] = $this->dateAndTime($msg['Topic']['date'], '%d %B %Y');
                    if($key == 0){
                        $parent['forum_parent']['name'] = ($this->Forum->info('parent_title', $msgs[0]['Topic']['id_parent'])) ? $this->Forum->info('parent_title', $msgs[0]['Topic']['id_parent'])['Forum']['forum_name'] : '';
                        $parent['forum_parent']['href'] = (!empty($parent['forum_parent']['name'])) ? $parent['forum_parent']['name'].".".$this->Forum->info('parent_title', $msgs[0]['Topic']['id_parent'])['Forum']['id'] : '';
                    }
                    $msgs[$key]['Topic']['thumb']['green'] = $this->Note->getNbThumb('msg_green', $msg['Topic']['id']);
                    $msgs[$key]['Topic']['thumb']['red'] = $this->Note->getNbThumb('msg_red', $msg['Topic']['id']);
                }
                $active['notemsg'] = ($this->Config->is('notemsg')) ? true : false;
                $active['reportmsg'] = ($this->Config->is('reportmsg')) ? true : false;
                $perms = $this->perm_l();
                $theme = $this->theme();

                $this->set('title_for_layout', $this->replaceHyppen($slug).' | '.$this->Lang->get('FORUM__TITLE'));
                $this->set(compact('msgs', 'parent', 'active', 'perms', 'lock', 'id', 'stick', 'theme'));
            }
        }else{
            throw new ForbiddenException();
        }
    }

    public function addTopic($idParent = false){
        $this->set('title_for_layout', $this->Lang->get('FORUM__ADD__TOPIC'));
        $this->loadModel('Forum.Topic');

        if(!$this->Config->is('forum') OR !$this->ForumPermission->has('FORUM_TOPIC_SEND')){
            throw new NotFoundException();
        }

        if($this->request->is('post') && $this->isConnected){
            if(!empty($this->request->data['title']) && !empty($this->request->data['content_insert'])){
                $stick = $lock = 0;
                if($this->ForumPermission->has('FORUM_TOPIC_STICK')){
                    if(!empty($this->request->data['stick']))$stick = 1;
                }
                if($this->ForumPermission->has('FORUM_TOPIC_LOCK')){
                    if(!empty($this->request->data['lock'])) $lock = 1;
                }
                $content = $this->word($this->request->data['content_insert']);
                $title = $this->urlRew($this->request->data['title']);
                $params = $this->Topic->addTopic($idParent, $this->getIdSession(), $title, $stick, $lock, $content);
                $this->logforum($this->getIdSession(), 'create_topic', $this->gUBY($this->getIdSession()).' vient de créer un nouveau topic : '.strip_tags(substr($content, 0, 30)), $content);
                return $this->redirect('/topic/'.$this->replaceSpace($params['title']).'.'.$params['id'].'/');
            }else{
                if(!empty($this->request->data['title'])){
                    $this->Session->setFlash('Vous devez insérer un titre à votre topic !', 'default.error');
                }elseif(!empty($this->request->data['content_insert'])){
                    $this->Session->setFlash('Votre topic doit contenir un message !', 'default.error');
                }
            }
        }elseif($this->request->is('get') && $this->isConnected){
            $configs['stick'] = ($this->ForumPermission->has('FORUM_TOPIC_STICK')) ? true : false;
            $configs['lock'] = ($this->ForumPermission->has('FORUM_TOPIC_LOCK')) ? true : false;
            $theme = $this->theme();
            $this->set(compact('configs', 'theme'));
        }else{
            throw new ForbiddenException();
        }
    }

    public function report(){
        if($this->ForumPermission->has('FORUM_VIEW_REPORT')){
            $this->set('title_for_layout', $this->Lang->get('FORUM__MSGREPORT'));
            $this->loadModel('Forum.MsgReport');
            $this->loadModel('Forum.Topic');
            if($this->request->is('post')){
                $id = $this->request->data['id'];
                $this->logforum($this->getIdSession(), 'delete_report', $this->gUBY($this->getIdSession()).' vient de supprimer un signalement', $id);
                $this->MsgReport->deleteReport($id);
            }
            $msgreports = $this->MsgReport->get();
            foreach ($msgreports as $key => $msgreport){
                $msgreports[$key]['MsgReport']['user'] = $this->gUBY($msgreport['MsgReport']['id_user']);
                $msgreports[$key]['MsgReport']['date'] = $this->dateAndTime($msgreport['MsgReport']['date']);
                $idTopic = $this->Topic->getUniqMessage($msgreport['MsgReport']['id_msg'])['id_topic'];
                $msgreports[$key]['MsgReport']['href'] = $this->replaceSpace($this->Topic->getTitleTopic($idTopic)).'.'.$this->Topic->getIdTopic($idTopic);
            }
            $theme = $this->theme();
            $this->set(compact('msgreports', 'theme'));
        }else{
            throw new ForbiddenException();
        }
    }

    public function banned(){
        if($this->Punishment->get($this->getIdSession())){
            $this->set('title_for_layout', $this->Lang->get('FORUM__BANNED'));
            $infos = $this->Punishment->get($this->getIdSession());
            $infos['date'] = $this->dateAndTime($infos['date']);
            $infos['user'] = $this->gUBY($infos['id_user']);
            $theme = $this->theme();
            $this->set(compact('infos', 'theme'));
        }else{
            $this->redirect('/forum');
        }
    }

    /*
     * Admin pages
     */

    public function admin_index(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('Forum.Topic');
            $this->loadModel('Forum.Note');
            $configs = $this->Config->get();
            $stats = $this->Topic->stats();
            if($this->request->is('ajax')){
                $this->autoRender = false;
                if(!empty($this->request->data['config'])){
                    foreach ($configs as $config){
                        $this->Config->updateConfig($config['Config']['config_name'], $this->request->data[$config['Config']['config_name']]);
                    }
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__CONFIG__SUCCESS'))));
                } elseif(!empty($this->request->data['drop'])){
                    $this->dropHistory();
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__HISTORY__DROP'))));
                } elseif(!empty($this->request->data['install'])){
                    $this->install();
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__CONFIG__INSTALLED'))));
                } else{
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ERROR'))));
                }
            }else{
                $this->layout = 'admin';
                $userOnlines = $this->Forum->userOnline($this->User);
                foreach ($userOnlines as $key => $userOnline){
                    $userOnlines[$key]['User']['color'] = @$this->ForumPermission->getRankColorDomin($userOnline['User']['id']);
                }
                $stats['countuser'] = count($userOnlines);
                $stats['thumbgreen'] = $this->Note->getNbThumb('total_green');
                $stats['thumbred'] = $this->Note->getNbThumb('total_red');
                $remoteMsg = $this->remoteAction('ADMINMSG');

                $this->set(compact('configs', 'stats', 'userOnlines', 'remoteMsg'));
            }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_forum(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->layout = 'admin';
            $this->loadModel('Forum.forums');

            $forums = $this->Forum->getForum('forum');
            $this->set(compact('forums'));

        }else {
            $this->redirect('/');
        }
    }

    public function admin_category(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->layout = 'admin';
            $this->loadModel('Forum.forums');
            $forums = $this->Forum->getForum('withoutforum');
            foreach ($forums as $key => $forum){
                $forums[$key]['Forum']['parent'] = $this->Forum->info('parent_title', $forum['Forum']['id_parent'])['Forum']['forum_name'];
            }

            $this->set(compact('forums'));
        }else {
            $this->redirect('/');
        }
    }

    public function admin_add_forum(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->set('title_for_layout', $this->Lang->get('FORUM__ADD__FORUM'));
            $this->layout = 'admin';
            $this->loadModel('Forum.forums');
            $forums = $this->Forum->getForum('forum');
            if($this->request->is('ajax')) {
                $this->autoRender = false;
                if(!empty($this->request->data['name']) && !empty($this->request->data['position']) && !empty($this->request->data['image'])) {
                    $this->Forum->addForum($this->getIdSession(), $this->request->data['name'], $this->request->data['position'], $this->request->data['image']);
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__ADD__SUCCESS'))));
                }else{
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ADD__FAILED'))));
                }
            }
            $this->set(compact('forums'));
        }else {
            $this->redirect('/');
        }
    }

    public function admin_add_category(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->set('title_for_layout', $this->Lang->get('FORUM__ADD__CATEGORY'));
            $this->layout = 'admin';
            $this->loadModel('Forum.forums');
            $forums = $this->Forum->getForum();
            if($this->request->is('ajax')) {
                $this->autoRender = false;
                if(!empty($this->request->data['name']) && !empty($this->request->data['position']) && !empty($this->request->data['parent']) && !empty($this->request->data['image'])) {
                    $this->Forum->addCategory($this->getIdSession(), $this->request->data['name'], $this->request->data['position'], $this->request->data['parent'], $this->request->data['image']);
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__ADD__SUCCESS'))));
                }else{
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ADD__FAILED'))));
                }
            }
            $this->set(compact('forums'));
        }else {
            $this->redirect('/');
        }
    }

    public function admin_delete($type = false, $id = false){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->autoRender = false;
            if($this->request->is('get')) {
                if($type != false && $id != false) {
                    $this->loadModel('Forum.forums');
                    $this->loadModel('Forum.Insult');
                    $this->loadModel('Forum.Group');
                    $this->loadModel('Forum.Topic');
                    $this->loadModel('Forum.ForumPermission');
                    $this->loadModel('Forum.MsgReport');
                    $this->loadModel('Forum.Punishment');
                    if($type == 'forum'){
                        $this->logforum($this->getIdSession(), 'delete_forum', $this->gUBY($this->getIdSession()).' vient de supprimer un forum ', $id);
                        $this->Forum->admin_delete($id);
                    }elseif ($type == 'category'){
                        $this->logforum($this->getIdSession(), 'delete_category', $this->gUBY($this->getIdSession()).' vient de supprimer une catégorie ', $id);
                        $this->Forum->admin_delete($id);
                    }elseif ($type == 'word'){
                        $this->logforum($this->getIdSession(), 'delete_word', $this->gUBY($this->getIdSession()).' vient de supprimer un mot interdit', $id);
                        $this->Insult->deleteWord($id);
                    }elseif ($type == 'rank'){
                        $this->logforum($this->getIdSession(), 'delete_group', $this->gUBY($this->getIdSession()).' vient de supprimer un groupe', $id);
                        $this->Group->deleteGroup($id);
                    }elseif ($type == 'permission'){
                        $this->logforum($this->getIdSession(), 'delete_permission', $this->gUBY($this->getIdSession()).' vient de supprimer une permission', $id);
                        $this->ForumPermission->deletePermission($id);
                    }elseif ($type == 'report'){
                        $this->logforum($this->getIdSession(), 'delete_report', $this->gUBY($this->getIdSession()).' vient de supprimer un signalement', $id);
                        $this->MsgReport->deleteReport($id);
                    }elseif ($type == 'punishment'){
                        $this->logforum($this->getIdSession(), 'delete_punishment', $this->gUBY($this->getIdSession()).' vient de supprimer une sanction', $id);
                        $this->Punishment->deletePunish($id);
                    }elseif ($type == 'topic'){
                        $this->logforum($this->getIdSession(), 'delete_topic', $this->gUBY($this->getIdSession()).' vient de supprimer un topic', $id);
                        $this->Topic->deleteMessages($id);
                    }
                    $this->redirect('/admin/forum/forum/'.$type);
                }else {
                    throw new ForbiddenException();
                }
            } else {
                throw new ForbiddenException();
            }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_edit($type = false, $id = false){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('Forum.forums');
            $this->loadModel('Forum.Profile');
            $this->loadModel('Forum.Historie');
            $this->loadModel('Forum.MsgReport');
            if($this->request->is('ajax')) {
                $this->autoRender = false;
                if(!empty($this->request->data['name']) && !empty($this->request->data['position']) && !empty($this->request->data['image'])) {
                    $name = $this->request->data['name'];
                    $position = $this->request->data['position'];
                    $image = $this->request->data['image'];
                    $this->Forum->update('forum', $this->request->data['id'], ['name' => $name, 'position' => $position, 'image' => $image]);
                    $this->logforum($this->getIdSession(), 'create_forum', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__CREATE__FORUM').strip_tags(substr($name, 0, 30)).' en position : '.$position, $name, $image);
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__ADD__SUCCESS'))));
                }elseif(!empty($this->request->data['name_category'])) {
                    $name = $this->request->data['name_category'];
                    $parent = $this->request->data['parent'];
                    $position = $this->request->data['position'];
                    $image = $this->request->data['image'];
                    $this->Forum->update('category', $this->request->data['id'], ['name' => $name, 'id_parent' => $parent, 'position' => $position, 'forum_image' => $image]);
                    $this->logforum($this->getIdSession(), 'create_forum', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__EDIT__CATEGORY'), $name);
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__ADD__SUCCESS'))));
                }elseif(!empty($this->request->data['useredit'])){
                    $this->Profile->updateProfile($this->request->data['description'], $this->request->data['useredit']);
                    $idGroups = $this->request->data['idgroup'];
                    $groups = explode(',', $idGroups);
                    $domin = (isset($this->request->data['domin'])) ? $this->request->data['domin'] : false;
                    foreach ($groups as $key => $value){
                        $this->ForumPermission->updateGroup($this->request->data['rank_'.$value], $domin, $this->request->data['useredit'], $value);
                    }
                    $this->logforum($this->getIdSession(), 'edit_permission', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__EDITPERM__USER').$this->gUBY($this->request->data['useredit']), '');
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__USER__EDIT'))));
                }elseif (!empty($this->request->data['color']) && !empty($this->request->data['name'])){
                    $id = $this->request->data['id'];
                    $name = $this->request->data['name'];
                    $description = $this->request->data['description'];
                    $color = $this->request->data['color'];
                    $this->ForumPermission->updateRank($name, $description, $color, $id);
                    $this->logforum($this->getIdSession(), 'edit_rank', $this->gUBY($this->getIdSession()).$this->Lang->get('FORUM__PHRASE__HISTORY__EDIT__GROUP'), $name);
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__ADD__SUCCESS'))));
                }else{
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ADD__FAILED'))));
                }
            }else{
                if($type != false && $id != false){
                    $this->layout = 'admin';
                    if($type == 'forum'){
                        $datas = $this->Forum->info('forum', $id)[0]['Forum'];
                        $forums = $this->Forum->getForum('forum');
                        $this->set(compact('datas', 'forums', 'type'));
                    }elseif($type == 'category'){
                        $datas = $this->Forum->getForum('id', $id);
                        $datas['Forum']['actualparent'] = $this->Forum->info('parent_title', $datas['Forum']['id_parent'])['Forum']['forum_name'];
                        $forums = $this->Forum->getForum();
                        $categorys = $this->Forum->getForum('withoutforum');
                        $this->set(compact('datas', 'forums', 'type', 'categorys'));
                    }elseif($type == 'user'){
                        $datas['user']['id'] = $id;
                        $datas['user']['username'] = $this->gUBY($id);
                        $datas['user']['lastseen'] = $this->dateAndTime($this->lastSeen($id));
                        $datas['rank']['idgroup'] = $this->ForumPermission->getIdGroup($id);
                        $datas['rank']['domin'] = $this->ForumPermission->getDomin($id);
                        $datas['rank']['rankbis'] = ($this->ForumPermission->getRank($id)) ? $this->ForumPermission->getRank($id, 'advanced') : '';
                        $datas['rank']['rank'] = $this->ForumPermission->getRanks();
                        $datas['profile'] = $this->Profile->get($id);
                        $datas['rank']['allrank'] = $this->ForumPermission->getRanks();
                        $datas['rank']['r'] = '';
                        foreach ($datas['rank']['allrank'] as $key => $r){
                            $s = (!$key) ? '' : ',';
                            $datas['rank']['r'] .= $s.$r['Group']['id'];
                        }
                        $history = $this->Historie->_list($id);
                        foreach ($history as $key => $h){
                            $history[$key]['Historie']['date'] = $this->dateAndTime($h['Historie']['date']);
                        }
                        $msgReport = $this->MsgReport->get($id);
                        foreach ($msgReport as $key => $m){
                            $msgReport[$key]['MsgReport']['date'] = $this->dateAndTime($m['MsgReport']['date']);
                        }
                        $this->set(compact('datas', 'type', 'history', 'msgReport'));
                    }elseif($type == 'rank'){
                        $datas = $this->ForumPermission->getRanks($id);
                        $this->set(compact('datas', 'type'));
                    }else{
                        throw new ForbiddenException();
                    }
                }else{
                    throw new ForbiddenException();
                }
            }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_switch($type = false, $id = false){
        if($this->isConnected AND $this->User->isAdmin()) {
            if($this->request->is('get')) {
                if($type != false && $id != false){
                    $this->autoRender = false;
                    if($type == 'permission'){
                        $this->loadModel('Forum.ForumPermission');
                        $this->ForumPermission->_switch($id);
                        $this->logforum($this->getIdSession(), 'edit_group', $this->gUBY($this->getIdSession()).' vient de modifier l\'autorisation d\'un groupe : '.$id, '');
                    }
                    $this->redirect('/admin/forum/forum/'.$type);
                }
            }else{
                throw new ForbiddenException();
            }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_word(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('Forum.Insult');
            if($this->request->is('ajax')){
                $this->autoRender = false;
                if(!empty($this->request->data['word'])){
                    $this->Insult->add($this->request->data['word'], $this->request->data['replace']);
                    $this->logforum($this->getIdSession(), 'add_word', $this->gUBY($this->getIdSession()).'vient d\'ajouter un mot interdit', $this->request->data['word'].' -> '.$this->request->data['replace']);
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__ADD__WORD'))));
                }else{
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ADD__FAILED'))));
                }
            }else{
                $this->layout = 'admin';

                $words = $this->Insult->get();
                $this->set(compact('words'));
            }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_history(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('Forum.Historie');
            if($this->request->is('ajax')){
                $this->autoRender = false;
                if(!empty($this->request->data['drop'])){
                    $this->dropHistory();
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__HISTORY__DROP'))));
                } else{
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ERROR'))));
                }
            }else{
                $this->layout = 'admin';

                $history = $this->Historie->get();
                foreach ($history as $key => $h) {
                    $history[$key]['Historie']['pseudo'] = $this->gUBY($h['Historie']['id_user']);
                    $history[$key]['Historie']['date'] = $this->dateAndTime($h['Historie']['date']);
                }
                $this->set(compact('history'));
            }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_permission(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('Forum.ForumPermission');
            $this->loadModel('Forum.Group');
            if($this->request->is('ajax')){
                $this->autoRender = false;
                if(!empty($this->request->data['rank']) && !empty($this->request->data['permission']) && isset($this->request->data['access'])){
                    $newRank = $this->request->data['rank'];
                    $newPermission = $this->request->data['permission'];
                    $newAccess = $this->request->data['access'];
                    if($newAccess == 0 OR $newAccess == 1){
                        if(!$this->ForumPermission->permissionExist($newRank, $newPermission)){
                            $permissions = $this->ForumPermission->get();
                            $state = false;
                            foreach ($permissions as $permission){
                                if($permission['ForumPermission']['name'] == $this->request->data['permission']) $state = true;
                            }
                            if($state){
                                $this->logforum($this->getIdSession(), 'add_permission', $this->gUBY($this->getIdSession()).' vient d\'ajouter une permission à un groupe : '.$newRank.' '.$newPermission, '');
                                $this->ForumPermission->addPermission($newRank, $newPermission, $newAccess);
                                $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__PERMISSION__ADD'))));
                            }else{
                                $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__PERMISSION__ADD__FAILED'))));
                            }
                        }else{
                            $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__PERMISSION__EXIST'))));
                        }
                    }
                }else{
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ADD__FAILED'))));
                }
            }else{
                $this->layout = 'admin';
                $permissions = $this->ForumPermission->get();
                $groups = $this->Group->get();
                foreach ($permissions as $key => $permission){
                    $rank = @$this->Group->getName($permission['ForumPermission']['group_id']);
                    $permissions[$key]['ForumPermission']['group_name'] = ($rank) ? $rank : $this->Lang->get('FORUM__RANK__BASIC');
                    $permissions[$key]['ForumPermission']['state'] = ($permission['ForumPermission']['value'] == 1) ? '<i class="fa fa-check" style="color: #5cb85c" aria-hidden="true"></i>' : '<i class="fa fa-times" style="color: #d9534f" aria-hidden="true"></i>';
                }
                $lastperm = '';
                $this->set(compact('permissions', 'groups', 'lastperm'));
            }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_rank(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('Forum.Group');
           if($this->request->is('ajax')){
               $this->autoRender = false;
               if(!empty($this->request->data['rank']) && !empty($this->request->data['description']) && !empty($this->request->data['color'])){
                    $this->Group->addGroup($this->request->data['rank'], $this->request->data['description'], $this->request->data['color']);
                   $this->logforum($this->getIdSession(), 'add_group', $this->gUBY($this->getIdSession()).' vient d\'ajouter un groupe : '.$this->request->data['name'], $this->request->data['description']);
                   $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__ADD__GROUP'))));
               }else{
                   $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ADD__FAILED'))));
               }
           }else{
               $this->layout = 'admin';
               $groups = $this->Group->get();
               $this->set(compact('groups'));
           }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_user(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('User');
            $this->layout = 'admin';

            $users = $this->User->find('all');
            foreach ($users as $key => $user){
                $users[$key]['User']['rank'] = $users[$key]['User']['color'] = '';
                $users[$key]['User']['rank'] = ($this->ForumPermission->getRank($user['User']['id'])) ? $this->ForumPermission->getRank($user['User']['id']) : '';
                $users[$key]['User']['color'] = ($this->ForumPermission->getRankColor($user['User']['id'])) ? $this->ForumPermission->getRankColor($user['User']['id']) : '';
            }

            $this->set(compact('users'));
        }else {
            $this->redirect('/');
        }
    }

    public function admin_punishment(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('Forum.Punishment');
            if($this->request->is('ajax')){
                $this->autoRender = false;
                if(!empty($this->request->data['pseudo'])&& !empty($this->request->data['date']) && !empty($this->request->data['reason'])){
                    $idto = $this->User->getFromUser('id', $this->request->data['pseudo']);
                    if($idto){
                        $date = date('Y-m-d H:i:s', strtotime($this->request->data['date']));
                        $reason = $this->request->data['reason'];
                        $this->Punishment->addPunish($this->getIdSession(), $idto, $date, $reason);
                        $this->logforum($this->getIdSession(), 'add_punishment', $this->gUBY($this->getIdSession()).' vient d\'ajouter une sanction', $this->request->data['pseudo']);
                        $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('FORUM__ADD__PUNISHMENT'))));
                    }else{
                        $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ADD__USERUNKNOW'))));
                    }
                }else{
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('FORUM__ADD__FAILED'))));
                }
            }else{
                $this->layout = 'admin';
                $bannis = $this->Punishment->get();
                foreach ($bannis as $key => $banni){
                    $bannis[$key]['Punishment']['user'] = $this->gUBY($banni['Punishment']['id_user']);
                    $bannis[$key]['Punishment']['userto'] = $this->gUBY($banni['Punishment']['id_to_user']);
                    $bannis[$key]['Punishment']['date'] = $this->dateAndTime($banni['Punishment']['date']);
                }

                $this->set(compact('bannis'));
            }
        }else {
            $this->redirect('/');
        }
    }

    public function admin_report(){
        if($this->isConnected AND $this->User->isAdmin()) {
            $this->loadModel('Forum.MsgReport');
            $this->loadModel('Forum.MsgReport');
            $this->loadModel('Forum.Topic');
            $this->layout = 'admin';
            $msgreports = $this->MsgReport->get();
            foreach ($msgreports as $key => $msgreport){
                $msgreports[$key]['MsgReport']['user'] = $this->gUBY($msgreport['MsgReport']['id_user']);
                $msgreports[$key]['MsgReport']['date'] = $this->dateAndTime($msgreport['MsgReport']['date']);
                $idTopic = $this->Topic->getUniqMessage($msgreport['MsgReport']['id_msg'])['id_topic'];
                $msgreports[$key]['MsgReport']['href'] = $this->replaceSpace($this->Topic->getTitleTopic($idTopic)).'.'.$this->Topic->getIdTopic($idTopic);
            }

            $this->set(compact('msgreports'));
        }else {
            $this->redirect('/');
        }
    }

    public function admin_topic(){
        if($this->isConnected AND $this->User->isAdmin()){
            $this->loadModel('Forum.Topic');
            $this->layout = 'admin';
            $topics = $this->Topic->getTopic(0, 'topic');
            foreach ($topics as $key => $topic){
                $topics[$key]['Topic']['author'] = $this->gUBY($topic['Topic']['id_user']);
                $topics[$key]['Topic']['date'] = $this->dateAndTime($topic['Topic']['date']);
                $topics[$key]['Topic']['href'] = $this->replaceSpace($topic['Topic']['name']).'.'.$topic['Topic']['id'];
            }

            $this->set(compact('topics'));
        }else {
            $this->redirect('/');
        }
    }

    /*
     * Function calc, back end ...
     */

    public function replaceSpace($string = false){
        return str_replace(" ", "-", $string);
    }

    public function replaceHyppen($string = false){
        return str_replace("-", " ", $string);
    }

    private function install(){
        /*
         * Add Model WHERE for the default installation
         */
        $models = ['Config', 'Forum', 'Group', 'Groups_user', 'Historie', 'Insult', 'Note', 'ForumPermission', 'Topic'];
        foreach ($models as $model){
            $this->loadModel('Forum.'.$model);
            $table = lcfirst($model);
            if($model != 'ForumPermission'){
                $this->$model->query('TRUNCATE TABLE forum__'.$table.'s');
            }
        }
        // And Exeption Model & Table
        $this->loadModel('Forum.MsgReport');
        $this->loadModel('Forum.ForumPermission');
        $this->$model->query('TRUNCATE TABLE forum__msg_reports');
        $this->$model->query('TRUNCATE TABLE forum__forum_permissions');

        $install = $this->installArray();

        foreach ($models as $model){
            if($model != 'ForumPermission'){
                $table = lcfirst($model);
                $this->$model->saveAll($install[$table]);
            }else{
                $this->$model->saveAll($install['forum_permission']);
            }
        }
        $this->ForumPermission = $this->Components->load('Forum.ForumPermission');
    }

    private function word($string){
        $this->loadModel('Forum.Insult');
        $words = $this->Insult->get();
        foreach ($words as $word){
            $string = str_ireplace($word['Insult']['word'], $word['Insult']['replace'], $string);
        }
        return $string;
    }

    private function dropHistory(){
        $this->loadModel('Forum.Historie');
        $this->Historie->drop($this->Util->getIP(), $this->getIdSession());
    }

    private function perm_l(){
        return $this->ForumPermission->perm_l();
    }

    private function remoteAction($type, $value = false){
        $options = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ]
        ];

        if($type == 'ADMINMSG'){
            $json = $this->core();
            $jsonLastVersion = file_get_contents('https://www.phpierre.fr/mineweb/forum/lastversion/'.$json, false, stream_context_create($options));
            $lastVersion = json_decode($jsonLastVersion, true)['version'];
            if($this->version != $lastVersion){
                $jsonMsgadmin = file_get_contents('https://www.phpierre.fr/mineweb/forum/msgadmin/e/', false, stream_context_create($options));
                $msg = json_decode($jsonMsgadmin, true)['msg'];
                $site = $_SERVER['SERVER_NAME'];
                $msg = str_replace('[LIEN]', $site, $msg);
                return $msg;
            }else{
                return '';
            }
        }
    }

    private function reset(){
        $models = ['Config', 'Conversation', 'ConversationRecipient', 'Forum', 'Group', 'Groups_user', 'Historie', 'Insult', 'MsgReport', 'Note', 'Profile', 'ForumPermission', 'Punishment', 'Topic', 'Vieww'];
        foreach ($models as $model){
            $this->loadModel('Forum.'.$model);
            $table = lcfirst($model);
            if($model != 'ForumPermission' OR $model != 'MsgReport' OR $model != 'ConversationRecipient'){
                $this->$model->query('TRUNCATE TABLE forum__'.$table.'s');
            }
        }
        $this->$model->query('TRUNCATE TABLE forum__msg_reports');
        $this->$model->query('TRUNCATE TABLE forum__forum_permissions');
        $this->$model->query('TRUNCATE TABLE forum__conversation_recipients');

        $install = $this->installArray();
        $this->ForumPermission->saveAll($install['forum_permission']);
        $this->Config->saveAll($install['config']);

        $this->ForumPermission = $this->Components->load('Forum.ForumPermission');
    }

    public function debug(){
        $this->autoRender = null;
        header('Content-Type: application/json');
        echo '{"forum_version":"'.$this->version.'"}';
    }

    public function installArray(){
        $date = date("Y-m-d H:i:s");
        $array = [
            'config' => [
                ['config_name' => 'useronline', 'config_value' => true, 'lang' => 'Utilisateur en ligne'],
                ['config_name' => 'statistics', 'config_value' => true, 'lang' => 'Statistiques'],
                ['config_name' => 'privatemsg', 'config_value' => true, 'lang' => 'Message privés'],
                ['config_name' => 'reportmsg', 'config_value' => true, 'lang' => 'Signaler les messages'],
                ['config_name' => 'notemsg', 'config_value' => true, 'lang' => 'Noter les messages'],
                ['config_name' => 'userpage', 'config_value' => true, 'lang' => 'Profil utilisateur du forum'],
                ['config_name' => 'forum', 'config_value' => true, 'lang' => 'Forum']
            ],
            'forum' => [
                ['id_parent' => 0, 'id_user' => 1, 'position' => 1, 'forum_name' => 'Mineweb', 'forum_description' => 'Ceci est une description', 'forum_image' => 'folder-open'],
                ['id_parent' => 0, 'id_user' => 1, 'position' => 2, 'forum_name' => 'Support', 'forum_description' => 'Ceci est une description', 'forum_image' => 'folder-open'],
                ['id_parent' => 0, 'id_user' => 1, 'position' => 2, 'forum_name' => 'Documentation', 'forum_description' => 'Ceci est une description', 'forum_image' => 'folder-open'],

                ['id_parent' => 1, 'id_user' => 1, 'position' => 1, 'forum_name' => 'Règlement', 'forum_description' => 'Ceci est une description', 'forum_image' => 'folder-open'],
                ['id_parent' => 1, 'id_user' => 1, 'position' => 1, 'forum_name' => 'Catégorie random', 'forum_description' => 'Ceci est une description', 'forum_image' => 'folder-open'],

                ['id_parent' => 4, 'id_user' => 1, 'position' => 1, 'forum_name' => 'Catégorie random', 'forum_description' => 'Ceci est une description', 'forum_image' => 'folder-open'],
            ],
            'group' => [
                ['group_name' => 'Administrateur', 'group_description' => 'Ceci est le groupe des administrateurs du serveur Minecraft', 'color' => 'e74c3c'],
                ['group_name' => 'Modérateur', 'group_description' => 'Ceci est le groupe des modérateurs du serveur Minecraft', 'color' => 'e67e22'],
                ['group_name' => 'Développeur', 'group_description' => 'Ceci est le groupe des développeurs du serveur Minecraft', 'color' => '2ecc71'],
            ],
            'groups_user' => [
                ['id_user' => 1, 'id_group' => 1, 'domin' => true],
                ['id_user' => 1, 'id_group' => 2],
                ['id_user' => 1, 'id_group' => 3],
            ],
            'historie' => [
                ['date' => $date, 'id_user' => 1, 'ip' => $this->Util->getIP(), 'category' => 'general', 'action' => 'Configuration de base du site', 'content' => ''],
            ],
            'insult' => [
                ['word' => 'merde', 'replace' => 'm****'],
                ['word' => 'putin', 'replace' => 'p****'],
                ['word' => 'fdp', 'replace' => ''],
            ],
            'note' => [
                ['id_user' => 1, 'id_to_user'  => 1, 'id_message' => 1, 'type' => 1],
            ],
            'forum_permission' => [
                ['group_id' => 1, 'name' => 'FORUM_MP_SEND', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_MP_SEND', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_MP_SEND', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_MP_SEND', 'value' => 1],
                ['group_id' => 1, 'name' => 'FORUM_MP_REPLY', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_MP_REPLY', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_MP_REPLY', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_MP_REPLY', 'value' => 1],
                ['group_id' => 1, 'name' => 'FORUM_TOPIC_SEND', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_TOPIC_SEND', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_TOPIC_SEND', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_TOPIC_SEND', 'value' => 1],
                ['group_id' => 1, 'name' => 'FORUM_TOPIC_REPLY', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_TOPIC_REPLY', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_TOPIC_REPLY', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_TOPIC_REPLY', 'value' => 1],
                ['group_id' => 1, 'name' => 'FORUM_TOPIC_STICK', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_TOPIC_STICK', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_TOPIC_STICK', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_TOPIC_STICK', 'value' => 0],
                ['group_id' => 1, 'name' => 'FORUM_TOPIC_LOCK', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_TOPIC_LOCK', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_TOPIC_LOCK', 'value' => 0], ['group_id' => 99, 'name' => 'FORUM_TOPIC_LOCK', 'value' => 0],
                ['group_id' => 1, 'name' => 'FORUM_MSGMY_EDIT', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_MSGMY_EDIT', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_MSGMY_EDIT', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_MSGMY_EDIT', 'value' => 1],
                ['group_id' => 1, 'name' => 'FORUM_MSG_EDIT', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_MSG_EDIT', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_MSG_EDIT', 'value' => 0], ['group_id' => 99, 'name' => 'FORUM_MSG_EDIT', 'value' => 0],
                ['group_id' => 1, 'name' => 'FORUM_MSGMY_DELETE', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_MSGMY_DELETE', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_MSGMY_DELETE', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_MSGMY_DELETE', 'value' => 1],
                ['group_id' => 1, 'name' => 'FORUM_MSG_DELETE', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_MSG_DELETE', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_MSG_DELETE', 'value' => 0], ['group_id' => 99, 'name' => 'FORUM_MSG_DELETE', 'value' => 0],
                ['group_id' => 1, 'name' => 'FORUM_MSG_REPORT', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_MSG_REPORT', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_MSG_REPORT', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_MSG_REPORT', 'value' => 1],
                ['group_id' => 1, 'name' => 'FORUM_TOPICMY_DELETE', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_TOPICMY_DELETE', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_TOPICMY_DELETE', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_TOPICMY_DELETE', 'value' => 0],
                ['group_id' => 1, 'name' => 'FORUM_TOPIC_DELETE', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_TOPIC_DELETE', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_TOPIC_DELETE', 'value' => 0], ['group_id' => 99, 'name' => 'FORUM_TOPIC_DELETE', 'value' => 0],
                ['group_id' => 1, 'name' => 'FORUM_VIEW_REPORT', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_VIEW_REPORT', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_VIEW_REPORT', 'value' => 0], ['group_id' => 99, 'name' => 'FORUM_VIEW_REPORT', 'value' => 0],
                ['group_id' => 1, 'name' => 'FORUM_MOOVE_TOPIC', 'value' => 1], ['group_id' => 2, 'name' => 'FORUM_MOOVE_TOPIC', 'value' => 1], ['group_id' => 3, 'name' => 'FORUM_MOOVE_TOPIC', 'value' => 1], ['group_id' => 99, 'name' => 'FORUM_MOOVE_TOPIC', 'value' => 0],
            ],
            'profile' => [
                ['id_user' => 1, 'description' => 'Ceci est un description généré lors de l\'installation du plugin ']
            ],
            'topic' => [
                ['id_parent' => 4, 'id_user' => 1, 'id_topic' => 1, 'name' => 'Votre premier Topic !', 'first' => 1, 'content' => 'Ceci est votre premier message. C\'est pour vous montrez un petit parçu du plugin.', 'date' => $date, 'last_edit' => $date],
            ],
        ];
        return $array;
    }
}