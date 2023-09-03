<?php 
include 'dbcon.php';





if (isset($_POST['key'])) {

   

     //gets the data for the edit modle
    if($_POST['key']== 'getRowData') {
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
           // 'imagePath' => $data['image_path']
        );
        exit(json_encode($jsonArray));

    }
    //delete record by rowID
    if($_POST['key'] == 'deleteRow'){
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql1 = $conn->query("DELETE FROM tbl_products WHERE id='$rowID'");
        $responce ='Product Was Removed!';
        exit($responce);
    }
    

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
       
        
        $sql1 = $conn->query("SELECT * FROM tbl_products LIMIT $start, $limit");
        
        if ($sql1->num_rows >0) {
            $response = "";
            while($data =$sql1->fetch_array()) {
               
                $response .= '
                <tr>
                    <td id="barcode_'.$data["id"].'"><img alt='.$data["sku"].' src="php/barcode.php?codetype=Code39&size=40&text='.$data["sku"].'&print=true"/></td>
                    <td id="sku_'.$data["id"].'">'.$data["sku"].'</td>
                    <td id="product_name_'.$data["id"].'">'.$data["product_name"].'</td>
                    <td id="category_'.$data["id"].'">'.$data["category"].'</td>                                        
                    <td id="supplier_'.$data["id"].'">'.$data["supplier"].'</td>
                    <td id="supplier_product_number_'.$data["id"].'">'.$data["supplier_product_number"].'</td>                    
                    <td id="order_uom_'.$data["id"].'">'.$data["order_uom"].'</td>
                    <td data-order='.$data["cost"].' id="cost_'.$data["id"].'">$'.$data["cost"].'</td>                   
                    <td id="stock_factor_'.$data["id"].'">'.$data["stock_factor"].'</td>
                    <td id="issue_uom_'.$data["id"].'">'.$data["issue_uom"].'</td>
                    <td data-order='.$data["price"].' id="price_'.$data["id"].'">$'.$data["price"].'</td>
                   
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