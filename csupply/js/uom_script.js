$(document).ready(function() {
   
    $(function () {
        $("[rel='tooltip']").tooltip();
    });


//controls the addNew btn
    $("#addNew").on('click',function() {
       
            $("#rowID").val('');
            $("#uom").val('');
            $("#description").val('');
            
            
        $("#modalTitle").html('Add UOM');
        $("#tableManager").modal('show');
        
    });

    getExistingData (0,1000);
   });

  


   function edit(rowID) {
    $("#modalTitle").html('Edit UOM');
    $.ajax({
        url:'../php/ajax_uom.php',
        method: 'POST',
        dataType: 'json',
        data: {
            key:'getRowData',
            rowID: rowID
        }, success: function(responce){
            $("#editRowID").val(rowID);
            $("#uom").val(responce.uom);
            $("#description").val(responce.description);
            $("#tableManager").modal('show');
            $("#manageBtn").attr('value', 'Save Changes').attr('onclick', "manageData('updateRow')");

        }
           
    });  

   }
//gets the data for the paganation window
function getExistingData(start, limit) {
    $.ajax({
        url:'../php/ajax_uom.php',
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
        

        var uom =$("#uom");
        var description =$("#description");
        var editRowID =$("#editRowID");

        if (isNotEmpty(uom) && isNotEmpty(description))
        {
            $.ajax({
                url:'../php/ajax_uom.php',
                method: 'POST',
                dataType: 'text',

                data: {
                    
                    key:key,
                    uom: uom.val(), 
                    description: description.val(),
                    rowID: editRowID.val()
                }, success: function(responce){
                    if (responce != "UOM updated"){
                        $("#tableManager").modal('hide');
                        alert(responce); 
                        location.reload();
                    }
                    else{
                        
                        $("#uom_"+editRowID.val()).html(uom.val());
                        $("#description_"+editRowID.val()).html(description.val());                   
                                                
                        uom.val('');
                        description.val('');
                        
                        
                        $("#tableManager").modal('hide');
                        $("#manageBtn").attr('value', 'Add UOM').attr('onclick', "manageData('addNew')");
                    }
                }

            });
        }            
    }

    function deleteRow(rowID){
        if (confirm('Are you sure you want to delete this UOM. This can not be undone!')){
            $.ajax({
                url:'../php/ajax_uom.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    key:'deleteRow',
                    rowID: rowID   

                },  success: function(responce){
                    $("#uom_"+rowID).parent().remove();
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
   