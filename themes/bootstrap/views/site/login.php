<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'login-form',
    'type' => 'verticle',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<!--form action="<?php echo Yii::app()->baseUrl; ?>/site/login" method="post"-->
<div id="wrapper">
    <div id="wrappertop"></div>

    <div id="wrappermiddle">
        
        <!--div style="position: absolute; margin-top: 250px; margin-left: 30px;">
                <img src="<?php //echo Yii::app()->baseUrl; ?>/images/christmas/christmas-tree-1.png" height="300"/>
        </div-->
        <center>
<!--            <img src="<?php echo Yii::app()->baseUrl; ?>/images/dove.png" height="60"/>-->
            <h1 style="font-size: 34px;">LinxCloud</h1>
        </center>

        <div style="text-align: center; width: 100%;" id="linxcircle-login-error">
            <br/>
            <?php
            if (isset($_POST['LoginForm'])) {
                echo 'You have provided invalid credentials. Please try again.';
            }
            ?>
        </div>
        <div id="username_input">

            <div id="username_inputleft"></div>

            <div id="username_inputmiddle">
                <input type="text" name="LoginForm[username]" 
                       id="LoginForm_username"
                       class="url" 
                       value="<?php
            echo (isset($_POST['LoginForm']['username'])) ?
                    $_POST['LoginForm']['username'] :
                    'Email Address'
            ?>" 
                       onclick="this.value = ''">
                <img id="url_user" src="../images/loginform/mailicon.png" alt="">
            </div>

            <div id="username_inputright"></div>

        </div>

        <div id="password_input">

            <div id="password_inputleft"></div>

            <div id="password_inputmiddle">
                <input type="password"  
                       name="LoginForm[password]"
                       id="LoginForm_password"
                       class="url" value="Password" onclick="this.value = ''">
                <img id="url_password" src="../images/loginform/passicon.png" alt="">
            </div>

            <div id="password_inputright"></div>

        </div>

        <div id="submit">
            <form>
                <button name="yt0" type="submit" class="btn" style="width: 300px; color: #bbb">Login</button>
            </form>
        </div>


        <div id="links_left">
<?php
echo CHtml::link('Reset Password', array('accountPasswordReset/create'));
?>
            <!--a href="#">Forgot your Password?</a-->

        </div>

        <div id="links_right">
            <label for="LoginForm_rememberMe" class="checkbox">
                <input type="hidden" name="LoginForm[rememberMe]" value="0" id="ytLoginForm_rememberMe">
                <input type="checkbox" value="1" id="LoginForm_rememberMe" name="LoginForm[rememberMe]">
                <a href="#">Remember me next time</a>
            </label>
        </div>

    </div>

    <div id="wrapperbottom"></div>

</div>
<!--/form-->
<?php $this->endWidget(); ?>