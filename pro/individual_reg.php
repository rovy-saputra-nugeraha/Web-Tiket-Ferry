<?php
session_start();
require_once '../conn.php';
require_once '../constants.php';
$class = "reg";
?>
<?php
$cur_page = 'signup';
include 'includes/inc-header.php';
include 'includes/inc-nav.php';
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $file = 'file';
    $address = $_POST['address'];
    $cpassword = $_POST['cpassword'];
    $password = $_POST['password'];
    if (!isset($name, $address, $phone, $email, $password, $cpassword) || ($password != $cpassword)) { ?>
<script>
alert("Pastikan Anda mengisi formulir dengan benar.");
</script>
<?php
    } else {
        //Check if email exists
        $check_email = $conn->prepare("SELECT * FROM passenger WHERE email = ? OR phone = ?");
        $check_email->bind_param("ss", $email, $phone);
        $check_email->execute();
        $res = $check_email->store_result();
        $res = $check_email->num_rows();
        if ($res) {
        ?>
<script>
alert("Email sudah ada!");
</script>
<?php

        } elseif ($cpassword != $password) { ?>
<script>
alert("Kata sandi tidak cocok!");
</script>
<?php
        } else {
            //Insert
            $password = md5($password);
            $can = 1;
            $loc = uploadFile('file');
            if ($loc == -1) {
                echo "<script>alert('Kami tidak dapat menyelesaikan pendaftaran Anda, coba lagi nanti!')</script>";
                exit;
            }
            $stmt = $conn->prepare("INSERT INTO passenger (name, email, password, phone, address, loc) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $name, $email, $password, $phone, $address, $loc);
            if ($stmt->execute()) {
            ?>
<script>
alert("Selamat.\nAnda sekarang terdaftar.");
window.location = 'signin.php';
</script>
<?php
            } else {
            ?>
<script>
alert("Kami tidak dapat mendaftarkan Anda!.");
</script>
<?php
            }
        }
    }
}
?>
<div class="signup-page">
    <div class="form">
        <h1>Register</h1>
        <br>
        <p class="alert alert-info">
            <marquee behavior="" scrollamount="2" direction="">Anda perlu membuat akun untuk bergabung bersama SD Negeri 013 Tanjungpinang Barat
            </marquee>
        </p>
        <form class="login-form" method="post" role="form" enctype="multipart/form-data" id="signup-form"
            autocomplete="off">
            <!-- json response will be here -->
            <div id="errorDiv"></div>
            <!-- json response will be here -->
            <div class="col-md-12">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" required minlength="10" name="name" placeholder="Masukkan Nama">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>No Hp</label>
                    <input type="text" minlength="11" pattern="[0-9]{11}" required name="phone" placeholder="No Hp">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required name="email" placeholder="Masukkan Email">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Pilih Gambar</label>
                    <input type="file" name='file' required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Alamat</label>
                    <input type='text' name="address" class="form-group" placeholder="Masukkan Alamat" required>
                    </select>
                    <span class="help-block" id="error"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan Password">
                    <span class="help-block" id="error"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="cpassword" id="cpassword" placeholder="Konfirmasi Password">
                    <span class="help-block" id="error"></span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="btn-signup">
                        CREATE ACCOUNT
                    </button>
                </div>
            </div>
            <p class="message">
                <a href="#">.</a><br>
            </p>
        </form>
    </div>
</div>
</div>
<script src="assets/js/jquery-1.12.4-jquery.min.js"></script>

</body>

</html>