<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$app_account = LinxAppAccessList::model()->getAllowedApp(YII::app()->user->id,true);
?>
<div id="content-home-app" >
    <ul>
        <li>
            <a href="<?php echo YII::app()->homeUrl;?>">
                <img src="<?php echo YII::app()->baseUrl;?>/images/app/logo-linxcloud.png" alt="icon-app" width="120" /><br>
                LinxCloud
            </a>
        </li>
        <?php
            foreach ($app_account as $app_account_item) {
				$images_app_url = LinxApp::model()->getAppPhotoURL($app_account_item->al_app_id);
                echo '<li>';
                    echo '<a href="'.$app_account_item->linxApp->app_url.'">';
                        echo '<img src="'.YII::app()->baseUrl.$images_app_url.'" alt="icon-app" width="120" /><br>';
                        echo $app_account_item->linxApp->app_gui_name;
                    echo '</a>';
                echo '</li>';
            }
        ?>
    </ul>
</div>
