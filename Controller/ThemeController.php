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
                $this->css .= ".background-forum{background-image: url({$internal['background']['value']});background-size:cover;background-attachment:fixed;background-position:center;background-repeat:no-repeat;min-height:100vh;}";
                break;
            case 'color':
                $this->css .= ".background-forum{background-color: url({$internal['background']['value']});}";
                break;
        }

        $internal['icons'] = unserialize($this->Internal->get('icons'));

        if (!empty($internal['icons'])) {
            $this->setPropretie('forum-breadcrumb-fahome', $internal['icons']['home']);
            $this->setPropretie('forum-breadcrumb-faflag', $internal['icons']['flag']);
            $this->setPropretie('forum-breadcrumb-faenvelope', $internal['icons']['envelope']);
            $this->setPropretie('forum-breadcrumb-fauser', $internal['icons']['user']);
            $this->setPropretie('forum-breadcrumb-fasignout', $internal['icons']['out']);
            $this->setPropretie('forum-breadcrumb-fasignin', $internal['icons']['in']);
        }

        return $this->css;
    }

    private function setPropretie($index, $value){
        if (!empty($value)) {
            $this->css .= ".".$index."{color:".$value."}";
        }
    }

}