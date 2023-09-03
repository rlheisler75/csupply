$(document).ready(function() {
   
    $(function () {
        $("[rel='tooltip']").tooltip();
    });


//controls the addNew btn
    $("#addNew").on('click',function() {
       
            $("#rowID").val('');
            $("#Account").val('');
            $("#description").val('');
            
            
        $("#modalTitle").html('Add Account');
        $("#tableManager").modal('show');
        
    });

    getExistingData (0,1000);
   });

  


   function edit(rowID) {
    $("#modalTitle").html('Edit Account');
    $.ajax({
        url:'../php/ajax_accounts.php',
        method: 'POST',
        dataType: 'json',
        data: {
            key:'getRowData',
            rowID: rowID
        }, success: function(responce){
            $("#editRowID").val(rowID);
            $("#account").val(responce.account);
            $("#description").val(responce.description);
            $("#tableManager").modal('show');
            $("#manageBtn").attr('value', 'Save Changes').attr('onclick', "manageData('updateRow')");

        }
           
    });  

   }
//gets the data for the paganation window
function getExistingData(start, limit) {
    $.ajax({
        url:'../php/ajax_accounts.php',
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
 //adds data on load and manage data for edit modle
    function manageData(key) {
        

        var account =$("#account");
        var description =$("#description");
        var editRowID =$("#editRowID");

        if (isNotEmpty(account) && isNotEmpty(description))
        {
            $.ajax({
                url:'../php/ajax_accounts.php',
                method: 'POST',
                dataType: 'text',

                data: {
                    
                    key:key,
                    account: account.val(), 
                    description: description.val(),
                    rowID: editRowID.val()
                }, success: function(responce){
                    if (responce != "Account updated"){
                        $("#tableManager").modal('hide');
                        alert(responce); 
                        location.reload();
                    }
                    else{
                        
                        $("#account"+editRowID.val()).html(account.val());
                        $("#description_"+editRowID.val()).html(description.val());                   
                                                
                        account.val('');
                        description.val('');
                        
                        
                        $("#tableManager").modal('hide');
                        $("#manageBtn").attr('value', 'Add Account').attr('onclick', "manageData('addNew')");
                    }
                }

            });
        }            
    }

    function deleteRow(rowID){
        if (confirm('Are you sure you want to delete this Account. This can not be undone!')){
            $.ajax({
                url:'../php/ajax_accounts.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    key:'deleteRow',
                    rowID: rowID   

                },  success: function(responce){
                    $("#account"+rowID).parent().remove();
                    location.reload();
                    alert(responce);
                    
    
                }
               
            });  
    
        } 
    
    }
// Valadation of form fields
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
   