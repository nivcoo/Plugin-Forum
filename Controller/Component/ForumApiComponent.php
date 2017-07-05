<?php
class ApiComponent extends Component
{
    public function __construct()
    {
        $this->model['topic'] = ClassRegistry::init('Forum.Topic');
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

        if ($this->isConnected) {
            $idGroup = 99;
        } else {
            $idGroup =  $this->ForumPermission->getIdGroup($this->getIdSession());
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

        $allTopics = $this->model['topic']->get();



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
