$(document).ready(function() {
   
    $(function () {
        $("[rel='tooltip']").tooltip();
    });


    

//controls the Add new btn
    $("#addNew").on('click',function() {
       
            $("#rowID").val('');
            $("#sku").val('');
            $("#productName").val('');
            $("#category_id").val('');
            $("#category").val('');
            $("#supplier").val('');
            $("#supplierProductNumber").val('');
            $("#cost").val('');
            $("#orderUOM").val('');
            $("#stockFactor").val('');
            $("#issueUOM").val('');
            $("#price").val('');
            $("#imagePath").attr('src','');
            $("#imageFile").val('');
            
        $("#modalTitle").html('Add Products');
        $("#tableManager").modal('show');
        
    });

    getExistingData (0,1000);
   });

  


   function edit(rowID) {
    $("#modalTitle").html('Edit Product');
    $.ajax({
        url:'../php/ajax_products.php',
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
            $("#supplier_id").val(responce.supplierID);
            $("#supplier").val(responce.supplier);
            $("#supplierProductNumber").val(responce.supplierProductNumber);
            $("#cost").val(responce.cost);
            $("#orderUOM").val(responce.orderUOM);
            $("#stockFactor").val(responce.stockFactor);
            $("#issueUOM").val(responce.issueUOM);
            $("#price").val(responce.price);
           // $("#imagePath").attr('src',responce.imagePath);
            $("#tableManager").modal('show');
            $("#manageBtn").attr('value', 'Save Changes').attr('onclick', "manageData('updateRow')");

        }
           
    });  

   }

function getExistingData(start, limit) {
    $.ajax({
        url:'../php/ajax_products.php',
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
                buttons: [ {
                    extend:'copy',
                    exportOptions: {
                        
                        columns: [1, 2, 3, 4, 5, 6, 7, 8,9] 
                        //specify which column you want to print
    
                    }
                    },  {
                    extend:'csv',
                    exportOptions: {
                        
                        columns: [1, 2, 3, 4, 5, 6, 7, 8,9] 
                        //specify which column you want to print
    
                    }
                    }, 
                {
                    extend:'excel',
                    exportOptions: {
                        
                        columns: [1, 2, 3, 4, 5, 6, 7, 8,9] 
                        //specify which column you want to print
    
                    }
                    }, {
                    extend:'pdf',
                    exportOptions: {
                        
                        columns: [1, 2, 3, 4, 5, 6, 7, 8,9] 
                        //specify which column you want to print
    
                    }
                    }, {
                extend:'print',
                exportOptions: {
                    stripHtml : false,
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9] 
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
//manages data for products 
    function manageData(key) {
        
        var sku =$("#sku");
        var productName =$("#productName");
        var category =$("#category");
        var supplierID =$("#supplier_id");
        var supplier =$("#supplier");
        var supplierProductNumber =$("#supplierProductNumber");
        var cost =$("#cost");
        var orderUOM =$("#orderUOM");
        var stockFactor =$("#stockFactor");
        var issueUOM =$("#issueUOM");
        var price =$("#price");
        var editRowID =$("#editRowID");

        if (isNotEmpty(sku) && isNotEmpty(productName) && isNotSelected(category) && isNotSelected(supplier) && isNotEmpty(supplierProductNumber) && isNotEmpty(cost)&& isNotSelected(orderUOM)&& isNotEmpty(stockFactor)&& isNotSelected(issueUOM)&& isNotEmpty(price))
        {
            $.ajax({
                url:'../php/ajax_products.php',
                method: 'POST',
                dataType: 'text',

                data: {
                    
                    key:key,
                    sku: sku.val(), 
                    productName: productName.val(),
                    category: category.val(),
                    supplierID: supplierID.val(),
                    supplier: supplier.val(),
                    supplierProductNumber:supplierProductNumber.val(),
                    cost: cost.val(),
                    orderUOM: orderUOM.val(), 
                    stockFactor: stockFactor.val(),
                    issueUOM: issueUOM.val(),
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
                        $("#cost_"+editRowID.val()).html(cost.val());
                        $("#order_uom_"+editRowID.val()).html(orderUOM.val());
                        $("#stock_factor_"+editRowID.val()).html(stockFactor.val());
                        $("#issue_uom_"+editRowID.val()).html(issueUOM.val());
                        $("#price_"+editRowID.val()).html(price.val());
                       
                        
                        
                        sku.val('');
                        productName.val('');
                        category.val('');
                        supplierID.val('');
                        supplier.val('');
                        supplierProductNumber.val('');
                        cost.val('');
                        orderUOM.val('');
                        stockFactor.val('');
                        issueUOM.val('');
                        price.val('');
                        
                        $("#tableManager").modal('hide');
                        $("#manageBtn").attr('value', 'Add Product').attr('onclick', "manageData('addNew')");
                    }
                }

            });
        }            
    }

    

    function deleteRow(rowID){
        if (confirm('Are you sure you want to delete this sku. This can not be undone!')){
            $.ajax({
                url:'../php/ajax_products.php',
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

    function getSupplier(sel) {
        
        supplier= sel.options[sel.selectedIndex].text;
        $("#supplier").val(supplier);
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

      
      
    
         
       
     
