<?php
class UserController extends ForumAppController {

    public $components = [
        'Security' => [
            'csrfExpires' => '+1 hour'
        ],
        'Forum.ForumPermission'
    ];

    public function beforeFilter(){
        parent::beforeFilter();
        $this->loadModel('User');
        $this->User->updateAll(array('forum-last_activity' => "'".date("Y-m-d H:i:s")."'"), array('id' => $this->Session->read('user')));
        $this->Security->csrfExpires = '+1 hour';
    }

    public function index($id, $slug){
        if($this->userExist($id, $slug)){
            $this->loadModel('Forum.Config');
            $this->loadModel('Forum.Topic');
            $this->loadModel('Forum.Note');
            $this->loadModel('Forum.Profile');
            $active['userpage'] = ($this->Config->is('userpage')) ? true : false;
            if($active['userpage']){
                $infos['nb_message'] = $this->Topic->getNbMessage('user', $id);
                $infos['inscription'] = $this->date($this->dateInscription($id));
                $infos['thumb']['green'] = $this->Note->getNbThumb('green', $id);
                $infos['thumb']['red'] = $this->Note->getNbThumb('red', $id);

                $lasts['Comment'] = $this->Topic->userLastMessage($id);
                foreach($lasts['Comment'] as $key => $last){
                    $lasts['Comment'][$key]['Topic']['title'] = $this->Topic->info('title_parent', $last['Topic']['id_topic']);
                }
                $lasts['Note'] = $this->Note->userLastNote($id);
                foreach($lasts['Note'] as $key => $last){
                    $lasts['Note'][$key]['Note']['txt'] = ($last['Note']['type'] == 1) ? $this->Lang->get('FORUM__PHRASE__PROFILE__GREENTHUMB') : $this->Lang->get('FORUM__PHRASE__PROFILE__REDTHUMB');
                    $lasts['Note'][$key]['Note']['class'] = ($last['Note']['type'] == 1) ? 'green' : 'red';
                    $lasts['Note'][$key]['Note']['fa'] = ($last['Note']['type'] == 1) ? 'up' : 'down';
                    $lasts['Note'][$key]['Note']['message'] = $this->Topic->getUniqMessage($last['Note']['id_message'])['content'];
                    $lasts['Note'][$key]['Note']['msg']['id'] = $this->Topic->info('id_topic', $last['Note']['id_message']);
                    $lasts['Note'][$key]['Note']['msg']['title'] = $this->Topic->info('title_parent', $last['Note']['id_message']);
                }

                $ranks['rank'] = $this->ForumPermission->getRank($id);
                $ranks['color'] = $this->ForumPermission->getRankColor($id);
                $ranks['color'] = $this->forumRender('style', ['type' => 'background-color', 'data' => $ranks['color']]);

                $userForum = $this->Profile->get($id);
                if(empty($userForum['description'])){
                    $userForum['description'] = 'Aucune description n\'est disponible.';
                }
                $userForum['color'] = $this->ForumPermission->getRankColorDomin($id);
                $theme = $this->theme();
                //TODO : For a soon update
                //$infos['social']['twitter'] = "";
                $this->set(compact('slug', 'id', 'infos', 'lasts', 'ranks', 'userForum', 'theme'));
            }else{
                throw new NotFoundException();
            }
        }else{
            throw new NotFoundException();
        }
    }

    public function edit($id, $slug){
        if($this->userExist($id, $slug)){
            $this->loadModel('Forum.Config');
            $this->loadModel('Forum.Profile');
            $active['userpage'] = ($this->Config->is('userpage')) ? true : false;
            if($active['userpage']){
                if($this->request->is('post')){
                    if(!empty($this->request->data['description'])){
                        $this->Profile->updateProfile($this->request->data['description'], $this->getIdSession());
                        $this->logforum($this->getIdSession(), 'edit_profile', $this->gUBY($this->getIdSession()).' vient d\'editer son profil ', $this->request->data['description']);
                        $this->Session->setFlash($this->Lang->get('FORUM__EDIT__PROFILE'), 'default.success');
                    }else{
                        $this->Session->setFlash($this->Lang->get('FORUM__ERROR'), 'default.error');
                    }
                }
                $infos = $this->Profile->get($this->getIdSession());
                $theme = $this->theme();
                $this->set(compact('infos', 'theme'));
            }else{
                throw new NotFoundException();
            }
        }else{
            throw new NotFoundException();
        }
    }

    private function userExist($id, $slug){
        $query = $this->User->find('first', ['conditions' => ['id' => $id, 'pseudo' => $slug]]);
        return (empty($query)) ? false : true;
    }
}