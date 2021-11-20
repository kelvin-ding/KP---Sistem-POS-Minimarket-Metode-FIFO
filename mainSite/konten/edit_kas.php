<?php
$id=$_GET['id'];
$detail=query("SELECT * FROM form_cashes WHERE id='$id'");
?>

<!-- Edit View  -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Cashes</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_kas&id=<?php echo $id;?>" class="btn btn-sm btn-outline-secondary">
            <span data-feather='x'></span>
            Cancel Edit
          </a>
        </div>
      </div>

      <?php
              if (isset($_POST["submit"])) {
                if (ubah_form_cash($_POST) > 0) {
                  header('location:data_kas&id='.$id);
                  $_SESSION['message']='update';
                }else{
                  $_SESSION['message']='failed';
                  unset($_SESSION['message']);
                    echo '<div class="alert alert-danger" role="alert">
                            Failed Edit!  
                          </div>';
               }
              }
              ?>   
<div class="row">
  <div class="col-md-8 order-md-1">
        <form class="needs-validation" novalidate action='' method='POST'>
        <?php foreach ($detail as $ddetail) :?>
        <input type='hidden' name='id' value='<?php echo $id;?>'/>
          <div class="mb-3">
              <label for="date">Date</label>
              <input type="date" class="form-control" id="date" placeholder="" value="<?php if(isset($_POST['date'])){ echo $_POST['date'];}else{ echo $ddetail['date'];};?>" name='date' required>
              <div class="invalid-feedback">
                Valid Date is required.
              </div>
            </div>
          
          <div class="mb-3">
            <label for="type">Type</label>
            <select name="type" id="typeselector" class="custom-select d-block w-100" required>
              <option value="<?php echo $ddetail['type'];?>"><?php if(isset($_POST['type'])){ echo $_POST['type'];}else{ echo $ddetail['type'];};?></option>
              <option value="Deposit">Deposit</option>
              <option value="Withdraw">Withdraw</option>
            </select>
            <div class="invalid-feedback">
              Please enter a valid Type
            </div>
          </div>

          <div class="mb-3 type" id="typeselect" <?php if($ddetail['type']=='Deposit'){echo "style='display:none'";}?>>
            <label for="for">Need For</label>
            <select name="need_for" id='need_for' class="custom-select d-block w-100">
            <option value="<?php echo $ddetail['need_for'];?>"><?php if(isset($_POST['need_for'])){ echo $_POST['need_for'];}else{ echo $ddetail['need_for'];};?></option>
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
              <input type="text" name='amount' class="form-control" id="amount" placeholder="<?php echo number_format('0',2);?>" value='<?php if(isset($_POST['amount'])){ echo $_POST['amount'];}else{ echo number_format($ddetail['amount'],2);};?>' required>
              <div class="invalid-feedback" style="width: 100%;">
                Amount is required.
              </div>
            </div>
          </div>


          <div class="mb-3">
            <label for="description">Description <span class="text-muted">(Optional)</span></label>
            <textarea name="description" id="description" class="form-control" cols="30" rows="3"><?php if(isset($_POST['description'])){ echo $_POST['description'];}else{ echo $ddetail['description'];};?></textarea>
            <div class="invalid-feedback">
              Please enter a valid description.
            </div>
          </div>

        <?php endforeach;?>
        <input name='submit' value='Edit' class="btn btn-primary btn-lg btn-block" type="submit">
          <hr class="mb-4">
        </form>
      </div>
</div>