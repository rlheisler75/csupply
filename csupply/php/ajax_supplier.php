<?php 
include 'dbcon.php';



if (isset($_POST['key'])) {

   

     //gets the data for the edit modle
    if($_POST['key']== 'getRowData') {
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql = $conn->query("SELECT * FROM tbl_supplier WHERE id='$rowID' ");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'id' => $data['id'],
            'supplier' => $data['supplier'],
            'account' => $data['account'],
            'contact_first_name' => $data['contact_first_name'],
            'contact_last_name' => $data['contact_last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'corp_phone' => $data['corp_phone'],
            'street_address' => $data['street_address'],
            'street_address_line_2' => $data['street_address_line_2'],
            'city' => $data['city'],
            'state' => $data['state'],
            'postal' => $data['postal']
          
        );
        exit(json_encode($jsonArray));

    }
    //delete record by rowID
    if($_POST['key'] == 'deleteRow'){
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql1 = $conn->query("DELETE FROM tbl_supplier WHERE id='$rowID'");
        $responce ='Supplier Was Removed!';
        exit($responce);
    }
    

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
    
        $sql1 = $conn->query("SELECT * FROM tbl_supplier LIMIT $start, $limit");
        
        if ($sql1->num_rows >0) {
            $response = "";
            while($data =$sql1->fetch_array()) {
               
                $response.= '
                <tr>
                    
                    <td id="account_'.$data["id"].'">'.$data["account"].'</td>
                    <td id="supplier_'.$data["id"].'">'.$data["supplier"].'</td>
                    <td id="contact_first_name_'.$data["id"].'">'.$data["contact_first_name"].'</td>                                        
                    <td id="contact_last_name_'.$data["id"].'">'.$data["contact_last_name"].'</td>
                    <td id="email'.$data["id"].'">'.$data["email"].'</td>                    
                    <td id="phone'.$data["id"].'">'.$data["phone"].'</td>
                    <td id="corp_phone_'.$data["id"].'">'.$data["corp_phone"].'</td>                   
                    <td id="street_address_'.$data["id"].'">'.$data["street_address"].'</td>
                    <td id="street_address_line_2_'.$data["id"].'">'.$data["street_address_line_2"].'</td>
                    <td id="city_'.$data["id"].'">'.$data["city"].'</td>
                    <td id="state'.$data["id"].'">'.$data["state"].'</td>
                    <td id="postal'.$data["id"].'">'.$data["postal"].'</td>
                   
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

    $account = $conn->real_escape_string($_POST['account']);
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $contact_first_name = $conn->real_escape_string($_POST['contact_first_name']);
    $contact_last_name = $conn->real_escape_string($_POST['contact_last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $corp_phone = $conn->real_escape_string($_POST['corp_phone']);
    $street_address = $conn->real_escape_string($_POST['street_address']);
    $street_address_line_2 = $conn->real_escape_string($_POST['street_address_line_2']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $postal = $conn->real_escape_string($_POST['postal']);
    $rowID = $conn->real_escape_string($_POST['rowID']); 
 
    //updates record 
    if($_POST['key']== 'updateRow') {
        
        $sql = $conn->query("UPDATE `tbl_supplier` SET `account`='$account',`supplier`='$supplier',`contact_first_name`='$contact_first_name',`contact_last_name`='$contact_last_name',`email`='$email',`phone`='$phone',`corp_phone`='$corp_phone',`street_address`='$street_address',`street_address_line_2`='$street_address_line_2',`city`='$city',`state`='$state',`postal`='$postal' WHERE id='$rowID'");
        
        exit('Supplier updated');
    }
    

    //adds new record 
    if($_POST['key']== 'addNew') {
         

                $sql = "INSERT INTO tbl_supplier (account, supplier, contact_first_name, contact_last_name, email,phone,corp_phone, street_address, street_address_line_2, city, state, postal)
                VALUES ('$account', '$supplier', '$contact_first_name', '$contact_last_name', '$email','$phone','$corp_phone', '$street_address', '$street_address_line_2', '$city', '$state', '$postal')";
                if (mysqli_query($conn, $sql)) {
                     exit('Supplier Added');
                                                }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
        }
                
}

 
 


?>