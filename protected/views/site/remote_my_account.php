<span id="linx-my-account">
    <div class="btn-group">
        <?php $photoName = LinxAccountProfile::model()->hashProfilePhotoName($user_id);
            $file_path = $url.'profile_photos/'.$photoName;
                $url1 = @getimagesize($file_path);
                if (is_array($url1)) {
                  $images_url = $file_path;
                } else {
                  $images_url = $url.'images/lincoln-default-profile-pic.png';
                }
        ?>
        <img width="34" height="34" alt="" src="<?php echo $images_url;?>" style="margin-right: 5px; height: 34px; border-radius:17px; width: 34px; ">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo LinxAccountProfile::model()->getShortFullName($user_id ); ?> <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-right">
        <li><a href="<?php echo $url.'linxAccount/'.$user_id ;?>">My Account</a></li>
        <li><a href="<?php echo $url.'site/logout';?>">Loguot</a></li>
      </ul>
    </div> 
</span>

