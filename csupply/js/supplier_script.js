$(document).ready(function() {
   
    $(function () {
        $("[rel='tooltip']").tooltip();
    });


//controls the Add new btn
    $("#addNew").on('click',function() {
       
            $("#rowID").val('');
            $("#supplier").val('');
            $("#account").val('');
            $("#contact_first_name").val('');
            $("#contact_last_name").val('');
            $("#email").val('');
            $("#phone").val('');
            $("#corp_phone").val('');
            $("#street_address").val('');
            $("#street_address_line_2").val('');
            $("#city").val('');
            $("#state").val('');
            $("#postal").val('');
            
            
        $("#modalTitle").html('Add Supplier');
        $("#tableManager").modal('show');
        
    });

    getExistingData (0,1000);
   });

  


   function edit(rowID) {
    $("#modalTitle").html('Edit Supplier');
    $.ajax({
        url:'../php/ajax_supplier.php',
        method: 'POST',
        dataType: 'json',
        data: {
            key:'getRowData',
            rowID: rowID
        }, success: function(responce){
            $("#editRowID").val(rowID);
            $("#supplier").val(responce.supplier);
            $("#account").val(responce.account);
            $("#contact_first_name").val(responce.contact_first_name);
            $("#contact_last_name").val(responce.contact_last_name);
            $("#email").val(responce.email);
            $("#phone").val(responce.phone);
            $("#corp_phone").val(responce.corp_phone);
            $("#street_address").val(responce.street_address);
            $("#street_address_line_2").val(responce.street_address_line_2);
            $("#city").val(responce.city);
            $("#state").val(responce.state);
            $("#postal").val(responce.postal);
            $("#tableManager").modal('show');
            $("#manageBtn").attr('value', 'Save Changes').attr('onclick', "manageData('updateRow')");

        }
           
    });  

   }
//gets the data for the table view and sets the options on the data table plugin
function getExistingData(start, limit) {
    $.ajax({
        url:'../php/ajax_supplier.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key:'getExistingData',
            start: start,
            limit: limit
        }, success: function(responce){
            if (responce != "reachedMax") {
                $('tbody').append(responce);
                start+= limit;
                getExistingData(start, limit);
            } else
            $(".table").DataTable({
                responsive: true,
                dom: 'lfBrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,}]
                });
        } 
    });
}
//manages data for products 
    function manageData(key) {
        

        var account =$("#account");
        var contact_first_name =$("#contact_first_name");
        var contact_last_name =$("#contact_last_name");
        var supplier =$("#supplier");
        var email =$("#email");
        var phone =$("#phone");
        var corp_phone =$("#corp_phone");
        var street_address =$("#street_address");
        var street_address_line_2 =$("#street_address_line_2");
        var city =$("#city");
        var state =$("#state");
        var postal =$("#postal");
        var editRowID =$("#editRowID");

        if (isNotEmpty(account) && isNotSelected(supplier))
        {
            $.ajax({
                url:'../php/ajax_supplier.php',
                method: 'POST',
                dataType: 'text',

                data: {
                    
                    key:key,
                    supplier: supplier.val(),
                    account: account.val(), 
                    contact_first_name: contact_first_name.val(),
                    contact_last_name: contact_last_name.val(),
                    email:email.val(),
                    phone: phone.val(),
                    corp_phone: corp_phone.val(), 
                    street_address: street_address.val(),
                    street_address_line_2: street_address_line_2.val(),
                    city: city.val(),
                    state: state.val(),
                    postal: postal.val(),
                    rowID: editRowID.val()
                }, success: function(responce){
                    if (responce != "Supplier Updated"){
                        $("#tableManager").modal('hide');
                        alert(responce); 
                        location.reload();
                    }
                    else{
                        
                        $("#supplier_"+editRowID.val()).html(supplier.val());
                        $("#account_"+editRowID.val()).html(account.val());
                        $("#product_name_"+editRowID.val()).html(contact_first_name.val());
                        $("#contact_last_name_"+editRowID.val()).html(contact_last_name.val());
                        $("#supplier_product_number_"+editRowID.val()).html(email.val());
                        $("#phone_"+editRowID.val()).html(phone.val());
                        $("#order_uom_"+editRowID.val()).html(corp_phone.val());
                        $("#stock_factor_"+editRowID.val()).html(street_address.val());
                        $("#issue_uom_"+editRowID.val()).html(street_address_line_2.val());
                        $("#city_"+editRowID.val()).html(city.val());
                        $("#state_"+editRowID.val()).html(state.val());
                        $("#postal_"+editRowID.val()).html(postal.val());
                       
                        
                        supplier.val('');
                        account.val('');
                        contact_first_name.val('');
                        contact_last_name.val('');
                        email.val('');
                        phone.val('');
                        corp_phone.val('');
                        street_address.val('');
                        street_address_line_2.val('');
                        city.val('');
                        state.val('');
                        postal.val('');
                        
                        $("#tableManager").modal('hide');
                        $("#manageBtn").attr('value', 'Add Product').attr('onclick', "manageData('addNew')");
                    }
                }

            });
        }            
    }

    function deleteRow(rowID){
        if (confirm('Are you sure you want to delete this account. This can not be undone!')){
            $.ajax({
                url:'../php/ajax_supplier.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    key:'deleteRow',
                    rowID: rowID   

                },  success: function(responce){
                    $("#account_"+rowID).parent().remove();
                    alert(responce);
                    
    
                }
               
            });  
    
        } 
    
    }

    function isNotEmpty(caller){
        if (caller.val()=='') {
            caller.css('border', '2px solid red');
            return false;
        } else
        caller.css ('border','');
        return true;
    }
    function isNotSelected(caller){
        if (caller.val()==null) {
            caller.css('border', '2px solid red');
            return false;
        } else
        caller.css ('border','');
        return true;
    }
   