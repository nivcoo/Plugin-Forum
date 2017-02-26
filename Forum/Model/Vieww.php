<?php
class Vieww extends ForumAppModel{
    public function get(){
        return $this->find('all');
    }

    public function exist($ip, $idTopic){
        return $this->find('first', ['conditions' => ['ip' => $ip, 'id_topic' => $idTopic, 'date >' => date('Y-m-d H:i:s', strtotime('-2 day'))]]);
    }

    public function addView($ip, $idTopic){
        $this->create();
        $this->set(['date' => date('Y-m-d H:i:s'), 'ip' => $ip, 'id_topic' => $idTopic]);
        return $this->save();
    }

    public function count($id){
        return $this->find('count', ['conditions' => ['id_topic' => $id]]);
    }
}