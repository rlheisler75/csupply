<?php 
include 'dbcon.php';



if (isset($_POST['key'])) {

   

     //gets the data for the edit modle
    if($_POST['key']== 'getRowData') {
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql = $conn->query("SELECT * FROM tbl_purchase_orders WHERE id='$rowID' ");
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
        $sql1 = $conn->query("DELETE FROM tbl_purchase_orders WHERE id='$rowID'");
        $sql2 = $conn->query("DELETE FROM tbl_po_lines WHERE po_id='$rowID'");
        $responce ='PO Was Removed!';
        exit($responce);
    }
    

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
    
        $sql1 = $conn->query("SELECT * FROM tbl_purchase_orders LIMIT $start, $limit");
        
        if ($sql1->num_rows >0) {
            $response = "";
            while($data =$sql1->fetch_array()) {
               
                $response .= '
                <tr>
                    <td id="po_number_'.$data["id"].'">'.$data["id"].'</td>
                    <td id="stockroom_'.$data["id"].'">'.$data["stockroom"].'</td>
                    <td id="supplier_'.$data["id"].'">'.$data["supplier"].'</td>  
                    <td id="open_date'.$data["id"].'">'.$data["open_date"].'</td> 
                    <td id="closed_date_'.$data["id"].'">'.$data["closed_date"].'</td> 
                    <td id="status_'.$data["id"].'">'.$data["status"].'</td>                
                    <td> <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <input type="button" onclick="reciveAndClose('.$data["id"].')" value="Recive ALL and Close PO" class="btn btn-outline-secondary">
                       
                       <!-- <input type="button" onclick="manageInventory('.$data["id"].')" value="Manage Inventory" class="btn btn-outline-success">  -->
                       <input type="button" onclick="deleteRow('.$data["id"].')" value="Delete" class="btn btn-outline-danger"> 
                       <a href="polines.php?po_id='.$data["id"].'" role="button"  class="btn btn-outline-success">PO Line Items</a>
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
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $stockroomID = $conn->real_escape_string($_POST['stockroomID']);
    $supplierID = $conn->real_escape_string($_POST['supplierID']);
    $rowID = $conn->real_escape_string($_POST['rowID']); 
    

 
    //updates record 
    if($_POST['key']== 'updateRow') {
        
        $sql = $conn->query("UPDATE `tbl_purchase_orders` SET `stockroom`='$stockroom',`description`='$description' WHERE id='$rowID'");
        
        exit('PO Updated');
    }
    

    //adds new record 
    if($_POST['key']== 'addNew') {
        
        $status="Open";

                $sql = "INSERT INTO tbl_purchase_orders (`supplier_id`, `supplier`, `stockroom_id`, `stockroom`, `status` )
                VALUES ('$supplierID', '$supplier', '$stockroomID', '$stockroom', '$status')";
                if (mysqli_query($conn, $sql)) {
                     exit('PO Created. You can now add products!');
                                                }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
        }
                
}

 
 


?>