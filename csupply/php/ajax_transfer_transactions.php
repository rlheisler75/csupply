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
       
            $sql = $conn->query("SELECT `tran_id`, `sku`, `product_name`, `category`, `supplier`, `supplier_product_number`, `issue_quantity`, `issue_uom`, `price`, `charge_account`, `inventory_account`, `tran_date`,( `issue_quantity`*`price`) AS `line_total` 
            FROM `tbl_transactions` WHERE `charge_account` != `inventory_account`  AND `tran_date` BETWEEN '$sdate' AND '$edate'
             LIMIT $start ,$limit;");
     
         if ($sql->num_rows >0) {
            $response = "";
            while($data =$sql->fetch_array()) {
                $response .= '
                <tr>
                    <td id="tran_id_'.$data["tran_id"].'">'.$data["tran_id"].'</td>
                    <td id="tran_date_'.$data["tran_id"].'">'.$data["tran_date"].'</td>
                    <td id="sku_'.$data["tran_id"].'">'.$data["sku"].'</td>
                    <td id="product_name_'.$data["tran_id"].'">'.$data["product_name"].'</td>
                    <td id="category_'.$data["tran_id"].'">'.$data["category"].'</td>                                        
                    <td id="supplier_'.$data["tran_id"].'">'.$data["supplier"].'</td>
                    <td id="supplier_product_number_'.$data["tran_id"].'">'.$data["supplier_product_number"].'</td> 
                    <td id="issue_quantity_'.$data["tran_id"].'">'.$data["issue_quantity"].'</td>
                    <td id="issue_uom_'.$data["tran_id"].'">'.$data["issue_uom"].'</td>
                    <td id="price_'.$data["tran_id"].'" data-order='.$data["price"].' >$'.$data["price"].'</td>
                    <td id="line_total_'.$data["tran_id"].'">'.$data["line_total"].'</td>
                    <td id="charge_account_'.$data["tran_id"].'">'.$data["charge_account"].'</td>
                    <td id="inventory_account_'.$data["tran_id"].'">'.$data["inventory_account"].'</td>
                   
                    

                    </tr>
                ';
    
            }
            exit($response);
    
        } else
          
            exit('reachedMax');
    }

    
                
}

 
 


?>