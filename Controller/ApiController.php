<?php
class ApiController extends ForumAppController
{

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
     */

    public function getLastMessageForum($int)
    {
        $this->autoRender = false;

        if ($this->isConnected) {
            $idGroup = 99;
        } else {
            $idGroup =  $this->Components->load('ForumPermission')->getIdGroup(1);
            //Debug pour prendre celui qui a le plus de perm
        }

        //Test when Logout/login and with rank
        var_dump($idGroup);

        /*
         *
         * SQL Query
         *
         * fetch x lastest topic When :
         * -> Attention forum + catégory + topic (visible) -> permission personnalisé
         *
         * '' => done != visible -> contient pas id du group
         * '' => done != visible -> Catégorie parent
         * '' => done != visible -> forum de la catégorie Parent
         *
         */
        $this->loadModel('Forum.Topic');

        $allTopics = $this->Topic->get();



        /*
         * Return :
         * -Title
         * -Link
         * -Lastest author
         * -Color lastest author
         * -Date
         * -Bool for Cadenas
         */
    }

}
