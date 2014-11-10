<?php
    require_once 'MumbleServer.php';

    function pl($count, $string) {
        $ret = $count . " " . $string;
        return ($count == 0) ? ''
             : (($count == 1) ? $ret : $ret . 's');
    }

    function getLastActivity($server) {
        $log = $server->getLog(0, 1);
        return $log[0]->timestamp;
    }

    $mumble = new MumbleServer();

    if ($mumble->isAvailable()) {
        $server = $mumble->getServer();

        $details = array(
            'available'     => true,
            'version'       => $mumble->getVersion(),
            'uptime'        => $server->getUptime(),
            'last_activity' => getLastActivity($server),
        );

    } else {
        $details = array(
            'available'     => false,
        );
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($details);
?>

