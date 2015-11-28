<?php 
	$user_id = $account_id;
?>

<link rel="stylesheet" type="text/css" href="<?php echo $url; ?>css/menu_app.css">


    <span id="linx-menu">
        <span style="text-align: center;" id="linx-menu-list-app">
            <a href="#" title="List App" id="linx-menu-popver" data-toggle="popover" data-content=""><img width="18" alt="th" src="<?php echo $url; ?>img/th.png"></a>
        </span>
    </span>
	
<?php
$app_account = LinxAppAccessList::model()->getAllowedApp($user_id,true);

?>
<div id="content-list-app" style="display: none;" >
    <ul>
        <li>
            <a href="<?php echo $url;?>">
                <img src="<?php echo $url;?>images/app/logo-linxcloud.png" alt="icon-app" width="60" /><br>
                LinxCloud
            </a>
        </li>
        <?php

            foreach ($app_account as $app_account_item) {
				$images_app_url = LinxApp::model()->getAppPhotoURL($app_account_item->al_app_id);
                echo '<li>';
                    echo '<a href="'.$app_account_item->linxApp->app_url.'">';
                        echo '<img src="'.$url.$images_app_url.'" alt="icon-app" width="60" /><br>';
                        echo $app_account_item->linxApp->app_gui_name;
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
        template: '<div class="popover" role="tooltip" style="width: 255px;"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"><div class="data-content"></div></div></div>'
    });
	setInterval(function(){
			var data = $('#content-list-app').html();
			$("#linx-menu .popover-content").html(data);
			$("#linx-menu .popover.bottom .arrow").css({'margin-left':'-115px'});
			$('#linx-menu .popover.fade.bottom.in').css({left:0,top:28.5});
	}, 1000);
});

</script>