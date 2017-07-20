<?php
class ApiController extends ForumAppController
{
    private $i = 0;

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    /*
     * Get lastest message of Forum
     *
     * @param Int $int Number of message
     *
     * @return Array Returns array with lastest topic
     *
     * Example code :
     * $lastTopics = $this->requestAction('/forum/api/getLastMessageForum/5');
     * foreach ($lastTopics as $a){
     *      var_dump($a->title);
     *      var_dump($a->uri);
     *      var_dump($a->lastAuthor);
     *      var_dump($a->lastAuthorColor);
     *      var_dump($a->date);
     *      var_dump($a->isStick);
     *      var_dump($a->isLock);
     * }
     */

    public function getLastMessageForum($int)
    {
        $this->autoRender = false;

        if (!$this->isConnected) {
            $idGroup = 99;
        } else {
            $idGroup = $this->Components->load('ForumPermission')->getDomin($this->getIdSession());
            $idGroup = $idGroup[0]['Groups_user']['id_group'];
        }

        $this->loadModel('Forum.Topic');

        $allTopics = $this->Topic->getTopic(42, 'all');

        $return = '';

        foreach ($allTopics as $key => $a){
            if ($this->viewParent('topic', $a['Topic']['id_topic'])) {
                if($this->i > $int) break;

                $return[$key]->title = $a['Topic']['name'];
                $return[$key]->uri = $this->buildUri('topic', $a['Topic']['name'], $a['Topic']['id_topic']);
                $return[$key]->lastAuthor = $this->gUBY($a['Topic']['id_user']);
                $return[$key]->lastAuthorColor = $this->ForumPermission->getRankColorDomin($a['Topic']['id_user']);
                $return[$key]->date = $a['Topic']['date'];
                $return[$key]->isStick = $a['Topic']['stick'];
                $return[$key]->isLock = $a['Topic']['lock'];

                $this->i++;
            }else {
                unset($allTopics[$key]);
            }
        }

        return $return;
    }

}
