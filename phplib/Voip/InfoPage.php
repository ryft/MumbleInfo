<?php
require_once 'Server.php';
require_once 'Twig/Autoloader.php';

class InfoPage {

    function __construct($authenticated = false) {
        Twig_Autoloader::register();
        $ryftServer = new RyftServer();
        $this->server = $ryftServer->getServer();

        $this->versionStr       = $ryftServer->getVersion();
        $this->uptimeStr        = $this->getUptime();
        $this->lastActivityStr  = $this->getLastActivity();

        $loader = new Twig_Loader_Filesystem(TWIG_TEMPLATE_DIR);
        $this->twig = new Twig_Environment($loader, array(
            'cache'         => TWIG_CACHE_DIR,
            'autoescape'    => false,
            'auto_reload'   => true,
        ));
    }

    function display() {
        echo $this->twig->render('infoPage.html', array(
            'version'       => $this->versionStr,
            'uptime'        => $this->uptimeStr,
            //'log' => $this->logStr,
            'last_activity' => $this->lastActivityStr,
            'channels'      => $this->server->getChannels(),
        ));
    }

    function pl($count, $string) {
        $ret = $count . " " . $string;
        return ($count == 0) ? ''
             : (($count == 1) ? $ret : $ret . 's');
    }

    function getUptime() {
        $seconds = $this->server->getUptime();
        $before = new DateTime();
        $after  = new DateTime();
        $after->add(new DateInterval('PT'.$seconds.'S'));
        $uptime = $after->diff($before);
        $names = ['year', 'month', 'day', 'hour', 'minute'];
        $values = [$uptime->y, $uptime->m, $uptime->d, $uptime->h, $uptime->i];
        $parts = [];
        for ($i = 0; $i < count($names); $i++) {
            if ($values[$i] != 0) {
                $parts[] = $this->pl($values[$i], $names[$i]);
            }
        }
        return implode(', ', $parts);
    }

    function getLastActivity() {
        $log = $this->server->getLog(0, 1);
        return $log[0]->timestamp;
    }

    function getLog() {
        $log = $this->server->getLog(0, $this->server->getLogLen());
        $logEntries = array_map(function ($entry) { return $entry->timestamp . " - "; }, $log);
        $logStr = implode("<br />", $logEntries);
        return $logStr;
    }
}
?>
