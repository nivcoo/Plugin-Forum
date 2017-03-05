<?php
class Group extends ForumAppModel{
    public function get($id = false){
        if($id){
            return $this->find('first', ['conditions' => ['id' => $id]])['Group'];
        }else{
            return $this->find('all');
        }
    }

    public function deleteGroup($id){
        return $this->delete($id);
    }

    // 99  is a group of members, it's not defined
    public function getRankColor($id){
        if($id != 99) {
            return $this->find('first', ['fields' => 'color', 'conditions' => ['id' => $id]])['Group']['color'];
        }
    }

    public function getRank($id){
       if($id != 99){
           return $this->find('first', ['fields' => 'group_name', 'conditions' => ['id' => $id]])['Group']['group_name'];
       }
    }

    public function getRanks($id){
        if($id != 99){
            return $this->find('first', ['conditions' => ['id' => $id]])['Group'];
        }
    }

    public function addGroup($rank, $description, $color){
        $this->create();
        $this->set(['group_name' => $rank, 'group_description' => $description, 'color' => $color]);
        return $this->save();
    }

    public function getName($id){
        return $this->find('all', ['fields' => 'group_name', 'conditions' => ['id' => $id]])[0]['Group']['group_name'];
    }

    public function updateRank($name, $description, $color, $id){
        return $this->updateAll(['group_name' => "'".$name."'", 'group_description' => "'".$description."'", 'color' => "'".$color."'"], ['id' => $id]);;
    }
}