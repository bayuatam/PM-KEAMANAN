<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Pesanan #<?= esc($order['id']) ?></title>
    
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<?= config('Midtrans')->clientKey ?>"></script>
</head>
<body style="font-family: sans-serif; text-align: center; padding-top: 50px; background-color: #f9f9f9;">
    
    <h2>Mempersiapkan Pembayaran Anda...</h2>
    <p>Mohon tunggu, jangan tutup halaman ini.</p>
    <p>Pesanan ID: <strong>#<?= esc($order['id']) ?></strong></p>
    
    <button id="pay-button" style="display:none;">Bayar Sekarang!</button>

    <script type="text/javascript">
        // Ambil tombol pembayaran
        var payButton = document.getElementById('pay-button');
        
        // Fungsi ini akan dipanggil saat halaman dimuat
        function startPayment() {
            // Panggil snap.pay() dengan Snap Token dari controller
            snap.pay('<?= $snapToken ?>', {
                onSuccess: function(result){
                    /* Pembayaran berhasil! Arahkan ke halaman sukses. */
                    window.location.href = '/checkout/success/<?= $order['id'] ?>';
                },
                onPending: function(result){
                    /* Pembayaran tertunda (misal: menunggu transfer) */
                    alert("Menunggu pembayaran Anda!");
                    window.location.href = '/checkout/success/<?= $order['id'] ?>';
                },
                onError: function(result){
                    /* Pembayaran gagal */
                    alert("Pembayaran gagal!");
                    window.location.href = '/cart'; // Kembali ke keranjang
                },
                onClose: function(){
                    /* Pelanggan menutup pop-up sebelum selesai */
                    alert('Anda menutup jendela pembayaran sebelum selesai.');
                    window.location.href = '/cart'; // Kembali ke keranjang
                }
            });
        }
        
        // Panggil fungsi pembayaran secara otomatis saat halaman siap
        document.addEventListener('DOMContentLoaded', function() {
            startPayment();
        });
    </script>
</body>
</html>