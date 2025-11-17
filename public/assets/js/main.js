document.addEventListener("DOMContentLoaded", function() {

    /**
     * Menangani semua tombol 'Tambah ke Keranjang' di seluruh situs.
     * Menggunakan AJAX (fetch) untuk menambahkan item tanpa reload halaman.
     */
    const addCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update counter di navbar
                        document.getElementById('cart-counter').innerText = data.total_items;
                        // Tampilkan notifikasi sukses
                        showToast(data.message, 'success');
                    } else {
                        // Tampilkan notifikasi error (misalnya, konflik penjual, stok habis)
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    /**
     * Menangani perubahan pada input kuantitas di halaman keranjang.
     * Menggunakan AJAX (fetch) untuk update subtotal dan total tanpa reload.
     */
    const quantityInputs = document.querySelectorAll('.cart-quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.dataset.id;
            const quantity = this.value;
            const csrfTokenName = document.querySelector('.csrf-token').getAttribute('name');
            const csrfTokenValue = document.querySelector('.csrf-token').getAttribute('value');

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            formData.append(csrfTokenName, csrfTokenValue);

            fetch('/cart/update', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update subtotal untuk item ini
                    const subtotalElement = document.getElementById('subtotal-' + productId);
                    if(subtotalElement) {
                        subtotalElement.innerText = data.new_subtotal;
                    }
                    // Update total keseluruhan
                    document.getElementById('grand-total').innerText = data.new_total;
                    // Update counter di navbar
                    document.getElementById('cart-counter').innerText = data.total_items;
                    // Tampilkan notifikasi
                    showToast('Keranjang diperbarui!', 'success');
                } else {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Gagal memperbarui keranjang.', 'error');
            });
        });
    });
    
    /**
     * KODE BARU
     * Menangani filter kategori di halaman utama.
     */
    const filterButtons = document.querySelectorAll('.category-filter-btn');
    const productItems = document.querySelectorAll('.product-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const filterId = this.dataset.categoryId; // Ambil ID kategori yang diklik

            // Loop melalui setiap item produk
            productItems.forEach(item => {
                if (filterId === 'all') {
                    item.style.display = 'block'; // Tampilkan semua
                } else {
                    // Cek apakah ID kategori produk cocok dengan ID filter
                    if (item.dataset.categoryId === filterId) {
                        item.style.display = 'block'; // Tampilkan item
                    } else {
                        item.style.display = 'none'; // Sembunyikan item
                    }
                }
            });
        });
    });

    /**
     * Fungsi helper untuk menampilkan notifikasi (toast) Bootstrap.
     * @param {string} message - Pesan yang akan ditampilkan.
     * @param {string} type - Tipe notifikasi ('success' atau 'error').
     */
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toast-container');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white ${type === 'success' ? 'bg-success' : 'bg-danger'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        toastContainer.appendChild(toast);
        
        const bootstrapToast = new bootstrap.Toast(toast);
        bootstrapToast.show();

        // Hapus elemen toast dari DOM setelah ditutup
        toast.addEventListener('hidden.bs.toast', function () {
            toast.remove();
        });
    }
});