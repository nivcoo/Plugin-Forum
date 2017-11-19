<?php

class ThemeController extends ForumAppController
{

    private $css;

    public function generate()
    {
        $this->loadModel('Forum.Internal');

        $this->layout = false;
        $this->autoRender = false;
        $this->response->type('css');

        $internal['background'] = unserialize($this->Internal->get('background'));

        switch ($internal['background']['type']) {
            case 'image':
                $this->css = ".background-forum{background-image: url({$internal['background']['value']});background-size:cover;background-attachment:fixed;background-position:center;background-repeat:no-repeat;min-height:100vh;}";
                break;
            case 'color':
                $this->css = ".background-forum{background-color: url({$internal['background']['value']});}";
                break;
        }

        return $this->css;
    }

}