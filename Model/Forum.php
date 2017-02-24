<?php
class Forum extends ForumAppModel {
    public function getForum($type = "", $id = false){
        switch ($type){
            case 'id' :
                return $this->find('first', ['conditions' => ['id' => $id]]);
                break;
            case 'forum' :
                return $this->find('all', ['conditions' => ['id_parent' => 0], 'order' => ['position' => 'ASC']]);
                break;
            case 'withoutforum' :
                return $this->find('all', ['conditions' => ['id_parent >' => 0], 'order' => ['position' => 'ASC']]);
                break;
            case 'categorie' :
                return $this->find('all', ['conditions' => ['id_parent' => $id], 'order' => ['position' => 'ASC']]);
                break;
            default :
                return $this->find('all', ['order' => ['position' => 'ASC']]);
        }
    }

    public function userOnline($userModel){
        $date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        return $userModel->find('all', ['fields' => ['id', 'pseudo'], 'conditions' => ['forum-last_activity >' => $date]]);
    }

    public function addForum($idUser, $name, $position, $image){
        //TODO LONGDATE: + description
        $this->create();
        $this->set(['id_user' => $idUser, 'id_parent' => 0, 'forum_name' => $name, 'position' => $position, 'forum_image' => $image]);
        return $this->save();
    }

    public function addCategory($idUser, $name, $position, $parent, $image){
        //TODO future maj: + description
        $this->create();
        $this->set(['id_user' => $idUser, 'forum_name' => $name, 'position' => $position, 'id_parent' => $parent,  'forum_image' => $image]);
        return $this->save();
    }

    public function admin_delete($id){
        return $this->delete($id);
    }

    //Get a information
    public function info($type = false, $id = false, $name = false){
        switch ($type){
            case 'forum' :
                return $this->find('all', ['conditions' => ['id' => $id]]);
                break;
            case 'parent_title' :
                return $this->find('first', ['conditions' => ['id' => $id]]);
                break;
            case 'parent_href' :
                return $this->find('first', ['conditions' => ['id' => $id]]);
            break;
        }
    }

    public function update($type = false, $id = false, $datas = false){
        if($type == 'forum'){
            return $this->updateAll(['forum_name' => "'".$datas['name']."'", 'position' => "'".$datas['position']."'", 'forum_image' => "'".$datas['image']."'"], ['id' => $id]);;
        }elseif ($type == 'category'){
            return $this->updateAll(['forum_name' => "'".$datas['name']."'", 'id_parent' => "'".$datas['id_parent']."'", 'position' => $datas['position'], 'forum_image' => "'".$datas['forum_image']."'"], ['id' => $id]);;
        }
    }

    public function forumExist($id, $slug){
        if($this->hasAny(['id' => $id, 'forum_name' => $slug])) return true;
    }

    public function getConfig() {
        $config = $this->find('first');
        if(empty($config)) {
            return true;
        }
    }
}