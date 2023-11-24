<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>
<?php


?>
<!-- Content Header (Page header) -->
<!-- <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Feedback</h1>
            </div>

        </div>
    </div>
</section> -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Info:</h5>
                    Kami selalu ingin mendengar keterangan Anda!
                    Dibalas dalam 24 jam.
                </div>



                <div class="card">
                    <div class="card-header alert-success">
                        <h5 class="card-title"><b>Daftar Komentar</b></h5>
                        <div class='float-right'>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">
                                Kirim Pesan Baru
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id='example1'>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Komentar Kamu</th>
                                    <th>Tanggapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 0;
                                $query = getFeedbacks();
                                while ($row = $query->fetch_assoc()) {
                                    $sn++;
                                    echo "<tr>
                                    <td>$sn</td>
                                    <td>" . $row['message'] . "</td>
                                    <td>" . ($row['response'] == NULL ? '-- Belum Ada Respon --' : $row['response']) . "</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>


                    </div>

                    <br />
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<div class="modal fade" id="add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" align="center">
            <div class="modal-header">
                <h4 class="modal-title">Kirim Pesan Baru </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                Ketik Pesan : <textarea name="message" required minlength="10" id="" cols="30"
                                    rows="10" class="form-control"></textarea>
                            </div>

                        </div>


                        <hr>
                        <input type="submit" name="sendFeedback" class="btn btn-success" value="Send"></p>
                </form>


            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php

if (isset($_POST['sendFeedback'])) {
    $msg = $_POST['message'];
    $send = sendFeedback($msg);
    echo $send;
    if ($send) {
        echo "<script>alert('Komentar terkirim! kita akan kembali kepada kamu');window.location='individual.php'</script>";
    } else {
        echo "<script>alert('Komentar tidak dapat dikirim! Coba lagi!');window.location='individual.php'</script>";
    }
}

?>