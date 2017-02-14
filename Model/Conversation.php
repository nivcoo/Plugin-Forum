<?php
class Conversation extends ForumAppModel{
    public function get($x = false, $y = false){
        if(is_numeric($x) && !$y){
            return $this->find('all', ['conditions' => ['id_conversation' => $x], 'order' => ['msg_date' => 'ASC']]);
        }elseif (is_numeric($x) && is_numeric($y)){
            return $this->find('first', ['conditions' => ['id_conversation' => $x], 'order' => ['msg_date' => 'ASC']]);
        }elseif ($x == 'first'){
            return $this->find('all', ['conditions' => ['first' => 1]]);
        }else{
            return $this->find('all');
        }
    }

    public function ConversationExist($id, $slug){
        if($this->hasAny(['id_conversation' => $id, 'title' => $slug])) return true;
    }

    public function add($idConv, $first, $title, $idUser, $ip, $content){
        $this->create();
        $this->set(['id_conversation' => $idConv, 'first' => $first, 'title' => $title, 'author_id' => $idUser, 'author_ip' => $ip, 'msg_date' => date('Y-m-d H:i:s'), 'content' => $content]);
        return $this->save();
    }
}