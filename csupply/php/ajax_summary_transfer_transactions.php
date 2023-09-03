<?php 
include 'dbcon.php';

if (isset($_POST['key'])) {

    //gets data for the table
    if($_POST['key']== 'getExistingData') {
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
        $sdate = $conn->real_escape_string($_POST['sdate']);
        $edate = $conn->real_escape_string($_POST['edate']);
        $sdate =date("Y-m-d", strtotime($sdate));
        $edate =date("Y-m-d", strtotime($edate));
       
            $sql = $conn->query("SELECT `charge_account`, `inventory_account`, SUM( `issue_quantity`*`price`) AS `line_total` FROM `tbl_transactions` WHERE `charge_account` != `inventory_account` AND `tran_date` BETWEEN '$sdate' AND '$edate' GROUP BY `charge_account`, `inventory_account` LIMIT $start ,$limit");
     
         if ($sql->num_rows >0) {
            $response = "";
            while($data =$sql->fetch_array()) {
                $response .= '
                <tr>
                   
                   
                    <td id="charge_account">'.$data["charge_account"].'</td>
                    <td id="inventory_account">'.$data["inventory_account"].'</td>
                    <td id="total">'.$data["line_total"].'</td>
                                    

                    </tr>
                ';
    
            }
            exit($response);
    
        } else
          
            exit('reachedMax');
    }

    
                
}

 
 


?>