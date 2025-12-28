🌍 EduMap- Website Pemetaan Ketimpangan Pendidikan SD di Aceh

EduMap merupakan aplikasi web yang berfungsi sebagai platform pemetaan dan analisis ketimpangan pendidikan Sekolah Dasar (SD) di Provinsi Aceh. Aplikasi ini menyajikan data pendidikan dalam bentuk visualisasi peta interaktif, dashboard analitik, serta sistem pelaporan terverifikasi untuk mendukung transparansi dan akurasi data.

---

## 👥 Tim Pengembang

Kelompok EduMap

Aska Shahira — 2308107010075
Tasya Maulida — 2308107010079

---

##  Fitur-Fitur EduMap

🔐 Autentikasi Pengguna (Register & Login)

Fitur autentikasi memungkinkan pengguna untuk membuat akun dan mengakses sistem secara aman menggunakan email dan password. Mekanisme ini memastikan bahwa setiap data yang dikirimkan berasal dari pengguna terdaftar sehingga meningkatkan kredibilitas laporan dan keamanan sistem secara keseluruhan.

---

🏠 Landing Page

Landing Page berfungsi sebagai halaman awal EduMap yang menampilkan identitas aplikasi, deskripsi singkat tujuan sistem, serta navigasi menuju fitur utama. Halaman ini dirancang agar pengguna dapat memahami fungsi EduMap secara cepat dan intuitif sejak pertama kali mengakses aplikasi.

---

📝 Formulir Lapor Data Sekolah

Fitur ini memungkinkan pengguna untuk menginput dan mengirimkan data kondisi sekolah dasar secara langsung. Data yang dilaporkan meliputi jumlah guru, jumlah siswa, ketersediaan akses internet, serta informasi lokasi sekolah. Setiap laporan yang masuk akan disimpan dalam sistem dan menunggu proses validasi oleh admin sebelum dipublikasikan.

---

🗺️ Peta Interaktif Ketimpangan Pendidikan

Peta interaktif menampilkan sebaran kondisi pendidikan SD di Aceh berdasarkan data yang telah diverifikasi. Tingkat ketimpangan divisualisasikan menggunakan indikator warna (hijau, kuning, dan merah) untuk memudahkan pemahaman. Pengguna juga dapat menggunakan fitur filter wilayah untuk melihat kondisi pendidikan pada daerah tertentu secara spesifik.

---

📊 Dashboard EduMap

Dashboard menyajikan ringkasan data pendidikan dalam bentuk visualisasi grafik dan statistik. Fitur ini membantu pengguna memahami pola ketimpangan pendidikan secara lebih komprehensif. Selain itu, dashboard menyediakan opsi untuk mengunduh laporan data dalam format PDF dan Excel sebagai bahan analisis lanjutan atau dokumentasi.

---

🚨 Rekomendasi Intervensi Prioritas

Fitur ini secara otomatis menampilkan daftar sekolah dengan tingkat ketimpangan pendidikan tertinggi berdasarkan data yang tersedia. Rekomendasi ini dapat digunakan sebagai dasar penentuan prioritas intervensi, baik untuk perbaikan infrastruktur, penambahan tenaga pendidik, maupun peningkatan fasilitas pendukung lainnya.

---

 ℹ️ Halaman Tentang EduMap

Halaman ini berisi informasi mengenai latar pengembangan EduMap, visi dan misi aplikasi, serta peran EduMap dalam mendukung pemerataan akses pendidikan. Fitur ini memberikan konteks dan pemahaman lebih dalam kepada pengguna mengenai tujuan keberadaan sistem.

---

🛡️ Admin Panel

Admin Panel berperan sebagai pusat pengelolaan dan validasi data. Setiap laporan yang dikirimkan oleh pengguna akan melalui proses moderasi oleh admin dengan berkoordinasi bersama Dinas Pendidikan setempat untuk melakukan verifikasi lapangan. Laporan yang dinyatakan valid akan disetujui dan ditampilkan sebagai data resmi, sedangkan laporan yang tidak sesuai dengan kondisi sebenarnya akan ditolak. Mekanisme ini memastikan bahwa seluruh data yang dipublikasikan dapat dipercaya dan dipertanggungjawabkan.

---

⚙️ Teknologi yang Digunakan

1. Backend: Laravel
2.Frontend: Vue.js
3.Database: PostgreSQL
4.Deployment: Railway.app
5.CI/CD: GitHub Actions

---

🔄 CI/CD (GitHub Actions)

EduMap menerapkan Continuous Integration dan Continuous Deployment (CI/CD) menggunakan GitHub Actions. Setiap perubahan kode yang di-push ke branch `main` akan melalui proses otomatis berupa pemeriksaan kualitas kode, build frontend, serta validasi dependensi sebelum aplikasi dideploy ke server produksi. Mekanisme ini membantu menjaga stabilitas dan konsistensi aplikasi.

---

Deployment

Aplikasi EduMap dideploy menggunakan Railway.app yang terintegrasi langsung dengan repositori GitHub. Platform ini mendukung otomatisasi build dan deployment, menyediakan layanan web service dan database, serta log monitoring real-time untuk memastikan aplikasi berjalan dengan baik.

🔗 Link Aplikasi:
[https://7579edumap-production.up.railway.app/](https://7579edumap-production.up.railway.app/)

---

🧾 Logging & Monitoring

Proses logging dilakukan menggunakan fitur Log Streaming dari Railway yang memungkinkan pemantauan aktivitas aplikasi secara real-time. Log yang dipantau mencakup HTTP Logs untuk request pengguna, Runtime Logs untuk error aplikasi, serta Deploy Logs untuk proses build dan deployment.


Terima kasih telah menggunakan EduMap
