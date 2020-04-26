<?php

class ForumSecurityComponent extends Component
{
    public static function removeScript($content)
    {
        require "../Plugin/Forum/Core/lib/htmLawed/htmLawed.php";

        return htmLawed($content, ['safe' => 1]);
    }
}
