<?php
require_once 'Voip/MumbleServer.php';

$mumble     = new MumbleServer();
$server     = $mumble->getServer();

$channels   = $server->getChannels();
$users      = $server->getUsers();

function format_channel($channel) {
    return array(
        'id'        => $channel->id,
        'parent'    => ($channel->id == '0') ? '#' : $channel->parent,
        'text'      => ($channel->id == '0') ? 'Ryft.uk' : $channel->name,
        'state'     => array(
                            'opened'    => true
                        ),
        'icon'      => 'fa fa-folder',
    );
}

function format_user($user) {
    return array(
        // Ensure user IDs can't be numberic so they can't conflict with channels
        // Anonymous users all have id -1 but name uniqueness is enforced by mumble
        'id'        => 'user-' . $user->name,
        'parent'    => $user->channel,
        'text'      => $user->name,
        'icon'      => 'fa fa-user',
    );
}

$nodes = array_merge(
    array_map('format_user', $users),
    array_map('format_channel', $channels)
);

header('Content-Type: application/json');
echo json_encode($nodes);
?>
