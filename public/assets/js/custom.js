$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /********Select 2*********/
    $(".select2").select2();
    /************************/
    if($("#exchangeForm").length > 0){
        exchangeRate();
    }
    // autoTransfer();
});
/* Login Validation */

$("#loginForm").validate({
    rules: {
        email: {
            required:true,
            email: true,
            maxlength: 50,
        },
        password:{
            required:true
        }
    },
    messages: {
        email: {
            required: "Please enter email",
            email: "Please enter valid email",
            maxlength: "The email name should less than or equal to 50 characters",
        },
        password:{
            required: "Please enter password"
        }
    }
});

/*  */

/* Register Validation */

$("#registerForm").validate({
    rules: {
        name: {
            required:true
        },
        last_name:{
            required:true
        },
        email: {
            required:true,
            email: true,
            maxlength: 50,
        },
        password:{
            required:true
        },
        password_confirmation:{
            required:true,
            equalTo: "#password"
        },
        mobile:{
            required:true,
            minlength:10,
            maxlength:12
        }
    },
    messages: {
        name: {
            required:"Please enter first name"
        },
        last_name:{
            required:"Please enter last name"
        },
        email: {
            required: "Please enter email",
            email: "Please enter valid email",
            maxlength: "The email name should less than or equal to 50 characters",
        },
        password:{
            required: "Please enter password"
        },
        password_confirmation: {
            required: "Please enter confirm password",
            equalTo: "Confirm Password should be same as Password"
        },
        mobile:{
            required: "Please enter mobile number"
        }
    }
});

/*  */

/* Reset Email Validation */

$("#resetemailForm").validate({
    rules: {
        email: {
            required:true,
            email: true,
            maxlength: 50,
        }
    },
    messages: {
        email: {
            required: "Please enter email",
            email: "Please enter valid email",
            maxlength: "The email name should less than or equal to 50 characters",
        }
    }
});

/*  */

/* Reset Password Validation */

$("#resetForm").validate({
    rules: {
        password:{
            required:true,
            minlength:8,
        },
        password_confirmation:{
            required:true,
            minlength:8,
            equalTo: "#password"
        },
    },
    messages: {
        password:{
            required: "Please enter password"
        },
        password_confirmation: {
            required: "Please enter confirm password",
            equalTo: "Confirm Password should be same as Password"
        },
    }
});

/*  */

/***Exchnage Form***/

$("#exchangeForm").validate({
    rules: {
        amount:{
            required:true,
            number:true
        },
        from_currency:{
            required:true,
        },
        to_currency:{
            required:true
        }
    },
    messages: {
        amount:{
            required: "Please enter amount",
            number: "Please enter the numeric amount"
        },
        from_currency: {
            required: "Please select the currency",
        },
        to_currency:{
            required: "Please select the currency",
        }
    }
});

/**********/

/***Profile NGN Update Form***/

$("#ngnprofileUpdateForm").validate({
    rules: {
        bank_code:{
            required:true
        },
        account_no:{
            required:true,
            minlength:10,
            maxlength:10
        },
        account_name:{
            required:true,
        }        
    },
    messages: {
        bank_code:{
            required:"Please select bank"
        },
        account_no:{
            required: "Please enter account number"
        },
        account_name: {
            required: "Please enter account name",
        },
    }
});

/**********/

/***Profile PM Update Form***/

$("#pmprofileUpdateForm").validate({
    rules: {
        account_no:{
            required:true,
        },
        ifsc_code:{
            required:true,
        }        
    },
    messages: {
        account_no:{
            required: "Please enter account number"
        },
        ifsc_code: {
            required: "Please enter ifsc code",
        }
    }
});

/**********/

/***Profile NGN Update Form***/

$("#btcprofileUpdateForm").validate({
    rules: {
        account_no:{
            required:true,
        },
        ifsc_code:{
            required:true,
        }        
    },
    messages: {
        account_no:{
            required: "Please enter account number"
        },
        ifsc_code: {
            required: "Please enter ifsc code",
        }
    }
});

/**********/

/***Profile update Form***/

$("#userprofileForm").validate({
    rules: {
        name:{
            required:true,
        },
        email:{
            required:true,
            email:true
        },
        mobile:{
            required:true
        }
    },
    messages: {
        name:{
            required: "Please enter name"
        },
        email: {
            required: "Please enter email",
            email: "Please enter valid email"
        },
        mobile: {
            required: "Please enter number"
        }
    }
});

/**********/

/***Change password Form***/

$("#chnagePasswordForm").validate({
    rules: {
        old_password:{
            required:true,
        },
        password:{
            required:true,
        },
        confirm_password:{
            required:true,
            equalTo:'#password'
        }
    },
    messages: {
        old_password:{
            required: "Please enter old password"
        },
        password:{
            required: "Please enter new password"
        },
        confirm_password: {
            required: "Please enter confirm password",
            equalTo: "Confirm Password should be same as Password"
        },
    }
});

/* ***********BTC form*********** */
$("#btcForm").validate({
    rules:{
        bitcoin_wallet:{
            required:true
        },
        bitcoin_address:{
            required:true
        },
        bitcoin_password:{
            required:true
        }
    },
    messages:{
        bitcoin_wallet:{
            required:"Please enter your bitcoin wallet id"
        },
        bitcoin_address:{
            required:"Please enter your bitcoin wallet address"
        },
        bitcoin_password:{
            required:"Please enter your password"
        }
    }
});
/* ****************************** */

/**********/
if($("#userTransactionTbl").length > 0){
    $("#userTransactionTbl").DataTable();
}

function removeSelected(){
    $.ajax({
        url:base_url+"/currency",
        type:"POST",
        success:function(response){
            if(response.length > 0){
                var currency = [];
                for(var i=0;i<response.length;i++){
                    currency.push(response[i].name)
                }
            }
            var arr1 = currency;
            var arr2 = [$('select[name="from_currency"] option:selected').val()];   
            arr1 = arr1.filter(val => !arr2.includes(val));
            $('select[name="to_currency"]').empty();
            $('select[name="to_currency"]').append($('<option></option>').val("").html('-Select Any Currency-'));
            $.each(arr1,function(i,p){
                $('select[name="to_currency"]').append($('<option></option>').val(p).html(p));
            });
        },
        error:function(error){
            console.log("Internal server error"+error);
            alert("Internal server error"+error);
        }
    });
}

function autoFetchName(data){
    var bank_code = $('select[name=bank_code] option:selected').val().split(',')[0];
    var account_no = $('input[name=account_no]').val();
    if(bank_code != "" && account_no != "" && account_no.length == 10){
        $.ajax({
            url: base_url+"/ngnAutoFetch",
            type:"POST",
            data:{bank_code:bank_code,account_no:account_no},
            beforeSend:function(){
                $("#main_loader").css('display','flex');
                // $("body").css({"margin":"0","height": "100%","overflow": "hidden"});
            },
            success:function(response){
                $("#main_loader").hide();
                if(response.responsemessage == "success" && response.responsecode == "00"){
                    $("input[name=account_name]").empty().val(response.accountname);    
                    $(".errorAccount").empty().text("");
                }else{
                    $("input[name=account_name]").val("");
                    $(".errorAccount").empty().text(response.responsemessage).css('color','red');
                }
            }
        });
    }else{
        return false;
    }
}

function exchangeRate(){
    var from_currency = $('select[name=from_currency] option:selected').val();
    var to_currency = $('select[name=to_currency] option:selected').val();
    var amount = $('input[name="amount"]').val();
    if(from_currency != "" && to_currency != "" && amount != ""){
        /*alert("hello")
        alert(amount);*/
        $.ajax({
            url: base_url+"/exchangeRate",
            type:"POST",
            data:{from_currency:from_currency,to_currency:to_currency,amount:amount},
            beforeSend:function(){
                $("#main_loader").css('display','flex');
            },
            success:function(response){
                $("#main_loader").hide();
                $("#exchangeRateConverter").show();
                $("#btnValue").attr('disabled',response.btnValue);
                if(response.success == "1"){
                    $(".exchangeRate").empty().html(response.msg);
                }else{
                    $("#exchangeRateConverter").hide();
                    $(".exchangeRate").empty().html(response.msg);
                }
            }
        });
    }else{
        $("#exchangeRateConverter").hide();
        return false;
    }
}

/*function autoTransfer(){
    $.ajax({
        url:base_url+"/autoTransfer",
        type:"POST",
        success:function(response){
            if(response && response.is_admin){
                alert(response.msg)
            }
        },
        error:function(error){
            console.log(JSON.stringify(error))
            // alert("Error"+error)
        }
    });
}*/

/*$("#exchangeForm").submit(function(){
    var from = $('input[name=from_currency]').val();
    var to = $('input[name=to_currency]').val();
    var amount = $('input[name=amount]').val();
    if(from !="" && to != "" && amount != ""){
        localStorage.setItem('from',from);
        localStorage.setItem('to',to);
        localStorage.setItem('amount',amount);
        alert(localStorage.getItem('from'))
    }
});*/