<?php

function getPopupNewAuthContent() {
    global $smarty;

    /** @noinspection PhpUndefinedVariableInspection */
    $contents = $smarty->tpl_vars;
    $title = $contents->content_483;
    $body = $contents->content_484;
    $frame_logout_text = $contents->content_485;

    __ECHO_FANCY_DEV__('$contents', $contents);

    return
        $title + $body + $frame_logout_text;
}