<?php 
include 'dbcon.php';

 
 


if (isset($_POST['key'])) {

 //gets the data for the recive modle
    if($_POST['key']== 'recive') {
        $rowID = $conn->real_escape_string($_POST['rowID']);
        
        $sql = $conn->query("SELECT * FROM tbl_po_lines WHERE id='$rowID' ");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'id' => $data['id'],
            'sku' => $data['sku'],
            'productName' => $data['product_name'],
            'supplierID' => $data['supplier_id'],
            'supplier' => $data['supplier'],
            'supplierProductNumber' => $data['supplier_product_number'],
            'orderUOM' => $data['order_uom'],
            'stockFactor' => $data['stock_factor'],
            'cost' => $data['cost'],
            'orderQuantity' => $data['order_quantity'],
            'received' => $data['received'],
            'product_id' => $data['product_id'],
        );
        
        exit(json_encode($jsonArray));

    }


    //gets the data for the edit modle
    if($_POST['key']== 'getRowData') {
        $rowID = $conn->real_escape_string($_POST['rowID']);
        
        $sql = $conn->query("SELECT * FROM tbl_po_lines WHERE id='$rowID' ");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'id' => $data['id'],
            'sku' => $data['sku'],
            'productName' => $data['product_name'],
            'supplierID' => $data['supplier_id'],
            'supplier' => $data['supplier'],
            'supplierProductNumber' => $data['supplier_product_number'],
            'orderUOM' => $data['order_uom'],
            'stockFactor' => $data['stock_factor'],
            'cost' => $data['cost'],
            'inventory_account' => $data['inventory_account'],
        );
        
        exit(json_encode($jsonArray));

    }
    //delete record by rowID
    if($_POST['key'] == 'deleteRow'){
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql1 = $conn->query("DELETE FROM tbl_po_lines WHERE id='$rowID'");
        $responce ='Product Was Removed!';
        exit($responce);
    }
    
    //gets data for products getProductData
    if($_POST['key']== 'getProductData') {
  
   
        $rowID = $conn->real_escape_string($_POST['rowID']);
        
        $sql = $conn->query("SELECT * FROM tbl_inventory WHERE id='$rowID' ");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'id' => $data['id'],
            'sku' => $data['sku'],
            'productName' => $data['product_name'],
            'supplierID' => $data['supplier_id'],
            'supplier' => $data['supplier'],
            'supplierProductNumber' => $data['supplier_product_number'],
            'orderUOM' => $data['order_uom'],
            'stockFactor' => $data['stock_factor'],
            'cost' => $data['cost'],
            'price' => $data['price'],
            'supplier_id' => $data['supplier_id'],
           
            

          
        );
        
        exit(json_encode($jsonArray));
    }
   

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
        $po_id = $conn->real_escape_string($_POST['po_id']);
       
        $sql1 = $conn->query("SELECT * FROM tbl_po_lines WHERE po_id = $po_id LIMIT $start, $limit");
         if ($sql1->num_rows >0) {
            $response = "";
            while($data =$sql1->fetch_array()) {
               
                $response .= '
                <tr>
                    
                    <td id="sku_'.$data["id"].'">'.$data["sku"].'</td>
                    <td id="product_name_'.$data["id"].'">'.$data["product_name"].'</td>                                       
                    <td id="supplier_'.$data["id"].'">'.$data["supplier"].'</td>
                    <td id="supplier_product_number_'.$data["id"].'">'.$data["supplier_product_number"].'</td>                    
                    <td id="stock_factor_'.$data["id"].'">'.$data["stock_factor"].'</td>
                    <td id="order_uom_'.$data["id"].'">'.$data["order_uom"].'</td>
                    <td id="cost_'.$data["id"].'">'.$data["cost"].'</td>
                    <td id="inventory_account_'.$data["id"].'">'.$data["inventory_account"].'</td>   
                    <td id="order_quantity_'.$data["id"].'">'.$data["order_quantity"].'</td>
                    <td id="recived_quantity_'.$data["id"].'">'.$data["received"].'</td>
                    <td> <div class="btn-group" role="group" aria-label="Action group">
                        <input type="button" onclick="edit('.$data["id"].')" value="Edit" class="btn btn-outline-secondary">
                        <input type="button" onclick="recive('.$data["id"].')" value="Recive" class="btn btn-outline-warning">
                        <input type="button" onclick="deleteRow('.$data["id"].')" value="Delete" class="btn btn-outline-danger"> 
                                            
                        </div
                    </td>
                    </tr>
                ';
    
            }
            exit($response);
    
        } else
            exit('reachedMax');
    }

    $poID = $conn->real_escape_string($_POST['poID']);
    $stockroomID = $conn->real_escape_string($_POST['stockroomID']);
    $product_id = $conn->real_escape_string($_POST['rowID']);
    $sku = $conn->real_escape_string($_POST['sku']);
    $productName = $conn->real_escape_string($_POST['productName']);
    $supplierID = $conn->real_escape_string($_POST['supplierID']);
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $supplierProductNumber = $conn->real_escape_string($_POST['supplierProductNumber']);
    $orderUOM = $conn->real_escape_string($_POST['orderUOM']);
    $stockFactor = $conn->real_escape_string($_POST['stockFactor']);
    $rowID = $conn->real_escape_string($_POST['rowID']); 
    $cost = $conn->real_escape_string($_POST['cost']);
    $orderQuantity = $conn->real_escape_string($_POST['orderQuantity']);
    $account = $conn->real_escape_string($_POST['inventory_account']);


   
     
      

  
 
    //updates record 
    if($_POST['key']== 'updateRow') {
        
        $sql = $conn->query("UPDATE `tbl_po_lines` SET `order_quantity`='$orderQuantity'WHERE id='$rowID'");
       
      
     exit($productName.' has heen updated!');
    }
    

    //adds new record 
    if($_POST['key']== 'addNew') {
        // checks to see if record alredy in database with the same sku
       // $sql = $conn->query("SELECT id FROM tbl_products WHERE sku ='$sku'");
       // if ($sql->num_rows >0)
         //   exit("A Product With This SKU Already Exists!");
    

                $sql = "INSERT INTO tbl_po_lines ( `sku`, `product_ID`, `product_name`, `supplier_id`, `supplier`, `supplier_product_number`, `order_uom`, `stock_factor`, `cost`, `stockroom_id`, `po_id`,`order_quantity`,`inventory_account`)
                VALUES ( '$sku',  '$product_id',  '$productName',  '$supplierID', '$supplier','$supplierProductNumber', '$orderUOM', '$stockFactor', '$cost', '$stockroomID', '$poID', '$orderQuantity', '$account')";
                if (mysqli_query($conn, $sql)) {
                     exit('Product Added');
                                                }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
        }
                
}

 
    
 
?>