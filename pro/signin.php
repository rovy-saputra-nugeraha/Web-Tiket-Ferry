<?php
session_start();
require_once '../conn.php';
$class = "signin";

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

?>
<?php
$cur_page = 'signup';
include 'includes/inc-header.php';
include 'includes/inc-nav.php';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!isset($email, $password)) {
        ?>
        <script>
            alert("Pastikan Anda mengisi formulir dengan benar.");
        </script>
        <?php
    } else {

        // Check for login
        $password = md5($password);
        $check = $conn->prepare("SELECT * FROM passenger WHERE email = ? AND password = ?");
        $check->bind_param("ss", $email, $password);
        if (!$check->execute()) die("Terdapat Kesalahan Dalam Formulir");
        $res = $check->get_result();
        $no_rows = $res->num_rows;
        if ($no_rows ==  1) {
            $row = $res->fetch_assoc();
            $id = $row['id'];
            $status = $row['status'];
            if ($status != 1) {
                ?>
                <script>
                    alert("Akun Dinonaktifkan!\nHubungi Administrator Sistem!");
                    window.location = "signin.php";
                </script>
                <?php
                exit;
            }
            session_regenerate_id(true);
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;

            ?>
            <script>
                alert("Akses Terima!");
                window.location = "individual.php";
            </script>
            <?php
            exit;
        } else { ?>
            <script>
                alert("Akses Di Tolak");
            </script>
            <?php
            $_SESSION['login_attempts']++;
        }
    }
}

//Penerapan Brute Force
if ($_SESSION['login_attempts'] >= 3) {
    session_unset();
    session_destroy();
    ?>
    <script>
        alert("Terlalu banyak percobaan login. Silakan coba lagi nanti.");
        window.location = "../index.php";
    </script>
    <?php
    exit;
}
?>
<div class="signup-page">
    <div class="form">
        <h2>Log In</h2>
        <br>
        <form class="login-form" method="post" role="form" id="signup-form" autocomplete="off">
            <!-- json response will be here -->
            <div id="errorDiv"></div>
            <!-- json response will be here -->

            <div class="col-md-12">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required name="email" placeholder="Masukkan Email">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan Password">
                    <span class="help-block" id="error"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="btn-signup">
                        SIGN IN
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
<script src="assets/js/sweetalert2.js"></script>
</body>
</html>
