<?php
$app_account = LinxAppAccessList::model()->getAllowedApp($account_id,true);

?>
<div>
    <ul>
        <?php

            foreach ($app_account as $app_account_item) {
                echo '<li>';
                    echo '<a href="'.$app_account_item->linxApp->app_url.'">';
                        echo '<img src="'.Yii::app()->baseUrl.'/images/dove.png" alt="icon-app" width="60" /><br>';
                        echo $app_account_item->linxApp->app_name;
                    echo '</a>';
                echo '</li>';
            }

        ?>
    </ul>
</div>
