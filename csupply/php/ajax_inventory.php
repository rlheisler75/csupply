<?php 
include 'dbcon.php';

 
 


if (isset($_POST['key'])) {



      //gets the data for the edit modle
    if($_POST['key']== 'getRowData') {
        $rowID = $conn->real_escape_string($_POST['rowID']);
        
        $sql = $conn->query("SELECT * FROM tbl_inventory WHERE id='$rowID' ");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'id' => $data['id'],
            'sku' => $data['sku'],
            'productName' => $data['product_name'],
            'category' => $data['category'],
            'supplierID' => $data['supplier_id'],
            'supplier' => $data['supplier'],
            'supplierProductNumber' => $data['supplier_product_number'],
            'parLevel' => $data['par_level'],
            'orderUOM' => $data['order_uom'],
            'cost' => $data['cost'],
            'stockFactor' => $data['stock_factor'],
            'issueUOM' => $data['issue_uom'],
            'onHand' => $data['on_hand'],
            'price' => $data['price'],
        );
        
        exit(json_encode($jsonArray));

    }
    //delete record by rowID
    if($_POST['key'] == 'deleteRow'){
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql1 = $conn->query("DELETE FROM tbl_inventory WHERE id='$rowID'");
        $responce ='Product Was Removed!';
        exit($responce);
    }
    
//gets data for products getProductData
if($_POST['key']== 'getProductData') {
  
   
        $rowID = $conn->real_escape_string($_POST['rowID']);
        
        $sql = $conn->query("SELECT * FROM tbl_products WHERE id='$rowID' ");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'id' => $data['id'],
            'sku' => $data['sku'],
            'productName' => $data['product_name'],
            'category' => $data['category'],
            'supplierID' => $data['supplier_id'],
            'supplier' => $data['supplier'],
            'supplierProductNumber' => $data['supplier_product_number'],
            'cost' => $data['cost'],
            'orderUOM' => $data['order_uom'],
            'stockFactor' => $data['stock_factor'],
            'issueUOM' => $data['issue_uom'],
            'price' => $data['price'],
          
          
        );
        
        exit(json_encode($jsonArray));
   
    
   
}

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
        $stockroom_id = $conn->real_escape_string($_POST['stockroom_id']);
       
        $sql1 = $conn->query("SELECT * FROM tbl_inventory WHERE stockroom_id = $stockroom_id LIMIT $start, $limit");
         if ($sql1->num_rows >0) {
            $response = "";
            while($data =$sql1->fetch_array()) {
               
                $response .= '
                <tr>
                    
                    <td id="sku_'.$data["id"].'">'.$data["sku"].'</td>
                    <td id="product_name_'.$data["id"].'">'.$data["product_name"].'</td>
                    <td id="category_'.$data["id"].'">'.$data["category"].'</td>                                        
                    <td id="supplier_'.$data["id"].'">'.$data["supplier"].'</td>
                    <td id="supplier_product_number_'.$data["id"].'">'.$data["supplier_product_number"].'</td>                    
                    <td id="order_uom_'.$data["id"].'">'.$data["order_uom"].'</td>
                    <td id="stock_factor_'.$data["id"].'">'.$data["stock_factor"].'</td>
                    <td id="issue_uom_'.$data["id"].'">'.$data["issue_uom"].'</td>
                    <td data-order='.$data["par_level"].' id="price_'.$data["id"].'">'.$data["par_level"].'</td>
                    <td data-order='.$data["on_hand"].' id="cost_'.$data["id"].'">'.$data["on_hand"].'</td>                   
                    <td> <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <input type="button" onclick="edit('.$data["id"].')" value="Edit" class="btn btn-outline-secondary">
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

    $stockroomID = $conn->real_escape_string($_POST['stockroomID']);
    $sku = $conn->real_escape_string($_POST['sku']);
    $productName = $conn->real_escape_string($_POST['productName']);
    $category = $conn->real_escape_string($_POST['category']);
    $supplierID = $conn->real_escape_string($_POST['supplierID']);
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $supplierProductNumber = $conn->real_escape_string($_POST['supplierProductNumber']);
    $orderUOM = $conn->real_escape_string($_POST['orderUOM']);
    $cost = $conn->real_escape_string($_POST['cost']);
    $stockFactor = $conn->real_escape_string($_POST['stockFactor']);
    $issueUOM = $conn->real_escape_string($_POST['issueUOM']);
    $parLevel = $conn->real_escape_string($_POST['parLevel']);
    $onHand = $conn->real_escape_string($_POST['onHand']);
    $rowID = $conn->real_escape_string($_POST['rowID']); 
    $price = $conn->real_escape_string($_POST['price']);
 
    //updates record 
    if($_POST['key']== 'updateRow') {
        
        $sql = $conn->query("UPDATE `tbl_inventory` SET `par_level`='$parLevel',`on_hand`='$onHand' WHERE id='$rowID'");
      
     exit($productName.' has heen updated!');
    }
    

    //adds new record 
    if($_POST['key']== 'addNew') {
        // checks to see if record alredy in database with the same sku
       // $sql = $conn->query("SELECT id FROM tbl_products WHERE sku ='$sku'");
       // if ($sql->num_rows >0)
         //   exit("A Product With This SKU Already Exists!");
    

                $sql = "INSERT INTO tbl_inventory ( `sku`, `product_name`, `category`, `supplier_id`, `supplier`, `supplier_product_number`, `order_uom`, `cost`, `stock_factor`, `issue_uom`, `par_level`, `on_hand`, `price`, `stockroom_id`)
                VALUES ('$sku', '$productName',  '$category', '$supplierID', '$supplier','$supplierProductNumber', '$orderUOM',  '$cost', '$stockFactor', '$issueUOM',  '$parLevel', '$onHand', '$price','$stockroomID')";
                if (mysqli_query($conn, $sql)) {
                     exit('Product Added');
                                                }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
        }
                
}

 
    
 
?>