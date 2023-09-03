$(document).ready(function() {
   
    $(function () {
        $("[rel='tooltip']").tooltip();
    });

//controls the Add new btn
    $("#addNew").on('click',function() {
        $("#productHide").show();
       
            $("#rowID").val('');
            $("#sku").val('');
            $("#productName").val('');
            $("#supplierID").val('');
            $("#supplier").val('');
            $("#supplierProductNumber").val('');
            $("#onHand").val('');
            $("#orderUOM").val('');
            $("#stockFactor").val('');
            $("#issueUOM").val('');
            $("#cost").val('');
            $("#imageFile").val('');
            var dropDown = document.getElementById("selectProducts");
            dropDown.selectedIndex = 0;
            var dropDown = document.getElementById("select_Account");
            dropDown.selectedIndex = 0;
            
        $("#modalTitle").html('Add Product to PO');
        $("#tableManager").modal('show');
      
    });

    getExistingData (0,1000);
   });

function reciveProduct(){
    var rowID = $("#editReciveRowID");
    var editProductId = $("#editProductId");
    var toReciveQuantity = $("#toReciveQuantity");
  
   
   $.ajax({
    url:'../php/ajax_recive_line.php',
    method: 'POST',
    dataType: 'text',
    data: {
        key: 'reciveProduct',   
        rowID: rowID.val(),
        editProductId: editProductId.val(),
        toReciveQuantity: toReciveQuantity.val(),

    },  success: function(responce){
       location.reload();
        

    }
   
});  
}


function generatePO(poNumber,stockroom_id,supplier_id){
    var poID= poNumber;
    var stockroom_id= stockroom_id;
    var supplier_id = supplier_id;
    var account = $("#autoAccount");

$.ajax({
    url:'../php/ajax_auto_gen_po.php',
    method: 'POST',
    dataType: 'text',
    data: {
        key:'autogen',
        poID: poID,
        stockroom_id: stockroom_id,
        supplier_id: supplier_id,
        inventory_account:account.val()

    },  success: function(responce){
        location.reload();
        alert(responce);
        

    }
   
});  

}

   function getProduct(selectedProduct) {
   
    $("#modalTitle").html('Add Product to PO');
    rowID=selectedProduct.value;


$.ajax({
    url:'../php/ajax_polines.php',
    method: 'POST',
    dataType: 'json',
    data: {
        key:'getProductData',
        rowID: rowID
        
    }, success: function(responce){
      
        $("#editRowID").val(rowID);
        $("#sku").val(responce.sku);
        $("#productName").val(responce.productName);
        $("#category").val(responce.category);
        $("#supplierID").val(responce.supplierID);
        $("#supplier").val(responce.supplier);
        $("#supplierProductNumber").val(responce.supplierProductNumber);
        $("#orderUOM").val(responce.orderUOM);
        $("#price").val(responce.price);
        $("#stockFactor").val(responce.stockFactor);
        $("#issueUOM").val(responce.issueUOM);
        $("#parLevel").val(responce.par_level);
        $("#onHand").val(responce.on_hand);
        $("#cost").val(responce.cost);
        $("#orderUnits").html(responce.orderUOM);
      

        
        $("#tableManager").modal('show');
      
        

    }
       
});  

}
   
function recive(rowID) {
  

    $.ajax({
        url: '../php/ajax_polines.php',
        method: 'POST',
        dataType: 'json',
        data: {
            key: 'recive',
            rowID: rowID
        }, success: function (responce) {
            $("#recivedProduct").html(responce.productName);
            $("#recivedOrderQuantity").html(responce.orderQuantity);
            $("#headerSKU").html(responce.sku);
            $(".reciveModelUOM").html(responce.orderUOM);
            $("#recivedIn").html(responce.received);
            $("#editReciveRowID").val(responce.id)
            $("#editProductId").val(responce.product_id) 

            $("#reciveModal").modal('show');
           

        }

    });

}



   function edit(rowID) {
    $("#modalTitle").html('PO');
    
    $("#productHide").hide();

    
    $.ajax({
        url:'../php/ajax_polines.php',
        method: 'POST',
        dataType: 'json',
        data: {
            key:'getRowData',
            rowID: rowID
        }, success: function(responce){
            $("#editRowID").val(rowID);
            $("#sku").val(responce.sku);
            $("#productName").val(responce.productName);
            $("#category").val(responce.category);
            $("#supplierID").val(responce.supplierID);
            $("#supplier").val(responce.supplier);
            $("#supplierProductNumber").val(responce.supplierProductNumber);
            $("#orderUOM").val(responce.orderUOM);
            $("#stockFactor").val(responce.stockFactor);
            $("#issueUOM").val(responce.issueUOM);
            $("#parLevel").val(responce.parLevel);
            $("#cost").val(responce.cost);
            $("#orderQuantity").val(responce.orderQuantity);
            $("#account").val(responce.account);
           
            
            
            $("#tableManager").modal('show');
            $("#manageBtn").attr('value', 'Save Changes').attr('onclick', "manageData('updateRow')");
            
        }
           
    });  

   }

function accountModal(){
    $("#accountModal").modal('show');

}

function getAccountName(e) {

    account = e.options[e.selectedIndex].value;
    $("#autoAccount").val(account);
}

function getAccountValue(e) {

    account = e.options[e.selectedIndex].value;
    $("#account").val(account);
}
function getExistingData(start, limit) {
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);
    
    const po_id = urlParams.get('po_id')
    
    

    
    $.ajax({
        url:'../php/ajax_polines.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key:'getExistingData',
            start: start,
            limit: limit,
            po_id: po_id
            
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
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false,
                        
                    },]
                });
        } 
    });
}
//manages data for products and adds 
    function manageData(key) {
        var poID=$("#po_id");
        var stockroomID=$("#stockroom_id");
        var selectProducts =$("#selectProducts");
        var sku =$("#sku");
        var productName =$("#productName");
        var supplierID =$("#supplierID");
        var supplier =$("#supplier");
        var supplierProductNumber =$("#supplierProductNumber");
        var orderUOM =$("#orderUOM");
        var stockFactor =$("#stockFactor");
        var issueUOM =$("#issueUOM");
        var editRowID =$("#editRowID");
        var cost =$("#cost");
        var orderQuantity = $("#orderQuantity");
        var inventory_account = $("#account");
        
     

        if ( isNotEmpty(orderQuantity) && isNotSelected(selectProducts) )
        {
            
            $.ajax({
                url:'../php/ajax_polines.php',
                method: 'POST',
                dataType: 'text',

                data: {
                    
                    key:key,
                    poID: poID.val(),
                    stockroomID: stockroomID.val(),
                    sku: sku.val(), 
                    productName: productName.val(),
                    supplierID: supplierID.val(),
                    supplier: supplier.val(),
                    supplierProductNumber:supplierProductNumber.val(),
                    orderUOM: orderUOM.val(), 
                    stockFactor: stockFactor.val(),
                    issueUOM: issueUOM.val(),
                    cost: cost.val(),
                    rowID: editRowID.val(),
                    orderQuantity: orderQuantity.val(),
                    inventory_account: inventory_account.val()

                }, success: function(responce){
                    if (responce != "Product updated"){
                        $("#tableManager").modal('hide');
                        alert(responce); 
                        location.reload();
                    }
                    else{
                        
                        $("#sku_"+editRowID.val()).html(sku.val());
                        $("#product_name_"+editRowID.val()).html(productName.val());
                        $("#category_"+editRowID.val()).html(category.val());
                        $("#supplier_id_"+editRowID.val()).html(supplierID.val());
                        $("#supplier_"+editRowID.val()).html(supplier.val());
                        $("#supplier_product_number_"+editRowID.val()).html(supplierProductNumber.val());
                        $("#parLevel_"+editRowID.val()).html(parLevel.val());
                        $("#order_uom_"+editRowID.val()).html(orderUOM.val());
                        $("#stock_factor_"+editRowID.val()).html(stockFactor.val());
                        $("#orderQuantity" + editRowID.val()).html(orderQuantity.val());
                        
                     
                       
                        
                        
                        sku.val('');
                        productName.val('');
                        category.val('');
                        supplierID.val('');
                        supplier.val('');
                        supplierProductNumber.val('');
                        parLevel.val('');
                        orderUOM.val('');
                        stockFactor.val('');
                        issueUOM.val('');
                        onHand.val('');
                        
                        $("#tableManager").modal('hide');
                        $("#manageBtn").attr('value', 'Add Product').attr('onclick', "manageData('addNew')");
                    }
                }

            });
        }            
    }

    function deleteRow(rowID){
        if (confirm('Are you sure you want to delete this sku from this PO? This can not be undone!')){
            $.ajax({
                url:'../php/ajax_polines.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    key:'deleteRow',
                    rowID: rowID   

                },  success: function(responce){
                    $("#sku_"+rowID).parent().remove();
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
        if ($(caller).is(":hidden"))
        {return true;}
        else if (caller.val()==null) {
            caller.css('border', '2px solid red');
            return false;
        } else
        caller.css ('border','');
        return true;
    }
   
    