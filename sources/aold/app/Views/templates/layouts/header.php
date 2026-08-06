<?php 
if ($logged)
{
    require LAYOUT_PATH . '/navUser/pc.php';
    require LAYOUT_PATH . '/navUser/mobile.php';
}
else
{
    require LAYOUT_PATH . '/navGuest/pc.php';
    require LAYOUT_PATH . '/navGuest/mobile.php';
}
?>
