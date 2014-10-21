<?php
require_once 'Voip/RyftServer.php';

$ryftServer = new RyftServer();
$server     = $ryftServer->getServer();

$channels   = $server->getChannels();
$users      = $server->getUsers();

// Anonymous IDs are all -1 so we need to make them unique
$anon_offset = 8192;
function get_uid($user) {
    global $anon_offset;
    $id = $user->userid;
    return ($id == '-1')
        ? $anon_offset++
        : $id;
}

function format_channel($channel) {
    return array(
        'id'        => "$channel->id",
        'parent'    => ($channel->parent == '-1') ? '#' : "$channel->parent",
        'text'      => ($channel->id == '0') ? "Ryft.uk" : $channel->name,
        'state'     => array(
                            'opened'    => true
                        ),
        'icon'      => 'fa fa-folder',
    );
}

function format_user($user) {
    return array(
        'id'        => get_uid($user),
        'parent'    => $user->channel,
        'text'      => $user->name,
        'icon'      => 'fa fa-user',
    );
}

$nodes = array_merge(
    array_map(format_user, $users),
    array_map(format_channel, $channels)
);

header('Content-Type: application/json');
echo json_encode($nodes);
?>
