<?php
class Profile extends ForumAppModel{
    public function get($id = false){
        if($id){
            if($this->hasAny(['id_user' => $id])){
                return $this->find('first', ['conditions' => ['id_user' => $id]])['Profile'];
            }
            return '';
        }else{
            return $this->find('all');
        }
    }

    public function updateProfile($description, $idUser){
        if($this->hasAny(['id_user' => $idUser])){
            return $this->updateAll(['description' => "'".$description."'"], ['id_user' => $idUser]);
        }else{
            $this->create();
            $this->set(['id_user' => $idUser, 'description' => $description]);
            return $this->save();
        }
    }
}