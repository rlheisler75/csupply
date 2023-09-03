<!doctype html>
<html lang="en">
<head>
<?php include 'php/get_uom.php';?>
    <?php include 'php/get_categories.php';?>
    <?php include 'php/get_po_data.php';?>
     <?php include 'php/get_accounts.php';?>
  <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo $po_tab;?></title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/2a71cca5db.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/r-2.2.9/datatables.min.css"/>
   

 
   
  </head>
   
    

  
      <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Central Supply</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
         <div class="input-group">
             <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
             <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
         </div>
     </form> -->
     <!-- Navbar-->
            <!--  <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="#!">Logout</a></li>
            </ul>
        </li>
    </ul> -->
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="scanning.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-barcode"></i></div>
                                Scan
                            </a>
                            <a class="nav-link" href="products.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-parachute-box"></i></div>
                                Products
                            </a>
                            <a class="nav-link" href="stockroom.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                Stockroom
                            </a>
                            <a class="nav-link" href="supplier.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-shop"></i></div>
                                Supplier
                            </a>
                            <a class="nav-link active" href="purchaseorders.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-money-check-dollar"></i></div>
                                Purchase orders
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReports" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Reports
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseReports" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="alltransation.php">All Transations</a>
                                    <a class="nav-link" href="transfer-transations.php">Transfer Transations</a>
                                    <a class="nav-link" href="summary-transfer-transations.php">Transfer Summary</a>

                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-gears"></i></div>
                                Settings
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="accounts.php">Accounts</a>
                                    <a class="nav-link" href="categories.php">Categories</a>
                                    <a class="nav-link" href="uom.php">UOM</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!--<div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>-->
                </nav>
            </div>
            <div id="layoutSidenav_content">
 <!-- Modal -->  
<div class="container" style="margin-top: 30px;">
<h1> <?php echo $po_name;?></h1>
<div id="tableManager" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
       
        <h2 id="modalTitle" class="modal-title">PO</h2>
    </div>
    

    
    <div class="modal-body">
        <input type="hidden" id="editRowID" value="0">
        <input type="hidden" id="po_id" value="<?php echo $id;?>">
        <input type="hidden" id="stockroom_id" value="<?php echo $stockroomID;?>">
        <input type="hidden" id="supplier" value="0">
        <input type="hidden" id="supplierID" value="<?php echo $supplerID;?>">
        <input type="hidden" id="orderUOM" value="">
         <input type="hidden" id="account" value="">
        <div id="productHide">
        <label for="selectProduct">Select a Product<span class="text-danger">*</span></label>
        <select class="form-select" id="selectProducts" onchange="getProduct(this)" aria-label="Select a Product">
        <option  value="" disabled selected>Select a Product</option>
        <?php echo $output_products;?>
        </select>
        <br>
        </div>
         <label for="select_Account" class="form-label">Inventory Account</label>
            <select class="form-select" id="select_Account" onchange="getAccountValue(this)" aria-describedby="Account select">
                <option  value="" disabled selected>Select Account</option>
                <?php echo $output_account;?>  
            </select>
   <br>
        <label for="sku">SKU</label>
        <input type="text" class="form-control" id="sku" placeholder="Product SKU" readonly ><br>

        <label for="productName">Product Name</label>
        <input type="text" class="form-control" id="productName" placeholder="Product Name" readonly ><br>
        
        <label for="supplierProductNumber">Supplier Product Number</label>
        <input type="text" class="form-control" id="supplierProductNumber" placeholder="Supplier Product Number" readonly><br>
        
        <label for="stockFactor">Stock Factor</label>
        <input type="number" min="1" class="form-control" id="stockFactor" placeholder="Enter stock factor number" readonly><br>
      
        <label for="cost">Cost</label>
            <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
            <div class="input-group-text">$</div>
            </div>
            <input type="number" class="form-control" id="cost" aria-label="Cost" readonly >
            </div>
        <label for="orderQuantity">Order Quantity<span class="text-danger">*</span></label>
        <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text " id="orderUnits">?</div>
        </div>
        <input type="number" min="0" class="form-control" id="orderQuantity" aria-label="Order Quantity" required >
        </div>
       
        

    </div>

    <div class="modal-footer">
        <input type="button" id="manageBtn" onclick="manageData('addNew')" value="Add Product" class="btn btn-success">
    </div>

</div>
</div>

</div>
<!--End Modal-->
<!-- Modal -->
<div class="modal fade" id="reciveModal" tabindex="-1" role="dialog" aria-labelledby="recive modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <input type="hidden" id="editReciveRowID" value="0">
       <input type="hidden" id="editProductId" value="0">
       
        <h5 class="modal-title" id="exampleModalLabel"><span id="recivedProduct"></span></h5>
       <span id="headerSKU" class="text-muted h3"></span>
      </div>
      <div class="modal-body">
      
           
      <h4>Ordered <span id="recivedOrderQuantity"></span> <span class="reciveModelUOM"></h4>
      <h4>Recived <span id="recivedIn"></span> <span class="reciveModelUOM"></h4>
      <hr>
      <h4>Enter Amount to Recive In</h4>
      <div class="input-group md-3">
       <input class="form-control form-control-lg" type="number" id="toReciveQuantity">
       <span class=" input-group-text reciveModelUOM"></span>
       </div>
      </div>
      <div class="modal-footer">

        <button type="button" onclick="reciveProduct()" class="btn btn-primary">Recive Product</button>
      </div>
    </div>
  </div>
</div>
<!--End Modal-->
<!-- Modal -->
<div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="Select Account" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <input type="hidden" id="autoAccount" value="">
      
       
        <h5 class="modal-title" id="autogenSelectAccountTitle"><span>Select Account</span></h5>
      </div>
      <div class="modal-body">
       <label for="select_account" class="form-label">Inventory Account</label>
            <select class="form-select" id="select_account" onchange="getAccountName(this)" aria-describedby="Account select">
                <option  value="" disabled selected>Select Account</option>
                <?php echo $output_account;?>  
            </select>
   <br>
   <h1 id="selectedAutoAccount"></h1> 
           
      
      </div>
      <div class="modal-footer">

        <button type="button" onclick="generatePO('<?php echo $id;?>','<?php echo $stockroomID;?>','<?php echo $supplerID;?>')" class="btn btn-primary">Generate Lines</button>
      </div>
    </div>
  </div>
</div>
<!--End Modal-->
<div style="float: right;" class="btn-group" role="group" aria-label="Auto Generate and Add Manuly button group">
<input style="float: right;" type="button" id="generatePO" onclick="accountModal()" class="btn btn-primary" value="Auto Generate Line Items">
    <input style="float: right;" type="button" id="addNew" class="btn btn-info" value="Add Line Item">
</div>
    <br>
    <table id="productsTable" class="table table-hover table-border">
        <thead>
            <tr>
               
                <td>SKU</td>
                <td>Product</td>
                <td>Supplier</td>
                <td>Item Number</td>                
                <td>Stock Factor</td>
                <td>Order UOM</td>
                <td>Cost</td>
                <td>Inventory Account</td>
                <td>Order Quantity</td>
                <td>Quantity Recived</td>         
                <td class="no-sort">Actions</td>
                
            </tr>

        </thead>
        <tbody></tbody>




    </table>
</div>
</main>
     <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Maranatha 2022</div>
                            <!--<div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>-->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/r-2.2.9/datatables.min.js"></script>

    <script src="../js/polines_script.js"></script>
 
  </body>
</html>