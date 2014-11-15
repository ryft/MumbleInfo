<?php
    require_once 'MumbleServer.php';

    function format_tree($tree) {
        $channel    = $tree->c;
        $subtrees   = $tree->children;
        $users      = $tree->users;
        $children   = array_merge(
            array_map('format_tree', $subtrees),
            array_map('format_user', $users)
        );
        return array(
            'id'    => $channel->id,
            'text'  => $channel->name,
            'icon'  => 'fa fa-folder',
            'state' => array( 'opened' => (count($children) > 0) ),
            'children'  => $children,
            'type'  => 'channel',
        );
    }

    function format_user($user) {
        // Ensure session IDs aren't numberic so they can't conflict with channels
        return array(
            'id'    => 'u'.$user->session,
            'text'  => $user->name,
            'icon'  => 'fa fa-user',
            'type'  => 'user',
        );
    }

    $mumble = new MumbleServer();

    if ($mumble->isAvailable()) {
        $server = $mumble->getServer();
        $tree   = format_tree($server->getTree());

    } else {
        $tree   = array(
            'icon'  => 'fa fa-power-off',
            'state' => array( 'disabled' => true ),
        );
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($tree);
?>

