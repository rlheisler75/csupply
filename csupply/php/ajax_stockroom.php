<?php 
include 'dbcon.php';



if (isset($_POST['key'])) {

   

     //gets the data for the edit modle
    if($_POST['key']== 'getRowData') {
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql = $conn->query("SELECT * FROM tbl_stockroom WHERE id='$rowID' ");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'id' => $data['id'],
            'stockroom' => $data['stockroom'],
            'description' => $data['description']
           
        );
        exit(json_encode($jsonArray));

    }
    //delete record by rowID
    if($_POST['key'] == 'deleteRow'){
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql1 = $conn->query("DELETE FROM tbl_stockroom WHERE id='$rowID'");
        $responce ='Stockroom Was Removed!';
        exit($responce);
    }
    

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
    
        $sql1 = $conn->query("SELECT * FROM tbl_stockroom LIMIT $start, $limit");
        
        if ($sql1->num_rows >0) {
            $response = "";
            while($data =$sql1->fetch_array()) {
               
                $response .= '
                <tr>
                    
                    <td id="stockroom_'.$data["id"].'">'.$data["stockroom"].'</td>
                    <td id="description_'.$data["id"].'">'.$data["description"].'</td>                 
                    <td> <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <input type="button" onclick="edit('.$data["id"].')" value="Edit" class="btn btn-outline-secondary">
                        <input type="button" onclick="deleteRow('.$data["id"].')" value="Delete" class="btn btn-outline-danger"> 
                       <!-- <input type="button" onclick="manageInventory('.$data["id"].')" value="Manage Inventory" class="btn btn-outline-success">  -->
                        <a href="inventory.php?stockroom_id='.$data["id"].'" role="button"  class="btn btn-outline-success">Manage inventory</a>
                        </form                  
                        </div
                    </td>
                    </tr>
                ';
    
            }
            exit($response);
    
        } else
            exit('reachedMax');
    }

    $stockroom = $conn->real_escape_string($_POST['stockroom']);
    $description = $conn->real_escape_string($_POST['description']);
    $rowID = $conn->real_escape_string($_POST['rowID']); 
 
    //updates record 
    if($_POST['key']== 'updateRow') {
        
        $sql = $conn->query("UPDATE `tbl_stockroom` SET `stockroom`='$stockroom',`description`='$description' WHERE id='$rowID'");
        
        exit('Stockroom Updated');
    }
    

    //adds new record 
    if($_POST['key']== 'addNew') {
        
    

                $sql = "INSERT INTO tbl_stockroom (stockroom, description)
                VALUES ('$stockroom', '$description')";
                if (mysqli_query($conn, $sql)) {
                     exit('Stockroom Added');
                                                }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
        }
                
}

 
 


?>