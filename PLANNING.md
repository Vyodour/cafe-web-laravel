# Membuat Web Kafe dengan tema desain seperti
https://www.tuku.coffee/id

Menggunakan db sqlite
Menggunakan desain tailwind css

Menggunakan struktur components untuk foldernya.

Halaman awal adalah landing page, yang berisi informasi tentang kafe. dan ada desain yang interaktif.

Ada tombol explore di dalam landing page untuk langsung masuk ke tampilan dimana user bisa melihat produk kopi yang dapat di tampilkan.

Namun jika user ingin melakukan pembelian, user harus login terlebih dahulu. dan jika user belum punya akun, user bisa mendaftar terlebih dahulu.

Fitur payment gateaway yang bisa menggunakan midtrans sandbox sebagai pembayaran online.
Namun jika ingin membayar ditempat maka pengguna akan memesan setelah itu akan muncul qrcode atau barcode yang dimana akan di scan oleh penjual. Untuk kasus nyatanya nya user tidak akan langsung dibuatkan kopinya, cuma sebagai bukti bahwa user sudah memesan.
Nah kalau minum ditempat user akan scan qr yang ada di tiap meja untuk memesan dan sudah terintegrasi mejanya dengan admin atau di kasir.



---

Struktur DB nya:

Tabel Cafe:
- id
- name
- slug->unique
- description
- address
- phone
- email
- image
Tabel Cafe Tags:(many to many)
- id
- cafe_id
- tag_id
Tabel Tags:
- id
- name

Tabel Products:
- id
- cafe_id
- name
- slug (Unique) {cafe-slug}-{product-name-slug}
- category_id
- description
- price
- image
- stock_quantity
- is_available->bool(true)
- badges->Json(new,limited,discount,best_seller)
- discount_price
- special_until
- timestamps()->created_at, updated_at
- softDeletes()->Untuk fitur Soft Deletes (Keamanan Audit)
Tabel Categories:
- id
- name
- slug->unique
- icon->img

Tabel User(sesuaikan dengan migrasi default yang sudah ada):
- id
- name
- email
- password
- role

Tabel Tables:
- id
- cafe_id
- qr_code_token->unique(string)
- table_number
- status->(available,occupied,reserved)
Untuk fitur Scan QR di meja, URL pada QR Code akan merujuk pada id di tabel ini.


Tabel Orders:(Menyesuaikan dengan order apa yang digunakan, pesan online pakai midtrans, pesan take away pakai qrcode, pesan ditempat pakai qrcode) Untuk isi tabelnya coba di sesuaikan lagi deh, research dulu
- id
- user_id
- cafe_id
- table_id->nullable(terisi kalau dine-in)
- type->(online,takeaway,dine_in)
- status->(pending,paid,preparing,completed,cancelled)
- total_price
- tax_amount

Tabel Order Items:
- id
- order_id
- product_id
- quantity
- unit_price
- notes->(misal: tanpa gula, extra ice, dll)
- timestamps()->created_at, updated_at

Tabel Transaksi:
- id
- order_id
- payment_method->(midtrans,cash,qris)
- reference_number
- payment_status->(pending, settlement(berhasil), expire, deny)
- payment_type->(midtrans api http notification: bank_transfer, credit, qris, va, atau isinya kayak dana, gopay, shopee_pay)
- snap_token->(hanya untuk midtrans)
- gross_amount
- transaction_time
- va_number / payment_code->(hanya untuk midtrans va)
- expired_at

Keamanan & Audit (Timestamp & Soft Deletes)
Di kasus nyata, Admin mungkin salah hapus produk.
Saran: Gunakan Laravel Soft Deletes (deleted_at) di semua tabel utama. Jadi data tidak benar-benar hilang dari database jika terhapus, hanya disembunyikan.
---

Admin UI
Untuk admin sebenarnya memiliki masing masing halaman untuk mengelola produk, user, dan pesanan.

Untuk admin UI, saya ingin membuat desain tanpa table, jadi lebih ke desain UI kayak card card. nah untuk admin di awal akan terdapat card card untuk tampilan kafe nya. dan kalau di tekan masing masing kafe itu akan menampilkan detail kafenya, lalu terdapat produk-produk, dan user yang sedang online atau ingin melihat kafe itu.