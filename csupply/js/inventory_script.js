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
            $("#category").val('');
            $("#supplierID").val('');
            $("#supplier").val('');
            $("#supplierProductNumber").val('');
            $("#onHand").val('');
            $("#orderUOM").val('');
            $("#stockFactor").val('');
            $("#issueUOM").val('');
            $("#price").val('');
            $("#parLevel").val('');
            $("#imagePath").attr('src','');
            $("#imageFile").val('');
            
        $("#modalTitle").html('Add Product to Storroom');
        $("#tableManager").modal('show');
      
    });

    getExistingData (0,1000);
   });

   function getProduct(selectedProduct) {
    $("#modalTitle").html('Add Product to Storeroom');
    rowID=selectedProduct.value;


$.ajax({
    url:'../php/ajax_inventory.php',
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
        $("#cost").val(responce.cost);
        $("#stockFactor").val(responce.stockFactor);
        $("#issueUOM").val(responce.issueUOM);
        $("#parLevel").val(responce.par_level);
        $("#onHand").val(responce.on_hand);
        $("#price").val(responce.price);
        $("#tableManager").modal('show');
      
        

    }
       
});  

}
   

   function edit(rowID) {
    $("#modalTitle").html('Edit Product');
    
    $("#productHide").hide();

    
    $.ajax({
        url:'../php/ajax_inventory.php',
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
            $("#cost").val(responce.cost);
            $("#stockFactor").val(responce.stockFactor);
            $("#issueUOM").val(responce.issueUOM);
            $("#price").val(responce.price);
            $("#parLevel").val(responce.parLevel);
            $("#onHand").val(responce.onHand);
           
            
            $("#tableManager").modal('show');
            $("#manageBtn").attr('value', 'Save Changes').attr('onclick', "manageData('updateRow')");
            
        }
           
    });  

   }

   
function getExistingData(start, limit) {
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);
    
    const stockroom_id = urlParams.get('stockroom_id')
    
    

    
    $.ajax({
        url:'../php/ajax_inventory.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key:'getExistingData',
            start: start,
            limit: limit,
            stockroom_id: stockroom_id
            
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
//manages data for products and adds 
    function manageData(key) {
        var stockroomID=$("#stockroom_id");
        var selectProducts =$("#selectProducts");
        var sku =$("#sku");
        var productName =$("#productName");
        var category =$("#category");
        var supplierID =$("#supplierID");
        var supplier =$("#supplier");
        var supplierProductNumber =$("#supplierProductNumber");
        var orderUOM =$("#orderUOM");
        var cost =$("#cost");
        var stockFactor =$("#stockFactor");
        var issueUOM =$("#issueUOM");
        var editRowID =$("#editRowID");
        var parLevel =$("#parLevel");
        var onHand =$("#onHand");
        var price =$("#price");

        if ( isNotEmpty(parLevel) && isNotEmpty(onHand) && isNotSelected(selectProducts) )
        {
            
            $.ajax({
                url:'../php/ajax_inventory.php',
                method: 'POST',
                dataType: 'text',

                data: {
                    
                    key:key,
                    stockroomID: stockroomID.val(),
                    sku: sku.val(), 
                    productName: productName.val(),
                    category: category.val(),
                    supplierID: supplierID.val(),
                    supplier: supplier.val(),
                    supplierProductNumber:supplierProductNumber.val(),
                    orderUOM: orderUOM.val(), 
                    cost: cost.val(),
                    stockFactor: stockFactor.val(),
                    issueUOM: issueUOM.val(),
                    parLevel: parLevel.val(),
                    onHand: onHand.val(),
                    price: price.val(),
                    rowID: editRowID.val()

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
                        $("#issue_uom_"+editRowID.val()).html(issueUOM.val());
                        $("#onHand_"+editRowID.val()).html(onHand.val());
                        $("#cost"+editRowID.val()).html(cost.val()); 
                        $("#price"+editRowID.val()).html(price.val());
                       
                        
                        
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
                        cost.val('');
                        price.val('');
                        
                        $("#tableManager").modal('hide');
                        $("#manageBtn").attr('value', 'Add Product').attr('onclick', "manageData('addNew')");
                    }
                }

            });
        }            
    }

    function deleteRow(rowID){
        if (confirm('Are you sure you want to delete this sku from inventory. This can not be undone!')){
            $.ajax({
                url:'../php/ajax_inventory.php',
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
   
    