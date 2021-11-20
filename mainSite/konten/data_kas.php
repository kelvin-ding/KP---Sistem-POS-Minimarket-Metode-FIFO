<!-- Page Heading -->
<?php
if(!isset($_GET['id'])){ 
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Cash</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_kas&id=" class="btn btn-sm btn-outline-secondary">
            <span data-feather="plus"></span>
            Deposit / Withdraw Cash
          </a>
        </div>
</div>
<?php
$kas=query("SELECT latest_amount FROM cashes WHERE is_latest='1' LIMIT 1");

?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Estimated Total Cash</h5>
    <h6 class="card-subtitle mb-2 text-muted">Rp <?php foreach ($kas as $data) : echo number_format($data['latest_amount'],2); endforeach;?></h6>
    <p class="card-text">Transaction History</p>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="deposit-tab" data-toggle="tab" href="#deposit" role="tab" aria-controls="deposit" aria-selected="false">Deposit</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="withdraw-tab" data-toggle="tab" href="#withdraw" role="tab" aria-controls="withdraw" aria-selected="false">Withdraw</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="false">All Form</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
<!-- List All History -->  
 <div class="table-responsive">
                  <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
// Penambahan & Pengurangan Uang Kas dari kebutuhan pribadi
$history=query("SELECT type, date, description, amount FROM form_cashes WHERE status='Validated' ORDER BY updated_at DESC");
foreach($history AS $h):
?>

                      <tr <?php if($h['type']=='Deposit'){ echo "class='list-group-item-success'";}else{echo "class='list-group-item-danger'";}?>>
                        <td><?php echo $h['date'];?></td>
                        <td><?php echo $h['description'];?></td>
                        <td><?php if($h['type']=='Deposit'){ echo "+";}else{echo "-";}?>Rp <?php echo number_format($h['amount'],2);?></td>
                      </tr>
<?php
endforeach;
//Penambahan Uang Kas Dari Penjualan
$history_sell=query("SELECT sales_date, invoice_no, total_amount FROM sales_invoices WHERE status='Validated' ORDER BY updated_at DESC");
foreach($history_sell AS $h):
?>
                      <tr class='list-group-item-success'>
                        <td><?php echo $h['sales_date'];?></td>
                        <td><?php echo $h['invoice_no'];?></td>
                        <td>+Rp <?php echo number_format($h['total_amount'],2);?></td>
                      </tr>
<?php
endforeach;
//Pengurangan Uang Kas Dari Pembelian
$history_purchase=query("SELECT order_date, invoice_no, total_amount FROM purchase_invoices WHERE status='Validated' ORDER BY updated_at DESC");
foreach($history_purchase AS $h):
?>
                      <tr class='list-group-item-danger'>
                        <td><?php echo $h['order_date'];?></td>
                        <td><?php echo $h['invoice_no'];?></td>
                        <td>-Rp <?php echo number_format($h['total_amount'],2);?></td>
                      </tr>
<?php
endforeach;
?>

                    </tbody>
                  </table>
                </div>

  
  </div>
  <div class="tab-pane fade" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
        <!-- List Deposit History -->
        <table id="table1" class="display table" style="width:100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
        <?php
        $history=query("SELECT date, description, amount FROM form_cashes WHERE type='Deposit' AND status='Validated' ORDER BY date DESC");
        foreach($history AS $h):
        ?>
            <tr class='list-group-item-success'>
                    <td><?php echo $h['date'];?></td>
                    <td><?php echo $h['description'];?></td>
                    <td>+Rp <?php echo number_format($h['amount'],2);?></td>
             </tr>
        <?php
        endforeach;
        //Penambahan Uang Kas Dari Penjualan
        // $history_sell=query("SELECT sales_date, invoice_no, total_amount FROM sales_invoices WHERE status='Validated' ORDER BY update_at DESC");
        foreach($history_sell AS $h):
        ?>
                      <tr class='list-group-item-success'>
                        <td><?php echo $h['sales_date'];?></td>
                        <td><?php echo $h['invoice_no'];?></td>
                        <td>+Rp <?php echo number_format($h['total_amount'],2);?></td>
                      </tr>
              <?php
              endforeach;
              ?>
            </tbody>
        </table>  
        <!-- End Of Deposit History-->
      
  </div>
        <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="withdraw-tab">
        <!-- List Withdraw History -->
        <table id="table2" class="display table" style="width:100%">
                  <thead>
                      <tr>
                          <th>Date</th>
                          <th>Description</th>
                          <th>Amount</th>
                      </tr>
                  </thead>
                  <tbody>
              <?php
              $history=query("SELECT date, description, amount FROM form_cashes WHERE type='Withdraw' AND status='Validated' ORDER BY updated_at DESC");
              foreach($history AS $h):
              ?>
                  <tr class='list-group-item-danger'>
                          <td><?php echo $h['date'];?></td>
                          <td><?php echo $h['description'];?></td>
                          <td>-Rp <?php echo number_format($h['amount'],2);?></td>
                   </tr>
              <?php
              endforeach;
              foreach($history_purchase AS $h):
                ?>
                                      <tr class='list-group-item-danger'>
                                        <td><?php echo $h['order_date'];?></td>
                                        <td><?php echo $h['invoice_no'];?></td>
                                        <td>-Rp <?php echo number_format($h['total_amount'],2);?></td>
                                      </tr>
                <?php
                endforeach;
                ?>
                  </tbody>
              </table>  
              <!-- End Of Withdraw History-->


        </div>

        <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
        <!-- List All Form -->
        <table id="table2" class="display table" style="width:100%">
                  <thead>
                      <tr>
                          <th>Date</th>
                          <th>Description</th>
                          <th>Amount</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
              <?php
              $history=query("SELECT * FROM form_cashes ORDER BY status DESC");
              foreach($history AS $h):
              ?>
                  <tr class='list-group-item-secondary'>
                          <td><?php echo $h['date'];?></td>
                          <td><?php echo $h['description'];?></td>
                          <td><?php echo $h['type'];?></td>
                          <td><?php if($h['type']=='Deposit'){ echo "+";}else{echo "-";}?>Rp <?php echo number_format($h['amount'],2);?></td>
                          <td><?php echo $h['status'];?></td>
                          <td> 
                              <a href='data_kas&id=<?php echo $h['id'];?>' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-info fa-sm text-white-50"></i></a>
                              <a href='delete_kas&id=<?php echo $h['id'];?>' onclick="return confirm('Apakah Anda Yakin?');" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash fa-sm text-white-50"></i></a>
                          </td>
                   </tr>
              <?php
              endforeach;
              ?>
                  </tbody>
              </table>  
              <!-- End Of All History-->


        </div>


    </div>
  </div>
</div>

<?php
}else if(isset($_GET['id']))
{
  if(empty($_GET['id'])){
    $date=date('Y-m-d');
?>

 <!-- Form View Create -->
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Cashes</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_kas" class="btn btn-sm btn-outline-secondary">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
              </svg>
            Back
          </a>
        </div>
      </div>
      
<?php
if (isset($_POST["submit"])) {
    if (form_cash($_POST) > 0) {
        $cash_submit=query("SELECT id FROM form_cashes ORDER BY id DESC LIMIT 1");
        foreach ($cash_submit as $get_cash_submit) :
        $id=$get_cash_submit['id'];
        endforeach;
        header('location:data_kas&id='.$id);
        $_SESSION['message']='sukses';
    }else{
         echo '<div class="alert alert-danger" role="alert">
         Submit Failed！ 
         </div>';
    }
}
?>   

<div class="row">
  <div class="col-md-8 order-md-1">
        <form class="needs-validation" novalidate action='' method='POST'>
          <div class="mb-3">
              <label for="date">Date</label>
              <input type="date" class="form-control" id="date" placeholder="" value="<?php if(isset($_POST['date'])){ echo $_POST['date'];}else{ echo $date;} ?>" name='date' required>
              <div class="invalid-feedback">
                Valid Date is required.
              </div>
            </div>
          
            <div class="mb-3">
              <label for="type">Type</label>
              <select name="type" id="typeselector" class="custom-select d-block w-100" required>
                <option value=""></option>
                <option value="Deposit">Deposit</option>
                <option value="Withdraw" id="Withdraw">Withdraw</option>
              </select>
            <div class="invalid-feedback">
              Please enter a valid Type
            </div>
          </div>

          <div class="mb-3 type" id="typeselect" style="display:none">
            <label for="for">Need For</label>
            <select name="need_for" id='need_for' class="custom-select d-block w-100">
              <option value=""></option>
              <option value="Personal Use">Personal Use</option>
              <option value="Employee Salary">Employee Salary</option>
              <option value="Utility Expense">Utility Expense</option>
            </select>
            <div class="invalid-feedback">
              Please enter a valid need for
            </div>
          </div>


          <div class="mb-3">
            <label for="amount">Amount</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
              </div>
              <input type="text" name='amount' class="form-control" id="amount" placeholder="<?php echo number_format('0',2);?>" value='<?php if(isset($_POST['amount'])){ echo $_POST['amount'];}?>' required>
              <div class="invalid-feedback" style="width: 100%;">
                Amount is required.
              </div>
            </div>
          </div>


          <div class="mb-3">
            <label for="description">Description <span class="text-muted">(Optional)</span></label>
            <textarea name="description" id="description" class="form-control" cols="30" rows="3"><?php if(isset($_POST['description'])){ echo $_POST['description'];};?></textarea>
            <div class="invalid-feedback">
              Please enter a valid description.
            </div>
          </div>



          <hr class="mb-4">
          <input name='submit' value='Submit' class="btn btn-primary btn-lg btn-block" type="submit">
        </form>
      </div>
</div>

<?php
  }else{
    $id=$_GET['id'];
      $detail=query("SELECT * FROM form_cashes WHERE id='$id'");
      foreach($detail as $state):
        $status_cash=$state['status'];
      endforeach; 
?>
<!-- Detail View  -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Cashes</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_kas" class="btn btn-sm btn-outline-secondary">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
              </svg>
            Back
          </a>
          <div class="btn-group mr-2">
          <?php if($status_cash=='Draft'){?>
            <a href="edit_kas&id=<?php echo $id;?>" class="btn btn-sm btn-outline-secondary"><span data-feather="edit"></span> Edit</a>
            <a href="validate_cash&id=<?php echo $id;?>" onclick="return confirm('Saldo Uang Kas Akan di Update Selelah Validate');"  class="btn btn-sm btn-outline-secondary"><span data-feather="check"></span> Validate</a>
            <?php }else{ ?>
              <button disabled class="btn btn-sm btn-outline-secondary"><span data-feather="edit"></span> Edit</button>
              <button disabled class="btn btn-sm btn-outline-secondary"><span data-feather="check"></span> Validated</button>
            <?php }?>
          </div>
        </div>
      </div>
      
<?php
  if(isset($_SESSION['message'])){
    if($_SESSION['message']=='sukses'){
        unset($_SESSION['message']);
        echo '<div class="alert alert-success" role="alert">
        Form has been created!
      </div>';
    }else if($_SESSION['message']=='update'){
      unset($_SESSION['message']);
      echo '<div class="alert alert-success" role="alert">
      Form has been updated!
      </div>';
    }
  }
?> 

<div class="row">
  <div class="col-md-8 order-md-1">
        <form class="needs-validation" novalidate action='' method='POST'>
        <?php foreach ($detail as $ddetail) :?>
          <div class="mb-3">
              <label for="date">Date</label>
              <input type="date" class="form-control" id="date" placeholder="" value="<?php echo $ddetail['date'];?>" disabled name='date' required>
              <div class="invalid-feedback">
                Valid Date is required.
              </div>
            </div>
          
          <div class="mb-3">
            <label for="type">Type</label>
            <select name="type" id="typeselector" class="custom-select d-block w-100" required disabled>
              <option selected value="<?php echo $ddetail['type'];?>"><?php echo $ddetail['type'];?></option>
              <option value="Deposit">Deposit</option>
              <option value="Withdraw">Withdraw</option>
            </select>
            <div class="invalid-feedback">
              Please enter a valid Type
            </div>
          </div>

          <div class="mb-3 type" id="typeselect" <?php if($ddetail['type']=='Deposit'){echo "style='display:none'";}?>>
            <label for="for">Need For</label>
            <select name="need_for" id='need_for' class="custom-select d-block w-100" disabled>
              <option value="<?php echo $ddetail['need_for'];?>"><?php echo $ddetail['need_for'];?></option>
              <option value="Personal Use">Personal Use</option>
              <option value="Employee Salary">Employee Salary</option>
              <option value="Utility Expense">Utility Expense</option>
            </select>
            <div class="invalid-feedback">
              Please enter a valid need for
            </div>
          </div>
            
          <div class="mb-3">
            <label for="amount">Amount</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
              </div>
              <input type="text" name='amount' class="form-control" id="amount" placeholder="<?php echo number_format('0',2);?>" value='<?php echo number_format($ddetail['amount'],2);?>' disabled required>
              <div class="invalid-feedback" style="width: 100%;">
                Amount is required.
              </div>
            </div>
          </div>


          <div class="mb-3">
            <label for="description">Description <span class="text-muted">(Optional)</span></label>
            <textarea disabled name="description" id="description" class="form-control" cols="30" rows="3"><?php echo $ddetail['description'];?></textarea>
            <div class="invalid-feedback">
              Please enter a valid description.
            </div>
          </div>

        <?php endforeach;?>

          <hr class="mb-4">
        </form>
      </div>
</div>
<?php
  }
}
  ?>