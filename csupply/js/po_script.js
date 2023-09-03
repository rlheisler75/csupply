$(document).ready(function() {
   
    $(function () {
        $("[rel='tooltip']").tooltip();
    });


//controls the addNew btn
    $("#addNew").on('click',function() {
       
            $("#rowID").val('');
            $("#stockroom").val('');
            $("#supplier").val('');
            $("#select_stockroom").val('');
            $("#select_supplier").val('');
           
            
            
        $("#modalTitle").html('Create Purchase Order');
        $("#tableManager").modal('show');
        
    });

    getExistingData (0,1000);
   });

   function getSupplerName(e) {
   
    supplier= e.options[e.selectedIndex].text;
    $("#supplier").val(supplier);
   }

   function getStockroomName(e) {
   
    stockroom=  e.options[e.selectedIndex].text;
    $("#stockroom").val(stockroom);
   }


function reciveAndClose(po) {
    var poNum = po;
    var d = new Date();
    cdate = d.toISOString().split('T')[0] + ' ' + d.toTimeString().split(' ')[0];
    

    $.ajax({
        url: '../php/ajax_recive_line.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: 'reciveAll',
            poNum: poNum,


        }, success: function (responce) {
            $("#status_" + poNum).text("closed");
            $("#closed_date_" + poNum).text(cdate);
            
            alert(responce);


        }

    });

}
 

   function edit(rowID) {
    $("#modalTitle").html('Edit Purchase Order');
    $.ajax({
        url:'../php/ajax_po.php',
        method: 'POST',
        dataType: 'json',
        data: {
            key:'getRowData',
            rowID: rowID
        }, success: function(responce){
            $("#editRowID").val(rowID);
            $("#stockroom").val(responce.stockroom);
            $("#description").val(responce.description);
          
            $("#tableManager").modal('show');
            $("#manageBtn").attr('value', 'Save Changes').attr('onclick', "manageData('updateRow')");

        }
           
    });  

   }
//gets the data for the paganation window
function getExistingData(start, limit) {
    $.ajax({
        url:'../php/ajax_po.php',
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
                    buttons: [{
                        extend: 'copy',
                        exportOptions: {

                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                            //specify which column you want to print

                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {

                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                            //specify which column you want to print

                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {

                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                            //specify which column you want to print

                        }
                    }, {
                        extend: 'pdf',
                        messageTop: 'Report for ' + sdate.val() + ' to ' + edate.val() + '!',
                        exportOptions: {

                            columns: [1, 2, 4, 6, 7, 8, 9, 10, 11, 12]
                            //specify which column you want to print

                        }
                    }, {
                        extend: 'print',
                        messageTop: 'Report for ' + sdate.val() + ' to ' + edate.val() + '!',
                        exportOptions: {
                            stripHtml: false,
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                            //specify which column you want to print

                        }
                    }],
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,}]
                });
        } 
    });
}
 //gets data on load and manage data for edit modle
    function manageData(key) {
        
        var stockroom =$("#stockroom");
        var supplier =$("#supplier");
        var stockroomID =$("#select_stockroom");
        var supplierID =$("#select_supplier");
        var editRowID =$("#editRowID");
 
       

        if (isNotEmpty(stockroomID) && isNotEmpty(supplierID))
        {
            $.ajax({
                url:'../php/ajax_po.php',
                method: 'POST',
                dataType: 'text',

                data: {
                    
                    key:key,
                    stockroom: stockroom.val(), 
                    stockroomID: stockroomID.val(),
                    supplierID: supplierID.val(), 
                    supplier: supplier.val(),
                    rowID: editRowID.val(),
                    }, success: function(responce){
                    if (responce != "PO Updated"){
                        $("#tableManager").modal('hide');
                        alert(responce); 
                        location.reload();
                    }
                    else{
                        
                        $("#stockroom_"+editRowID.val()).html(stockroom.val());
                        $("#description_"+editRowID.val()).html(description.val());                   
                                                
                        stockroom.val('');
                        description.val('');
                        
                        
                        $("#tableManager").modal('hide');
                        $("#manageBtn").attr('value', 'Create PO').attr('onclick', "manageData('addNew')");
                    }
                }

            });
        }            
    }

    
    function deleteRow(rowID){
        if (confirm('Are you sure you want to delete this PO. This can not be undone! \n This will not unrecive any products alredy recived')){
            $.ajax({
                url:'../php/ajax_po.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    key:'deleteRow',
                    rowID: rowID   

                },  success: function(responce){
                    $("#stockroom_"+rowID).parent().remove();
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
   