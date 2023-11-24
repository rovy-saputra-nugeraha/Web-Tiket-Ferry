<?php
if (!isset($file_access)) die("Direct File Access Denied");
?>

<div class="content">
    <div class="container-fluid">
        <?php
        if (!isset($_POST['submit'])) {
        ?>
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header alert-success">
                        <h5 class="m-0">Pemberitahuan</h5>
                    </div>
                    <div class="card-body">
                        Selamat Datang Para Tamu Traveler Kami yang Terhormat. <br><br>
                        Kami akan menyampaikan beberapa hal terkait aplikasi ini. <br>
                        Gunakan pilihan menu di sebelah kiri anda.
                        <br />Anda dapat melihat daftar jadwal dengan mengklik "Pemesanan Baru". Sistem akan menampilkan daftar jadwal yang tersedia untuk Anda yang dapat anda lihat dan lakukan pemesanan. Sebelum pemesanan Anda disimpan, Anda diarahkan untuk melakukan pembayaran. Setelah pembayaran berhasil,Anda akan menerima bukti pemesanan melalu email anda dimana anda dapat menunjukkanya di pelabuhan keberangkatan. <br><br> Kami selaku PT. Mv.zy mohon maaf atas ketidak nyamanan ini.
                    </div>
                </div>
            </div><?php
                    } else {
                        $class = $_POST['class'];
                        $number = $_POST['number'];
                        $schedule_id = $_POST['id'];
                        if ($number < 1) die("Nomor Tidak Valid");
                        ?>

            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header alert-success">
                            <h5 class="m-0">Booking Preview</h5>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> <?php echo ucwords($class), " Class" ?>:</h5>
                                Anda akan memesan
                                <?php echo $number, " Tiket Ferry", $number > 1 ? 's' : '', ' dari ', getRouteFromSchedule($schedule_id); ?>
                                <br />

                                <?php

                                    $fee = ($_SESSION['amount'] = getFee($schedule_id, $class));
                                    echo $number, " x Rp.", $fee, " = Rp.", ($fee * $number), "<hr/>";
                                    $fee = $fee * $number;
                                    $amount = intval($fee);
                                    $vat = ceil($fee * 0.01);
                                    echo "Biaya PPN = Rp.$vat<br/><br/><hr/>";
                                    echo "Total = Rp.", $total = $amount + $vat;
                                    $fee =  intval($total) . "00";
                                    $_SESSION['amount'] =  $total;
                                    $_SESSION['original'] =  $fee;
                                    $_SESSION['schedule'] =  $schedule_id;
                                    $_SESSION['no'] =  $number;
                                    $_SESSION['class'] =  $class;
                                    ?>
                            </div>
                            <p>Klik Tombol Dibawah ini Sesuai Tujuan Anda Untuk Reservasi Tiket. <br> Bayar Sesuai Jumlah yang Telah di Tampilkan.</p>
                            <a href="https://forms.gle/6pCqEqkMP6E5Jc3P9"><button
                                    onclick="return confirm('Anda akan diarahkan untuk melakukan pembayaran.\nLakukan Pembayaran untuk menyelesaikan pemesanan Anda!')"
                                    class="btn btn-primary">Lingga</button></a>
                            <a href="https://forms.gle/trem3iHkPss1LvHf7"><button
                                    onclick="return confirm('Anda akan diarahkan untuk melakukan pembayaran.\nLakukan Pembayaran untuk menyelesaikan pemesanan Anda!')"
                                    class="btn btn-primary">Batam</button></a>
                            <a href="https://forms.gle/r4mjsJiUp9S2V3s69"><button
                                    onclick="return confirm('Anda akan diarahkan untuk melakukan pembayaran.\nLakukan Pembayaran untuk menyelesaikan pemesanan Anda!')"
                                    class="btn btn-primary">Tanjungpinang</button></a>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>