<?php 
include 'dbcon.php';



   $output_supplier ='';
   $output_supplier_account='';

$result = $conn->query("SELECT id, account, supplier FROM `tbl_supplier`");

if($result->num_rows > 0){ 
    while($row = $result->fetch_assoc()){  
        $output_supplier .='<option data-toggle="tooltip" data-placement="top" value="'.$row['id'].'" title="Account Number '.$row['account'].'">'.$row['supplier'].'</option>';
       $output_supplier_account .='<option data-toggle="tooltip" data-placement="top" value="'.$row['id'].'" title="Account Number '.$row['account'].'">'.$row['supplier'].'-'.$row['id'].'</option>';
    } 
}else{ 
    $output_supplier = '<option value="">No Data avalable</option>'; 
    $output_supplier_account = '<option value="">No Data avalable</option>'; 
} 


?>

     
    