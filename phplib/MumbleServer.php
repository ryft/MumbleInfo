<?php
require_once 'Ice.php';
require_once 'Murmur.php';
require_once 'Config.php';

class MumbleServer {

    function __construct() {
        try {
            $initData = new Ice_InitializationData;
            $initData->properties = Ice_createProperties();
            $initData->properties->setProperty('Ice.ImplicitContext', 'Shared');
            $ICE = Ice_initialize($initData);
            $meta = Murmur_MetaPrxHelper::checkedCast($ICE->stringToProxy(ICE_PROXY));
            $meta->getVersion($a, $b, $c, $this->versionStr);
            $this->server = $meta->getAllServers()[0];
            $this->available = true;

        } catch (Exception $e) {
            $this->available = false;
        }
    }

    function isAvailable() {
        return $this->available;
    }

    function getServer() {
        return $this->server;
    }

    function getVersion() {
        return $this->versionStr;
    }
}
?>
