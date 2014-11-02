<?php
require_once 'Voip/MumbleServer.php';
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

$mumble = new MumbleServer();
$server = $mumble->getServer();
$channel_id = $_REQUEST['id'];
$channel    = $server->getChannelState(intval($channel_id));

$loader = new Twig_Loader_Filesystem(TWIG_TEMPLATE_DIR);
$twig = new Twig_Environment($loader, array(
    'cache'         => TWIG_CACHE_DIR,
    'autoescape'    => false,
    'auto_reload'   => true,
));

echo $twig->render('channelInfo.html', (array) $channel);
?>
