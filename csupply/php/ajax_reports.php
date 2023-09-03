<?php 
include 'dbcon.php';





if (isset($_POST['key'])) {

   

   

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
      //  `price`, `charge_account`, `order_quantity`, `received`, `order_uom`, `cost`, `inventory_account`, `tran_date`
        
        $sql1 = $conn->query("SELECT * FROM tbl_transactions LIMIT $start, $limit");
        
        if ($sql1->num_rows >0) {
            $response = "";
            while($data =$sql1->fetch_array()) {
               
                $response .= '
                <tr>
                    <td id="tran_id_'.$data["tran_id"].'">'.$data["tran_id"].'</td>
                    <td id="sku_'.$data["tran_id"].'">'.$data["sku"].'</td>
                    <td id="product_name_'.$data["tran_id"].'">'.$data["product_name"].'</td>
                    <td id="category_'.$data["tran_id"].'">'.$data["category"].'</td>                                        
                    <td id="supplier_'.$data["tran_id"].'">'.$data["supplier"].'</td>
                    <td id="supplier_product_number_'.$data["tran_id"].'">'.$data["supplier_product_number"].'</td> 
                    <td id="stock_factor_'.$data["tran_id"].'">'.$data["stock_factor"].'</td>
                    <td id="issue_quantity_'.$data["tran_id"].'">'.$data["issue_quantity"].'</td>
                    <td id="issue_uom_'.$data["tran_id"].'">'.$data["issue_uom"].'</td>
                    <td id="price_'.$data["tran_id"].'" data-order='.$data["price"].' >$'.$data["price"].'</td>
                    <td id="charge_account_'.$data["tran_id"].'">'.$data["charge_account"].'</td>
                    <td id="order_quantity_'.$data["tran_id"].'">'.$data["order_quantity"].'</td>
                    <td id="received_'.$data["tran_id"].'">'.$data["received"].'</td>
                    <td id="order_uom_'.$data["tran_id"].'">'.$data["order_uom"].'</td>
                    <td id="cost_'.$data["tran_id"].'" data-order='.$data["cost"].' >$'.$data["cost"].'</td>
                    <td id="inventory_account_'.$data["tran_id"].'">'.$data["inventory_account"].'</td>
                    <td id="tran_date_'.$data["tran_id"].'">'.$data["tran_date"].'</td>
                    
                   
                  
                   
                   
                    </tr>
                ';
    
            }
            exit($response);
    
        } else
            exit('reachedMax');
    }

    $sku = $conn->real_escape_string($_POST['sku']);
    $productName = $conn->real_escape_string($_POST['productName']);
    $category = $conn->real_escape_string($_POST['category']);
    $supplierID = $conn->real_escape_string($_POST['supplierID']);
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $supplierProductNumber = $conn->real_escape_string($_POST['supplierProductNumber']);
    $cost = $conn->real_escape_string($_POST['cost']);
    $orderUOM = $conn->real_escape_string($_POST['orderUOM']);
    $stockFactor = $conn->real_escape_string($_POST['stockFactor']);
    $issueUOM = $conn->real_escape_string($_POST['issueUOM']);
    $price = $conn->real_escape_string($_POST['price']);
    $imagePath = $conn->real_escape_string('image/products/product_ph.jpg');  
    $status = 1; 
    $rowID = $conn->real_escape_string($_POST['rowID']); 
 
    //updates record 
    if($_POST['key']== 'updateRow') {
        
        $sql = $conn->query("UPDATE `tbl_products` SET `sku`='$sku',`product_name`='$productName',`image_path`='$imagePath',`category`='$category', `supplier_id`='$supplierID', `supplier`='$supplier',`supplier_product_number`='$supplierProductNumber',`order_uom`='$orderUOM',`cost`='$cost',`stock_factor`='$stockFactor',`issue_uom`='$issueUOM',`price`='$price',`status`='$status' WHERE id='$rowID'");
        
        exit('Product updated');
    }
    

    //adds new record 
    if($_POST['key']== 'addNew') {
        // checks to see if record alredy in database with the same sku
       // $sql = $conn->query("SELECT id FROM tbl_products WHERE sku ='$sku'");
       // if ($sql->num_rows >0)
       //     exit("A Product With This SKU Already Exists!");
    

                $sql = "INSERT INTO tbl_products (sku, product_name, image_path, category, supplier_id, supplier,supplier_product_number,cost, order_uom, stock_factor, issue_uom, price, status)
                VALUES ('$sku', '$productName', '$imagePath', '$category', '$supplierID', '$supplier','$supplierProductNumber','$cost', '$orderUOM', '$stockFactor', '$issueUOM', '$price', $status)";
                if (mysqli_query($conn, $sql)) {
                     exit('Product Added');
                                                }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
        }
                
}

 
 


?>