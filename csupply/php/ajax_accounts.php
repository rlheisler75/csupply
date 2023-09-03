<?php 
include 'dbcon.php';



if (isset($_POST['key'])) {

   

     //gets the data for the edit modle
    if($_POST['key']== 'getRowData') {
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql = $conn->query("SELECT * FROM tbl_accounts WHERE id='$rowID' ");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'id' => $data['id'],
            'account' => $data['account'],
            'description' => $data['description']
           
        );
        exit(json_encode($jsonArray));

    }
    //delete record by rowID
    if($_POST['key'] == 'deleteRow'){
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql1 = $conn->query("DELETE FROM tbl_accounts WHERE id='$rowID'");
        $responce ='Account Was Removed!';
        exit($responce);
    }
    

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
    
        $sql1 = $conn->query("SELECT * FROM tbl_accounts LIMIT $start, $limit");
        
        if ($sql1->num_rows >0) {
            $response = "";
            while($data =$sql1->fetch_array()) {
               
                $response .= '
                <tr>
                    
                    <td id="account_'.$data["id"].'">'.$data["account"].'</td>
                    <td id="description_'.$data["id"].'">'.$data["description"].'</td>                 
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
    $description = $conn->real_escape_string($_POST['description']);
    $rowID = $conn->real_escape_string($_POST['rowID']); 
 
    //updates record 
    if($_POST['key']== 'updateRow') {
        
        $sql = $conn->query("UPDATE `tbl_accounts` SET `account`='$account',`description`='$description' WHERE id='$rowID'");
        
        exit('Account Updated');
    }
    

    //adds new record 
    if($_POST['key']== 'addNew') {
        
    

                $sql = "INSERT INTO tbl_accounts (account, description)
                VALUES ('$account', '$description')";
                if (mysqli_query($conn, $sql)) {
                     exit('Account Added');
                                                }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
        }
                
}

 
 


?>