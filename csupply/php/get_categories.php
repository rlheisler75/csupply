<?php 
include 'dbcon.php';



   $output_categories ='';

$result = $conn->query("SELECT * FROM `tbl_categories`");

if($result->num_rows > 0){ 
    while($row = $result->fetch_assoc()){  
        $output_categories .='<option data-toggle="tooltip" data-placement="top" value="'.$row['category'].'" title="'.$row['description'].'">'.$row['category'].'</option>';
       
    } 
}else{ 
    $output_categories = '<option value="">No Data avalable</option>'; 
} 


?>

     
    