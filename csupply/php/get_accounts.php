<?php 
include 'dbcon.php';



   $output_account ='';

$result = $conn->query("SELECT * FROM `tbl_accounts`");

if($result->num_rows > 0){ 
    while($row = $result->fetch_assoc()){  
        
        $output_account .='<option data-toggle="tooltip" data-placement="top" value="'.$row['account'].'" title="Account Number '.$row['account'].'">'.$row['description'].'-'.$row['account'].'</option>';
    } 
}else{ 
    $output_account = '<option value="">No Data avalable</option>'; 
} 


?>

     
    