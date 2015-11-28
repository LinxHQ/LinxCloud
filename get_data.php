<?php
$user_id = (isset($_GET['id']) ? $_GET['id'] : 0);
echo file_get_contents('http://accounts.linxenterprisedemo.com/index.php/site/RemoteMenu/id/'.$user_id); 
?>
<script src="http://accounts.linxenterprisedemo.com/js/bootstrap.min.js"></script>