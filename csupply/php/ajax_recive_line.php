<?php 
include 'dbcon.php';

if (isset($_POST['key'])) {
    
   


    //updates record to recive in line  
    if($_POST['key']== 'reciveProduct') {

         $responce = "";
          $inventory_account = "TEST1"; // $conn->real_escape_string($_POST['inventory_account']);
         $toReciveQuantity = $conn->real_escape_string($_POST['toReciveQuantity']);
         $rowID = $conn->real_escape_string($_POST['rowID']);
         $editProductId = $conn->real_escape_string($_POST['editProductId']);
        
              $sql = $conn->query("UPDATE `tbl_po_lines` SET `received`= `received`+ $toReciveQuantity WHERE `id`=$rowID"); 
              $sql = $conn->query("UPDATE `tbl_inventory` SET `on_hand`= `on_hand`+ $toReciveQuantity WHERE `id`=$editProductId"); 
              $query ="SELECT * FROM `tbl_po_lines` WHERE `id`=$rowID";
                $result = mysqli_query($conn, $query);
              
                if($result->num_rows > 0){ 
                 while($row = $result->fetch_assoc()){  
                     $sku = $row["sku"];
                     $product_name = $row["product_name"];
                     $supplier = $row["supplier"];
                     $supplier_product_number = $row["supplier_product_number"];
                     $stock_factor = $row["stock_factor"];
                     $order_uom = $row["order_uom"];
                     $order_quantity = $row["order_quantity"];
                     $cost = $row["cost"];
                     $responce.=  $toReciveQuantity." ".$product_name." Recived";


                $sql1 =$conn->query("INSERT INTO `tbl_transactions`(`sku`, `product_name`, `category`, `supplier`, `supplier_product_number`, `stock_factor`, `issue_quantity`, `issue_uom`, `price`, `charge_account`, `order_quantity`, `received`, `order_uom`, `cost`, `inventory_account`) 
                VALUES ('$sku','$product_name', 'NULL','$supplier','$supplier_product_number','$stock_factor','0','NULL','0','NULL','$order_quantity','$toReciveQuantity','$order_uom','$cost','$inventory_account')");
                  echo "Error: " . $sql1 . "<br>" . mysqli_error($conn); 
                if (mysqli_query($conn, $sql1)) {
                                  echo "Error: " . $sql1 . "<br>" . mysqli_error($conn); 

               }
                 }
                  echo $responce;
                 }}
   

    //updates record to recive in all lines of a po and marks it closed 
    if($_POST['key']== 'reciveAll') {

           $responce = "";
           $poNum =$conn->real_escape_string($_POST['poNum']);
           $test = $conn->query("SELECT * FROM `tbl_purchase_orders` WHERE `id` = $poNum AND `closed_date` IS NULL");

     if($test->num_rows > 0){  
          $result = $conn->query("SELECT * FROM `tbl_po_lines` WHERE `po_id` = $poNum");
              if($result->num_rows > 0){ 
                while($row = $result->fetch_assoc()){  
                    $stockroom_id = $row["stockroom_id"];
                    $id = $row["id"];
                    $sku = $row["sku"];
                    $order_quantity = $row["order_quantity"];
                    $received = $row["received"];
                    $toReceive = $order_quantity - $received;
                    $sql1 = $conn->query("UPDATE `tbl_po_lines` SET `received`= `received` + $toReceive WHERE `id`=$id"); 
                    $sql2 = $conn->query("UPDATE `tbl_inventory` SET `on_hand`= `on_hand`+ $toReceive WHERE `stockroom_id`= $stockroom_id AND `sku` LIKE '$sku'");
                    $responce.= $toReceive.' of sku '.$sku.' received';
                 }
                 $sql = $conn->query("UPDATE `tbl_purchase_orders` SET `status`='closed',`closed_date`= NOW() WHERE `id`=$poNum;"); 
              } else{ 
                    $responce = "Not able to recive *No Products on PO*"; 
                   }
     } else {
	$responce = "PO alredy closed"; 
}

   

echo $responce;

}}
?> 