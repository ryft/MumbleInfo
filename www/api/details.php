<?php
require_once 'Voip/MumbleServer.php';
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

$mumble = new MumbleServer();
$server = $mumble->getServer();

$type   = $_REQUEST['type'];
$id     = $_REQUEST['id'];

$loader = new Twig_Loader_Filesystem(TWIG_TEMPLATE_DIR);
$twig = new Twig_Environment($loader, array(
    'cache'         => TWIG_CACHE_DIR,
    'autoescape'    => false,
    'auto_reload'   => true,
));

if ($type == 'user') {
    foreach ($server->getUsers() as $u) {
        if ($u->name == $id) {
            $user = $u;
            break;
        }
    }
    echo $twig->render('userInfo.html', (array) $user);

} elseif ($type == 'channel') {
    $channel = $server->getChannelState(intval($id));
    echo $twig->render('channelInfo.html', (array) $channel);
}

?>
