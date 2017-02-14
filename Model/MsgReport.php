<?php
class MsgReport extends ForumAppModel{
    public function get(){
        return $this->find('all');
    }

    public function report($idUser, $idMessage, $date, $reason, $content){
        $this->create();
        $this->set(['id_user' => $idUser, 'id_msg' => $idMessage, 'date' => $date, 'reason' => $reason, 'content' => $content]);
        return $this->save();
    }

    public function deleteReport($id){
        $this->delete($id);
    }
}