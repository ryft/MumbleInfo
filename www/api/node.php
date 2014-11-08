<?php
    require_once 'MumbleServer.php';

    $mumble = new MumbleServer();
    $server = $mumble->getServer();

    $type   = $_REQUEST['type'];
    $id     = $_REQUEST['id'];

    if ($type == 'user') {
        foreach ($server->getUsers() as $user) {
            if ($user->name == $id) {
                $node = $user;
                break;
            }
        }
    
    } elseif ($type == 'channel') {
        $node = $server->getChannelState(intval($id));
    }

    header('Content-Type: application/json');
    echo json_encode($node);
?>

