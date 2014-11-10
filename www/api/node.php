<?php
    require_once 'MumbleServer.php';

    $mumble = new MumbleServer();
    $type   = $_REQUEST['type'];
    $id     = $_REQUEST['id'];

    function getUser($server, $name) {
        $user = (object) array();
        try {
            // Get user session ID
            $id = substr($name, 1);
            if (is_numeric($id)) {
                $user = $server->getState(intval($id));
            }
        } finally {
            return $user;
        }
    }

    function getChannel($server, $id) {
        $channel = (object) array();
        try {
            if (is_numeric($id)) {
                # Murmur interface gives us no quick way to query IDs,
                # so just catch InvalidChannelExceptions
                $channel = $server->getChannelState(intval($id));
            }
        } finally {
            return $channel;
        }
    }

    if ($mumble->isAvailable()) {
        $server = $mumble->getServer();

        $node = ($type == 'channel')
            ? getChannel($server, $id)
            : getUser($server, $id);

    } else {
        $node = (object) array();
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($node);
?>

