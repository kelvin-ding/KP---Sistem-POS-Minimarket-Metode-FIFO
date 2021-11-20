<?php
$profile=mysqli_query($db, "SELECT * FROM user WHERE id_user='$id_user'");
$data=mysqli_fetch_array($profile);

if(isset($_POST['submit'])){
  $pw=md5($_POST['pw']);
  $pw1=md5($_POST['pw1']);
  $pw2=md5($_POST['pw2']);
  $id_user=$_POST['id_user'];

  $query=mysqli_query($db,"SELECT password FROM user WHERE id_user='$id_user'");
  $cek=mysqli_fetch_array($query);
  $password=$cek['password'];
  if($pw==$password){
    if($pw1==$pw2){
    $update=mysqli_query($db, "UPDATE user SET password='$pw1' WHERE id_user='$id_user'");
      if($update){
        echo "<script>alert('Update Berhasil'); document.location='profile';</script>";
      }else{
        echo "<script>alert('Update Gagal'); document.location='profile';</script>";
      }
    }else{
      echo "<script>alert('Confirmation Password Dont Match'); document.location='profile';</script>";
    }
  }else{
    echo "<script>alert('Password Salah'); document.location='profile';</script>";
  }
} 
?>
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">PROFILE</h1>
                  </div>
                    <div class="form-group">
                      Firstname  : <?php echo $data['firstname'];?> 
                    </div>
                    <div class="form-group">
                      Lastname   : <?php echo $data['lastname'];?>
                    </div>
                    <div class="form-group">
                      Username   : <?php echo $data['username'];?>
                    </div>
                    <form method="post" action="">
                    <div class="form-group">
                      <input type="password" required="required" class="form-control" name="pw" placeholder="Current Password">
                    </div>
                    <div class="form-group">
                      <input type="password" required="required" class="form-control" name="pw1" placeholder="New Password">
                    </div>
                    <div class="form-group">
                      <input type="password" required="required" class="form-control" name="pw2" placeholder="Confirmation Password">
                      <input type="hidden" required="required" class="form-control" name="id_user" value="<?php echo $id_user;?>">
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" name="submit" value="Update Password">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>