<?php 
include 'dbcon.php';

$id= $_GET['stockroom_id'];

   $stock_room_name ='';

$result = $conn->query("SELECT * FROM `tbl_stockroom` WHERE id=$id");

if($result->num_rows > 0){ 
    while($row = $result->fetch_assoc()){  
        $stock_room_name .="Inventory for ".$row['stockroom'];
        
    } 
}else{ 
    $stock_room_name = 'No Data avalable'; 
} 

$output_products ='';

$result = $conn->query("SELECT * FROM `tbl_products`");

if($result->num_rows > 0){ 
    while($row = $result->fetch_assoc()){  
        $output_products .='<option data-toggle="tooltip" data-placement="top" value="'.$row['id'].'" title="'.$row['sku'].' '.$row['product_name'].' '.$row['issue_uom'].'">'.$row['sku'].' '.$row['product_name'].'</option>';
       
    } 
}else{ 
    $output_products = '<option value="">No Data avalable</option>'; 
} 
?>

     
    