<?php
class ForumPermissionComponent extends Component {

    /*
     *              LIST OF Permission
     * FORUM_MP_SEND -> Envoyer des messages en mp
     * FORUM_MP_REPLY -> Répondre aux messages en mp
     *
     * FORUM_TOPIC_SEND -> Poster des topics
     * FORUM_TOPIC_REPLY -> Répondre aux topics
     *
     * FORUM_TOPIC_LOCK -> Lock des topics
     * FORUM_TOPICSTICk -> Epingler des topics
     *
     * FORUM_MSGMY_EDIT -> Editer ses messages (seulement les chiens) ^^
     * FORUM_MSG_EDIT -> Editer les messages de tout le monde
     * FORUM_MSGMY_DELETE -> Supprimer ses messages ^^ *
     * FORUM_MSG_DELETE -> Supprimer les messages de tout le monde *
     *
     * FORUM_MSG_REPORT -> Report des topics
     * FORUM_TOPICMY_DEL -> Supprimer ses propres topics
     * FORUM_TOPIC_DEL -> Supprimer les topics
     * FORUM_VIEW_REPORT -> Voir les signalement
     * FORUM_MOOVE_TOPIC -> Déplacer des sujets
     */

    public $model;

    public function __construct(){
        $this->model['permission'] = ClassRegistry::init('Forum.ForumPermission');
        $this->model['groups'] = ClassRegistry::init('Forum.Group');
        $this->model['groupsuser'] = ClassRegistry::init('Forum.Groups_user');
    }

    public function perm_l(){
        $tests = $this->model['permission']->get(1);
        foreach ($tests as $test){
            $perms[$test['ForumPermission']['name']] = $this->has($test['ForumPermission']['name']);
        }
        return $perms;
    }

    public function visible($type, $id){
        $this->model['topic'] = ClassRegistry::init('Forum.Topic');
        $this->model['forum'] = ClassRegistry::init('Forum.Forum');
        $datas = unserialize($this->model[$type]->info('visible', $id));
        if($datas == NULL) return true;

        $ranks = $this->getRank($this->getIdSession(), true);
        if(empty($ranks)) return false;

        foreach ($ranks as $key => $r){
            if(isset($datas[$key+1]) && $datas[$key+1] == 'on') return true;
        }
        return false;
    }

    public function has($permission){
        $groupsIds = $this->model['groupsuser']->get($this->getIdSession());
        array_push($groupsIds, ['Groups_user' => ['id' => 99, 'id_user' =>  $this->getIdSession(), 'id_group'=> 99]]);
        foreach ($groupsIds as $groupsId){
            if($this->model['permission']->has($permission, $groupsId['Groups_user']['id_group'])){
                return true;
            }
        }
        return false;
    }

    public function getRankColor($id){
        $groups = @$this->model['groupsuser']->getIdGroup($id);
        if($groups){
            foreach ($groups as $key => $group){
                $groups[$key] = $this->model['groups']->getRankColor($group['Groups_user']['id_group']);
            }
        }else{
            $groups = '';
        }
        return $groups;
    }

    public function getRankColorDomin($id){
        $group = $this->model['groupsuser']->getIdGroupDomin($id);
        return ($group) ? $this->model['groups']->getRankColor($group) : '';
    }

    public function getRanks($id = false){
        return $this->model['groups']->get($id);
    }

    public function getRank($id, $advanced = false){
        $groups = $this->model['groupsuser']->getIdGroup($id);
        if($groups){
            foreach ($groups as $key => $group){
                if($advanced){
                    $groups[$key] = $this->model['groups']->getRanks($group['Groups_user']);
                }else{
                    $groups[$key] = $this->model['groups']->getRank($group['Groups_user']['id_group']);
                }
            }
        }else{
            $groups = '';
        }
        return $groups;
    }

    public function updateGroup($state, $domin, $idUser, $idGroup){
        return $this->model['groupsuser']->updateGroup($state, $domin, $idUser, $idGroup);
    }

    public function getIdGroup($id){
        return $this->model['groupsuser']->getIdGroup($id);
    }

    public function getDomin($id){
        return $this->model['groupsuser']->getDomin($id);
    }

    private function getIdSession(){
        return isset($_SESSION['user']) ? $_SESSION['user'] : false;
    }

    public function updateRank($name, $description, $color, $id){
        return $this->model['groups']->updateRank($name, $description, $color, $id);
    }

    public function updatePermission($value, $id){
        return $this->model['permission']->updatePermission($id, $value);
    }
}