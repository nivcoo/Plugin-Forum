<?php
class ForumRenderComponent extends Component{

    public $none = '';

    public function index($type, $value){
        if(!empty($value['data'])){
            switch ($type){
                case 'style':
                    return $this->style($value['type'], $value['data']);
                    break;
            }
        }else{
            return $this->none;
        }
    }

    //Example : $this->forumRender('style', ['type' => 'background-color', 'data' => $x]);

    public function style($type, $value){
        if($type == 'color'){
            foreach ($value as $key => $val){
                $value[$key] = ' style="color:#'.$val.'"';
            }
            return $value;
        }elseif('background-color'){
            foreach ($value as $key => $val){
                $value[$key] = ' style="background-color:#'.$val.'"';
            }
            return $value;
        }

    }

}