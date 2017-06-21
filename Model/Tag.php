<?php
class Tag extends ForumAppModel
{
    public function get()
    {
        return $this->find('all');
    }

    public function add($label, $icon, $color, $position)
    {
        $this->create();
        $this->set(['name' => $label, 'icon' => $icon, 'color' => $color, 'position' => $position]);
        return $this->save();
    }

    public function deleteTag($id)
    {
        return $this->delete($id);
    }

}