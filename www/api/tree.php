<?php
require_once 'Voip/MumbleServer.php';

$mumble = new MumbleServer();
$server = $mumble->getServer();
$tree   = $server->getTree();

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
        'text'  => ($channel->id == '0') ? 'Ryft.uk' : $channel->name,
        'icon'  => 'fa fa-folder',
        'state' => array( 'opened' => (count($children) > 0) ),
        'children'  => $children,
        'type'  => 'channel',
    );
}

function format_user($user) {
    // Ensure user IDs can't be numberic so they can't conflict with channels
    // Anonymous users all have id -1 but name uniqueness is enforced by mumble
    return array(
        'id'    => 'user-' . $user->name,
        'text'  => $user->name,
        'icon'  => 'fa fa-user',
        'type'  => 'user',
    );
}

header('Content-Type: application/json');
echo json_encode(format_tree($tree));
?>
