<?php 
include 'dbcon.php';

$id= $_GET['po_id'];

   $po_name ='';
   $po_tab ='';
   $supplerID ='';
   $stockroom ='';
$result = $conn->query("SELECT * FROM `tbl_purchase_orders` WHERE id=$id");

if($result->num_rows > 0){ 
    while($row = $result->fetch_assoc()){  
        $po_name .="PO# ".$row['id']."<br> Stockroom ".$row['stockroom']." <br> Supplier ".$row['supplier'];
        $po_tab .="PO# ".$row['id']." ".$row['stockroom']." ".$row['supplier'];
        $supplerID =$row['supplier_id'];
        $stockroomID = $row['stockroom_id'];
    } 
}else{ 
    $po_name = 'No Data avalable'; 
} 
 
    
$output_products ='';

$result = $conn->query("SELECT * FROM `tbl_inventory` WHERE supplier_id = $supplerID AND stockroom_id = $stockroomID ");

if($result->num_rows > 0){ 
    while($row = $result->fetch_assoc()){  
        $output_products .='<option data-toggle="tooltip" data-placement="top" value="'.$row['id'].'" title="'.$row['sku'].' '.$row['product_name'].' '.$row['issue_uom'].'">'.$row['sku'].' '.$row['product_name'].'</option>';
       
    } 
}else{ 
    $output_products = '<option value="">No Data avalable</option>'; 
} 



?>

     
    