$(document).ready(function() {
    $(function () {
        $("[rel='tooltip']").tooltip();
    });

  
//finds the product and displayes the product list
    $("#scanSKU").keyup(function () {
        
        var query = $(this).val();
        var sroom = $(stockroom).val();
        if (sroom ==null){
            alert("Select a Stockroom first")
        } else
        if (query != "") {
            $.ajax({
                url: 'php/ajax_products_scaned.php',
                method: 'POST',
                data: {
                    query: query,
                    sroom: sroom
                },
                success: function (data) {
                    $('#search_result').html(data);
                    $('#search_result').css('display', 'block');
                    $("#scanSKU").focusout(function () {
                        
                    });
                    $("#scanSKU").focusin(function () {
                       
                        $('#search_result').css('display', 'block');
                        $('#search_result').css('display', 'none');
                    });
                }
            });
        } else {
            $('#search_result').css('display', 'none');
           
        }
    });


    //cleares out the model on close
    $('#scanProductMod').on('hidden.bs.modal', function (e) {
        $(this)
          .find("input[type=text],input[type=number],textarea,select")
             .val('')
             .end()
          .find("input[type=checkbox], input[type=radio]")
             .prop("checked", "")
             .end();
      });

    });



function getScan(){
	                
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#yourElement')    // Or '#yourElement' (optional)
        },
        decoder: {
            readers: ["code_128_reader"]
        }
    }, function (err) {
        if (err) {
            console.log(err);
            return
        }
        console.log("Initialization finished. Ready to start");
        Quagga.start();
    });

 }      
 //valadation
 function isNotEmpty(caller){
    if (caller.val()=='') {
        caller.css('border', '2px solid red');
        return false;
    } else 
    caller.css ('border','');
    return true;
}
//valadation
function isNotSelected(caller){
    if (caller.val()==null) {
        caller.css('border', '2px solid red');
        return false;
    } else {
    caller.css ('border','');
    return true;
}}
//valadation
function selectedSR(supplyroom) {
   
    $('#scanSKU').val("");
    $('#search_result').css('display', 'none');
    var selected_supplyroom_text = supplyroom.options[supplyroom.selectedIndex].text;
       document.getElementById("selectedSR").innerHTML = selected_supplyroom_text;
}

function getScanProd(rowID) {
    var rowID = rowID;
   var sku =$("#scanSKU");
   var stockroomTxt=  $( "#stockroom option:selected" ).text();
  
   $.ajax({
    url: 'php/ajax_products_scaned.php',
    method: 'POST',
    dataType: 'json',
    data: {
        key:'getRowData',
        rowID:rowID 
    }, success: function(responce){
        $("#editRowID").val(rowID);
        $("#price").html(responce.price);
        $("#productName").html(responce.productName);
        $("#sku").html(responce.sku);
        $("#supplier").html(responce.supplier);
        $("#supplierProductNumber").html(responce.supplierProductNumber);
        $("#issueUOM").html(responce.issueUOM);
        $("#onHand").html(responce.onHand);
        $("#category").html(responce.category);
        $("#modalTitle").html(stockroomTxt+"~"+responce.productName);
        

   $("#scanProductMod").modal('show');
}
          
});
}

 
function scanProd() {
   //in the works 

   
   var sku =$("#scanSKU");
   var stockroom_id= $( "#stockroom" );
   var stockroomTxt=  $( "#stockroom option:selected" ).text();
   $("#modalTitle").html(stockroomTxt);
   $.ajax({
       url:'../php/ajax_inventory.php',
       method: 'POST',
       dataType: 'json',
       data: {
           key:'getScan',
           stockroom_id: stockroom_id
       }, success: function(responce){
           $("#editRowID").val(rowID);
           $("#sku").val(responce.sku);
           $("#productName").val(responce.productName);
           $("#category").val(responce.category);
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

function isMoreThanOnHand(caller,onHand,issueUOM){
         if (caller<0){
        alert("You can only Pick a max of"+onHand+' '+issueUOM);
        return false; 
      } else
       
        return true;
    }


// removes product from storeroom count and adds it to the transation table.
function pick(rowID){
   var rowID = rowID;
   var price = $("#price").html();
   var productName = $("#productName").html();
   var sku = $("#sku").html();
   var supplier = $("#supplier").html();
   var supplierProductNumber = $("#supplierProductNumber").html();
   var issueUOM = $("#issueUOM").html();
   var onHand = $("#onHand").html();
   var category =$("#category").html();
   var selectInventoryAccount = $("#selectInventoryAccount");
   var selectChargeAccount = $("#selectChargeAccount");
   var quantity = $("#quantity");
   var newOnHand =onHand-quantity.val();
  
   if (isNotEmpty(quantity) && isNotSelected(selectInventoryAccount) && isNotSelected(selectChargeAccount) && isMoreThanOnHand(newOnHand, onHand, issueUOM))
 
   
   $.ajax({
    url: 'php/ajax_products_scaned.php',
    method: 'POST',
    dataType: 'text',
    data: {
        key:'pick',
        rowID:rowID, 
        price:price,
        productName: productName, 
        sku: sku,
        supplier: supplier, 
        supplierProductNumber: supplierProductNumber,
        issueUOM: issueUOM, 
        onHand: onHand, 
        category: category, 
        inventoryAccount: selectInventoryAccount.val(),
        chargeAccount: selectChargeAccount.val(),
        quantity: quantity.val()
    }, success: function(responce){
        
        $("#selectInventoryAccount").val("");
        $("#selectChargeAccount").val("");
        $("#quantity").val("");
       

        $("#badge_"+rowID).html(newOnHand+' '+issueUOM);
                  $("#scanProductMod").modal('hide');
             
       }  
       
});
   }

