<?php

class ThemeController extends ForumAppController
{

    private $css;

    public function generate()
    {
        $this->loadModel('Forum.Internal');

        $this->layout = false;
        $this->autoRender = false;

        $internal['background'] = unserialize($this->Internal->get('background'));

        switch ($internal['background']['type']) {
            case 'image':
                $this->css = ".background-forum{background-image: url({$internal['background']['value']});background-size:cover;}";
                break;
            case 'color':
                $this->css = ".background-forum{background-color: url({$internal['background']['value']});}";
                break;
        }

        return $this->css;
    }

}