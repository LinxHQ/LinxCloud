<?php 
	$url = 'http://accounts.linxenterprisedemo.com';
	$user_id = (isset($_GET['id']) ? $_GET['id'] : 0);
?>

<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/menu_app.css">
<script src="<?php echo $url; ?>/js/jquery.js"></script>


    <span id="linx-menu">
        <span style="text-align: center;" id="linx-menu-list-app">
            <a href="#" title="List App" id="linx-menu-popver" data-toggle="popover" data-content=""><img width="18" alt="th" src="<?php echo $url; ?>/img/th.png"></a>
        </span>

        <div class="btn-group">
			<a href="<?php echo $url.'/index.php/linxAccount/'.$user_id ;?>" title="Mr A." rel="tooltip" style="display: inline-block;">
				<img width="30" height="30" alt="" src="<?php echo $url; ?>/images/lincoln-default-profile-pic.png" style="margin-right: 5px; height: 30px; border-radius:15px; width: 30px; ">
			</a>
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo LinxAccountProfile::model()->getFullName($user_id ); ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $url.'/index.php/linxAccount/'.$user_id ;?>">My Account</a></li>
            <li><a href="<?php echo $url.'/index.php/site/logout';?>">Loguot</a></li>
          </ul>
        </div>
    </span>
	
<?php
$app_account = LinxAppAccessList::model()->getAllowedApp($user_id,true);

?>
<div id="content-list-app" style="display: none;" >
    <ul>
        <?php

            foreach ($app_account as $app_account_item) {
                echo '<li>';
                    echo '<a href="'.$app_account_item->linxApp->app_url.'">';
                        echo '<img src="'.$url.'/images/dove.png" alt="icon-app" width="60" /><br>';
                        echo $app_account_item->linxApp->app_name;
                    echo '</a>';
                echo '</li>';
            }

        ?>
    </ul>
</div>


<script>
$(document).ready(function(){

   $("#linx-menu-popver").popover({
        content: 'Loading...',
        html: true,
        placement : 'bottom',
        template: '<div class="popover" role="tooltip" style="width: 250px;"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"><div class="data-content"></div></div></div>'
    });
	setInterval(function(){
			var data = $('#content-list-app').html();
			$("#linx-menu .popover-content").html(data);
	}, 1000);
});

</script>