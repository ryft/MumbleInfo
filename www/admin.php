<?php
include 'Voip/InfoPage.php';

// XXX Perform your own server-side authentication
// to disallow unauthorised access to the admin page.
$page = new InfoPage(true);
$page->display();
?>
