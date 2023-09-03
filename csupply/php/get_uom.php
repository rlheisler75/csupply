<?php 
include 'dbcon.php';



   $output ='';

$result = $conn->query("SELECT * FROM `tbl_uom`");

if($result->num_rows > 0){ 
    while($row = $result->fetch_assoc()){  
        $output .='<option data-toggle="tooltip" data-placement="top" value="'.$row['uom'].'" title="'.$row['description'].'">'.$row['uom'].'</option>';
       
    } 
}else{ 
    $output = '<option value="">No Data avalable</option>'; 
} 


?>

     
    