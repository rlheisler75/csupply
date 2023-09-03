<?php 
include 'dbcon.php';

if(isset($_POST['key'])){

    if ($_POST['key']== 'pick') {
      
        $sku = $conn->real_escape_string($_POST['sku']);
        $productName = $conn->real_escape_string($_POST['productName']);
        $category = $conn->real_escape_string($_POST['category']);
        $supplier = $conn->real_escape_string($_POST['supplier']);
        $supplierProductNumber = $conn->real_escape_string($_POST['supplierProductNumber']);
        $issueUOM = $conn->real_escape_string($_POST['issueUOM']);
        $onHand = $conn->real_escape_string($_POST['onHand']);
        $rowID = $conn->real_escape_string($_POST['rowID']); 
        $price = $conn->real_escape_string($_POST['price']);
        $inventoryAccount = $conn->real_escape_string($_POST['inventoryAccount']);
        $chargeAccount = $conn->real_escape_string($_POST['chargeAccount']);
        $quantity = $conn->real_escape_string($_POST['quantity']);
        $new_OnHand = $onHand-$quantity;

        $sql = $conn->query("UPDATE `tbl_inventory` SET `on_hand`='$new_OnHand' WHERE id='$rowID'");

        $sql1 = "INSERT INTO `tbl_transactions`(`sku`, `product_name`, `category`, `supplier`, `supplier_product_number`, `stock_factor`, `issue_quantity`, `issue_uom`, `price`, `charge_account`, `order_quantity`, `order_uom`, `cost`, `inventory_account`) 
        VALUES ('$sku','$productName', '$category', '$supplier','$supplierProductNumber',NULL,'$quantity', '$issueUOM','$price','$chargeAccount',NULL,NULL,NULL, '$inventoryAccount')";
       

        
 
        if (mysqli_query($conn, $sql1)) 
        {        
        $responce =  $productName.' has been picked! New amount on hand '.$new_OnHand.' '.$issueUOM;
        exit($responce);
           
        }
        else  {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }} 


//gets the product from typing sku

if ($_POST['key']== 'getRowData') {
    $rowID = $conn->real_escape_string($_POST['rowID']);
    $sql = $conn->query("SELECT * FROM tbl_inventory WHERE id='$rowID' ");
    $data = $sql->fetch_array();
    $jsonArray = array(
        'id' => $data['id'],
        'sku' => $data['sku'],
        'productName' => $data['product_name'],
        'category' => $data['category'],
        'supplier' => $data['supplier'],
        'supplierProductNumber' => $data['supplier_product_number'], 
        'stockFactor' => $data['stock_factor'],
        'issueUOM' => $data['issue_uom'],
        'onHand' => $data['on_hand'],
        'price' => $data['price']
      
      
    );
    exit(json_encode($jsonArray));

}}

if (isset($_POST['query'])) {
   
    $query = "SELECT * FROM `tbl_inventory` WHERE stockroom_id =  {$_POST['sroom']} AND `sku` LIKE '{$_POST['query']}%' OR `product_name` LIKE '{$_POST['query']}%'  LIMIT 100";
    $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
      while ($res = mysqli_fetch_array($result)) {
     
      
      
      echo '<button type="button" onclick="getScanProd('.$res['id'].')" class="list-group-item list-group-item-action">
      <div class="container">
  <div class="row">
    <div class="col-3"><div class="fw-bold">SKU</div>
      '.$res['sku'].'</div>
      <div class="col-4"><div class="fw-bold">Product</div>
       '.$res['product_name'].'
       </div>
       <div class="col-4"><div class="fw-bold">Supplier</div>
       '.$res['supplier'].'
       </div>
       <div class="col-1">
       <span class="badge bg-info text-dark" id=badge_'.$res['id'].'>'.$res['on_hand'].' '.$res['issue_uom'].'</span>
       <i class="bi bi-box-seam"></i>
       </div>
      </button>';
      
    
    

    }
  } else {
    echo "
    <div class='alert alert-danger mt-3 text-center' role='alert'>
       Product Not Found
    </div>
    ";
   
  }
}



 
 


?>