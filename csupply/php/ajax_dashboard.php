<?php
include 'dbcon.php';


if (isset($_POST['key'])) {

//get curent month PO totals
    if($_POST['key'] == 'montlyPoVal'){
      
     $sql=$conn->query("SELECT SUM(order_quantity*cost) AS total_cost FROM tbl_po_lines
        LEFT JOIN tbl_purchase_orders
        ON tbl_po_lines.po_id = tbl_purchase_orders.id
        WHERE MONTH(tbl_purchase_orders.open_date) = MONTH(now()) AND YEAR(tbl_purchase_orders.open_date) = YEAR(now())");
     
        if ($sql->num_rows >0) {                     
            $response ="";
                while($data =$sql->fetch_array()) {
                $response .= $data["total_cost"];
                }

        $output=number_format((float)$response, 2, '.', '');
        exit($output);
        }    
    else {
	 $response = 0;
     }
}

//get curent month PO totals
    if($_POST['key'] == 'YTDPO'){
      
     $sql=$conn->query("SELECT SUM(order_quantity*cost) AS total_cost FROM tbl_po_lines
        LEFT JOIN tbl_purchase_orders
        ON tbl_po_lines.po_id = tbl_purchase_orders.id
        WHERE YEAR(tbl_purchase_orders.open_date) = YEAR(now())");
     
        if ($sql->num_rows >0) {                     
            $response ="";
                while($data =$sql->fetch_array()) {
                $response .= $data["total_cost"];
                }

        $output=number_format((float)$response, 2, '.', '');
        exit($output);
        }    
    else {
	 $response = 0;
     }
}

//get monthly PO totals
    if($_POST['key'] == 'anualPoVal'){
      
   $sql=$conn->query("SELECT date_format(tbl_purchase_orders.open_date, '%M') as m, SUM(order_quantity*cost) AS monthly_total_cost FROM tbl_po_lines
        LEFT JOIN tbl_purchase_orders
        ON tbl_po_lines.po_id = tbl_purchase_orders.id 
        WHERE YEAR(tbl_purchase_orders.open_date) = YEAR(now()) 
        GROUP BY year(tbl_purchase_orders.open_date),month(tbl_purchase_orders.open_date)");
  
   
        
    $month = array();
    $poValue =array();
    

        while($data =$sql->fetch_array()) {
            $month[] = $data['m'];
            $poValue[] = number_format((float)$data['monthly_total_cost'], 2, '.', '');
        };     
      
      

        $jsonArray = array(
         'month' => $month,
         'poValue' =>$poValue
        );
      echo json_encode($jsonArray);exit;
         
}

//get last years monthly PO totals
    if($_POST['key'] == 'anualPoValPY'){
      
   $sql=$conn->query("SELECT date_format(tbl_purchase_orders.open_date, '%M') as m, SUM(order_quantity*cost) AS monthly_total_cost FROM tbl_po_lines
        LEFT JOIN tbl_purchase_orders
        ON tbl_po_lines.po_id = tbl_purchase_orders.id 
        WHERE YEAR(tbl_purchase_orders.open_date) = YEAR(now())-1 
        GROUP BY year(tbl_purchase_orders.open_date),month(tbl_purchase_orders.open_date)");
  
   
        
    $monthPY = array();
    $poValuePY =array();
    

        while($data =$sql->fetch_array()) {
            $monthPY[] = $data['m'];
            $poValuePY[] = number_format((float)$data['monthly_total_cost'], 2, '.', '');
        };     
      
      

        $jsonArray = array(
         'monthPY' => $monthPY,
         'poValuePY' =>$poValuePY
        );
      echo json_encode($jsonArray);exit;
         
}

//get stock out count
    if($_POST['key']=='stockouts'){
         $sql=$conn->query("SELECT COUNT(*) AS stockouts FROM `tbl_inventory` WHERE on_hand = 0;");
          $response ="";
                while($data =$sql->fetch_array()) {
                $response .= $data["stockouts"];
                }
                exit($response);

    }
//get over stocked count 
    if($_POST['key']=='overstocked'){
         $sql=$conn->query("SELECT COUNT(*) AS overstocked FROM `tbl_inventory` WHERE on_hand > par_level;");
          $response ="";
                while($data =$sql->fetch_array()) {
                $response .= $data["overstocked"];
                }
                exit($response);

    }

//get over stocked listing 
    if($_POST['key']=='overstockedList'){

        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
         $sql=$conn->query("SELECT tbl_inventory.id, tbl_inventory.sku, tbl_inventory.product_name,tbl_inventory.par_level,tbl_inventory.on_hand, tbl_stockroom.stockroom as stockroom
                            FROM tbl_inventory
                            INNER JOIN tbl_stockroom
                            ON tbl_inventory.stockroom_id=tbl_stockroom.id
                            WHERE on_hand >par_level LIMIT $start, $limit");
       
         if ($sql->num_rows >0) {
            $response = "";
            while($data =$sql->fetch_array()) {
               
                $response .= '
                <tr>
                    
                    <td id="sku_'.$data["id"].'">'.$data["sku"].'</td>
                    <td id="product_name_'.$data["id"].'">'.$data["product_name"].'</td>
                    <td id="stockroom_'.$data["id"].'">'.$data["stockroom"].'</td>
                    <td data-order='.$data["par_level"].' id="par_level_'.$data["id"].'">'.$data["par_level"].'</td>
                    <td data-order='.$data["on_hand"].' id="on_hand_'.$data["id"].'">'.$data["on_hand"].'</td>                   
                    
                    </tr>
                ';
    
            }
            exit($response);
    
        } else
            exit('reachedMax');
    }


//get stockout listing 
    if($_POST['key']=='stockoutList'){

        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
         $sql=$conn->query("SELECT tbl_inventory.id, tbl_inventory.sku, tbl_inventory.product_name,tbl_inventory.par_level,tbl_inventory.on_hand, tbl_stockroom.stockroom as stockroom
FROM tbl_inventory
INNER JOIN tbl_stockroom
ON tbl_inventory.stockroom_id=tbl_stockroom.id
WHERE on_hand <1 LIMIT $start, $limit");
       
         if ($sql->num_rows >0) {
            $response = "";
            while($data =$sql->fetch_array()) {
               
                $response .= '
                <tr>
                    
                    <td id="sku_'.$data["id"].'">'.$data["sku"].'</td>
                    <td id="product_name_'.$data["id"].'">'.$data["product_name"].'</td>
                    <td id="stockroom_'.$data["id"].'">'.$data["stockroom"].'</td>
                    <td data-order='.$data["par_level"].' id="par_level_'.$data["id"].'">'.$data["par_level"].'</td>
                    <td data-order='.$data["on_hand"].' id="on_hand_'.$data["id"].'">'.$data["on_hand"].'</td>                   
                    
                    </tr>
                ';
    
            }
            exit($response);
    
        } else
            exit('reachedMax');
    }

//get Curent Month PO's listing 
    if($_POST['key']=='curntMonthPoValuestList'){

        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
         $sql=$conn->query("SELECT tbl_purchase_orders.id, tbl_purchase_orders.supplier,   tbl_purchase_orders.open_date, (order_quantity*cost) AS poTotal FROM tbl_po_lines
        LEFT JOIN tbl_purchase_orders
        ON tbl_po_lines.po_id = tbl_purchase_orders.id 
        WHERE YEAR(tbl_purchase_orders.open_date) = YEAR(now()) AND  MONTH(tbl_purchase_orders.open_date) = MONTH(now())
        GROUP BY year(tbl_purchase_orders.open_date),month(tbl_purchase_orders.open_date) LIMIT $start, $limit");
       
         if ($sql->num_rows >0) {
            $response = "";
            while($data =$sql->fetch_array()) {
               
                $response .= '
                <tr>
                    
                    <td id="po_'.$data["id"].'">'.$data["id"].'</td>
                    <td id="supplier_'.$data["id"].'">'.$data["supplier"].'</td>
                    <td id="open_date_'.$data["id"].'">'.$data["open_date"].'</td>
                    <td data-order='.$data["poTotal"].' id="poTotal_'.$data["id"].'">'.$data["poTotal"].'</td>              
                    
                    </tr>
                ';
    
            }
            exit($response);
    
        } else
            exit('reachedMax');
    }

    //get YTD PO's listing 
    if($_POST['key']=='YTDPoValuestList'){

        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);
         $sql=$conn->query("SELECT tbl_purchase_orders.id, tbl_purchase_orders.supplier,   tbl_purchase_orders.open_date, (order_quantity*cost) AS poTotal FROM tbl_po_lines
        LEFT JOIN tbl_purchase_orders
        ON tbl_po_lines.po_id = tbl_purchase_orders.id 
        WHERE YEAR(tbl_purchase_orders.open_date) = YEAR(now())
        GROUP BY year(tbl_purchase_orders.open_date),month(tbl_purchase_orders.open_date) LIMIT $start, $limit");
       
         if ($sql->num_rows >0) {
            $response = "";
            while($data =$sql->fetch_array()) {
               
                $response .= '
                <tr>
                    
                    <td id="po_'.$data["id"].'">'.$data["id"].'</td>
                    <td id="supplier_'.$data["id"].'">'.$data["supplier"].'</td>
                    <td id="open_date_'.$data["id"].'">'.$data["open_date"].'</td>
                    <td data-order='.$data["poTotal"].' id="poTotal_'.$data["id"].'">'.$data["poTotal"].'</td>              
                    
                    </tr>
                ';
    
            }
            exit($response);
    
        } else
            exit('reachedMax');
    }


}
?>