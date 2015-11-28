$(document).ready(function(){
    call_linxCircle_create();
});


function call_linxCircle_create(){
    var account_password = 'admin123';
    var account_email = 'admin@gmail.com';
    var account_surname = 'Subname';
    var account_givename = 'Give Name';
    var account_company = 'Company';
    $.ajax({
        url:'http://localhost:8080/linxcicle/index.php/api/create/model/account',
        type:'POST',
        data:{account_password:account_password,account_contact_surname:account_surname,account_contact_given_name:account_givename,
                account_company:account_company},
        success:function(data){
        }
    });
}


