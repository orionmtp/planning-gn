<?php 
    include('../phpqrcode/qrlib.php'); 
    $text=$_GET['text'];
    // outputs image directly into browser, as PNG stream
    QRcode::png($text);
?>