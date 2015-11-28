<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.blockUI.js"></script>
<script>
    $(document).ready(function(){
        call_linxCircle_create();
    });


    function call_linxCircle_create(){
        var account_password = '<?php echo $account_password; ?>';
        var account_email = '<?php echo $account_email; ?>';
        var account_id = '<?php echo $account_id; ?>';
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url:'http://localhost:8080/linxcicle/index.php/api/CreateAccount/model',
            type:'POST',
            data:{account_password:account_password,account_email:account_email,account_id:account_id},
            success:function(data){
                $.unblockUI;
                location.href = '<?php echo YII::app()->createUrl('linxAccount/view',array('id'=>$account_id)); ?>';
            }
        });
    }
</script>