$(document).ready(function(){
    
    $(".tab a").each(function (index, element) {
      /*if(window.location.toString().indexOf("admin/appointments") != -1){
        if($(this).attr('href').indexOf("admin/appointments") != -1){
          $(this).parent().parent().addClass("show");
          $(this).parent().addClass("active");
        }
      }
      if(window.location.toString().indexOf("admin/form-builder/forms") != -1){
        if($(this).attr('href').indexOf("admin/form-builder/forms") != -1){
          $(this).parent().parent().addClass("show");
          $(this).parent().addClass("active");
        }
      }*/
      if ($(this).attr('href') == window.location) {
        $(this).parent().parent().addClass("show");
        $(this).parent().addClass("active");
      }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#currencyTable').DataTable({
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [2] }, 
        ]
    });

    $("#transactionTable").DataTable({
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [7] }, 
        ]
    });

    $("#exchangeRateTable").DataTable({
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [5] }, 
        ]
    });

    /*var transaction = $("#transactionTable").DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":base_url+'/'+'admin/transaction',
        "columns":[
            {"data":"name"},
            {"data":"amount"},
            {"data":"from_currency"},
            {"data":"to_currency"},
            {"data":"status"},
            {"data":"action"}
        ]
    });*/

    /* Admin Side Validation */
    $("#currencyForm").validate({
        rules: {
            name: {
                required:true
            },
            value:{
                required:true
            }
        },
        messages: {
            name: {
                required: "Please enter currency name",
            },
            value:{
                required: "Please enter currency value"
            }
        }
    });
    /*  */

    $("#ngnupdateProfile").validate({
        rules: {
            bank_name: {
                required:true
            },
            bank_code:{
                required:true
            },
            bank_account_no:{
                required:true
            }
        },
        messages: {
            bank_name: {
                required: "Please enter bank name",
            },
            bank_code:{
                required: "Please enter bank code"
            },
            bank_account_no:{
                required: "Please enter bank account no"
            }
        }
    });

    $("#pmupdateProfile").validate({
        rules: {
            bank_username: {
                required:true
            },
            bank_password:{
                required:true
            },
            bank_account_no:{
                required:true
            }
        },
        messages: {
            bank_username: {
                required: "Please enter bank username",
            },
            bank_password:{
                required: "Please enter bank password"
            },
            bank_account_no:{
                required: "Please enter bank account no"
            }
        }
    });

    /* Transaction Status change */
    $('#dt-server-processing').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":"dt-json-data/scripts/server-processing.php",
        "columns":[
            {"data":"first_name"},{"data":"last_name"},{"data":"position"},{"data":"office"},{"data":"start_date"},{"data":"salary"}
        ]
    });

    $("body").on('click','#success',function(){
        var id = $(this).data('id');
        var value = $(this).data('value');
        var status = $(this).data('status');
        // alert(base_url+'/'+'admin/transaction/'+id)
        if(id != ""){
            $.ajax({
                url:base_url+'/'+'admin/transaction/'+id,
                type:"PATCH",
                data:{id:id,value:value,status:status},
                beforeSend:function(){
                    // $(".main-loader").show();
                },
                success:function(data){
                    // $("#main-loader").hide();
                    if(data.result == true){
                        toastr["success"](data.msg,"Success");
                        // $("#transactionTable").DataTable();
                    }else{
                        toastr["error"](data.msg,"Oh snap!");
                    }
                    window.location.reload();
                },
                error:function(error){
                    toastr["error"](error,"Oh snap!");
                }
            });
        }
    });
    /*  */

    $("body").on('click','#reject',function(){
        var id = $(this).data('id');
        var value = $(this).data('value');
        var status = $(this).data('status');
        // alert(base_url+'/'+'admin/transaction/'+id)
        if(id != ""){
            $.ajax({
                url:base_url+'/'+'admin/transaction/'+id,
                type:"PATCH",
                data:{id:id,value:value,status:status},
                beforeSend:function(){
                    // $(".main-loader").show();
                },
                success:function(data){
                    // $("#main-loader").hide();
                    if(data.success == "1"){
                        toastr["success"](data.msg,"Success");
                        window.location.reload();
                        // $("#transactionTable").DataTable();
                    }else if(data.success == "0"){
                        toastr["error"](data.msg,"Oh snap!");
                        window.location.reload();
                    }
                },
                error:function(error){
                    toastr["error"](error,"Oh snap!");
                }
            });
        }
    });

});

function autoTransferAdmin(data){
    var id = $(data).data('id');
    var to_currency = $(data).data('to');
    var from_currency = $(data).data('from');
    if(id && id != "" && to_currency != ""){
        $.ajax({
            url:base_url+"/autoTransferAdmin",
            type:"POST",
            data:{id:id,to_currency:to_currency},
            beforeSend:function(){
                $("#main_loader").css('display','flex');
            },
            success:function(response){
                $("#main_loader").css('display','none');
                
                if(response && response.is_admin && response.success){
                    toastr["success"](response.msg,"Success");
                    window.location.reload();
                }else if(response && response.is_admin && response.success == false){
                    toastr["error"](response.msg,"Oh snap!");
                    window.location.reload();
                }
            },
            error:function(error){
                console.log(JSON.stringify(error))
                // alert("Error"+error)
            }
        });
    }else{
        return false;
    }
}