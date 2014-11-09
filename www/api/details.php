<?php
    require_once 'MumbleServer.php';

    function pl($count, $string) {
        $ret = $count . " " . $string;
        return ($count == 0) ? ''
             : (($count == 1) ? $ret : $ret . 's');
    }

    function getUptime($server) {
        $seconds = $server->getUptime();
        $before = new DateTime();
        $after  = new DateTime();
        $after->add(new DateInterval('PT'.$seconds.'S'));
        $uptime = $after->diff($before);
        $names = ['year', 'month', 'day', 'hour', 'minute'];
        $values = [$uptime->y, $uptime->m, $uptime->d, $uptime->h, $uptime->i];
        $parts = [];
        for ($i = 0; $i < count($names); $i++) {
            if ($values[$i] != 0) {
                $parts[] = pl($values[$i], $names[$i]);
            }
        }
        return implode(', ', $parts);
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
            'uptime'        => getUptime($server),
            'last_activity' => getLastActivity($server),
        );

    } else {
        $details = array(
            'available'     => false,
        );
    }

    header('Content-Type: application/json');
    echo json_encode($details);
?>

