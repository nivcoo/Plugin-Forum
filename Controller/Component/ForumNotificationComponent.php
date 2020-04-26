<?php

class ForumNotificationComponent extends Component
{
    public function removeScript($content)
    {
        $dom = new DOMDocument();

        $dom->loadHTML($content);

        $script = $dom->getElementsByTagName('script');

        $remove = [];
        foreach($script as $item)
        {
            $remove[] = $item;
        }

        foreach ($remove as $item)
        {
            $item->parentNode->removeChild($item);
        }

        $content = $dom->saveHTML();

        return $content;
    }
}