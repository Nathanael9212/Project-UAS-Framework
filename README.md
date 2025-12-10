# 🎓 Sistem Pendaftaran Siswa Baru

Aplikasi web untuk mengelola pendaftaran siswa baru secara online dengan tampilan admin dashboard berbasis template **Mazer**.

---

## 💡 Gambaran Singkat

- **Siswa** bisa daftar akun, lengkapi biodata, upload foto, dan memilih **maksimal 2 jurusan**.
- **Admin & Petugas** mengelola data siswa, jurusan, dan memutuskan pendaftaran **diterima / ditolak**.
- Sistem menggunakan **role-based access**, jadi setiap role hanya melihat menu dan fitur yang sesuai.

---

## 🔄 Cara Kerja Website

**Alur Siswa**
1. Register & login → otomatis sebagai `siswa`.
2. Isi biodata lengkap + upload foto.
3. Pilih jurusan (maks 2) → status awal **Pending**.
4. Cek riwayat pendaftaran & status (**Pending / Diterima / Ditolak**).

**Alur Admin/Petugas**
1. Login ke dashboard admin.
2. Lihat statistik: total siswa, total pendaftaran, pending, diterima, ditolak.
3. Kelola:
   - **Data Siswa** (CRUD + foto profil).
   - **Data Jurusan** (CRUD).
   - **Data Pendaftaran** (review, approve, reject).

---

## ✨ Fitur Utama

- 3 Level user: **Admin, Petugas, Siswa**.
- CRUD **Siswa, Jurusan, Pendaftaran**.
- Upload & tampilkan **foto profil** di sidebar dan tabel.
- Validasi: **maksimal 2 jurusan per siswa**, tidak bisa daftar jurusan yang sama dua kali.
- Dashboard khusus untuk admin dan siswa dengan tampilan modern (Mazer).

---

## 🧱 Database & Relasi

- `users` (akun + role)  
- `siswas` (profil siswa + foto, FK ke `users`)  
- `jurusans` (daftar jurusan)  
- `pendaftarans` (riwayat pendaftaran, FK ke `siswas` & `jurusans`)

Relasi:
- `users` 1–1 `siswas`  
- `siswas` 1–N `pendaftarans`  
- `jurusans` 1–N `pendaftarans`

---

## 👨‍💻 Author

**Nathanael Kristian Sujarwo    23081010271
**Paulus Calep Sandria Saputra 	23081010275
**Nony Yonindah 			    23081010055
**Moch. Wahyu Aditya 		    23081010126

