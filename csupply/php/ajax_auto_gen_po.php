<?php 
include 'dbcon.php';

// auto adds lines to po
    if($_POST['key']== 'autogen'){

        $poID = $_POST['poID'];
        $stockroomID = $_POST['stockroom_id'];
        $supplierID = $_POST['supplier_id'];   
        $inventoryAccount = $_POST['inventory_account'];   

                    
            $sql="INSERT INTO tbl_po_lines (`po_id`, `stockroom_id`, `product_id`, `sku`, `product_name`, `supplier_id`, `supplier`, `supplier_product_number`, `stock_factor`, `order_uom`, `order_quantity`, `cost`,`inventory_account`)
        SELECT $poID, stockroom_id,  id,sku, product_name, supplier_id, supplier, supplier_product_number, stock_factor, order_uom, ROUND(((par_level- on_hand )/stock_factor),0)  AS order_quantity  ,cost, '$inventoryAccount' AS inventory_account
        FROM tbl_inventory
        WHERE  ROUND(((par_level- on_hand )/stock_factor),0) >0 AND stockroom_id= $stockroomID AND supplier_id= $supplierID AND NOT EXISTS (SELECT `product_id` FROM `tbl_po_lines` WHERE product_id = tbl_inventory.id)";

        if (mysqli_query($conn, $sql)) {
            exit('PO Populated');
                                       }
   else {
       echo "Error: " . $sql . "<br>" . mysqli_error($conn);
     }
}
      
?>