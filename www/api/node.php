<?php
    require_once 'MumbleServer.php';

    $mumble = new MumbleServer();
    $type   = $_REQUEST['type'];
    $id     = $_REQUEST['id'];

    function getUser($server, $name) {
        foreach ($server->getUsers() as $user) {
            if ($user->name == $name) {
                return $user;
            }
        }
        return array();
    }

    function getChannel($server, $id) {
        return $server->getChannelState(intval($id));
    }

    if ($mumble->isAvailable()) {
        $server = $mumble->getServer();

        $node = ($type == 'channel')
            ? getChannel($server, $id)
            : getUser($server, $name);

    } else {
        $node = array();
    }

    header('Content-Type: application/json');
    echo json_encode($node);
?>

