-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2025 at 08:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Gadget', '2025-06-06 05:01:52', '2025-06-06 05:01:52'),
(2, 'E-Sport', '2025-06-06 05:01:52', '2025-06-06 05:01:52'),
(3, 'Health', '2025-06-06 05:01:52', '2025-06-06 05:01:52'),
(4, 'Finance', '2025-06-06 05:01:52', '2025-06-07 12:23:40'),
(5, 'Infrastruktur', '2025-06-06 05:01:52', '2025-06-06 05:01:52'),
(6, 'Fintech', '2025-06-06 05:01:52', '2025-06-06 05:01:52'),
(7, 'Travel', '2025-06-06 05:01:52', '2025-06-06 05:01:52'),
(8, 'Akademik', '2025-06-07 14:15:17', '2025-06-07 14:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `news_id`, `comment_text`, `created_at`) VALUES
(1, 2, 5, 'Wah akhirnya Intel punya GPU yang bisa saingi NVIDIA! Harga 3.9 juta lumayan terjangkau untuk performa segitu.', '2024-12-11 01:10:00'),
(2, 4, 5, 'XeSS 2 kayaknya bakal jadi game changer nih. Mudah-mudahan optimasi game-nya bagus.', '2024-12-11 02:20:00'),
(3, 2, 6, 'Semangat RRQ dan TLID! Semoga bisa juara di M6 ini 🔥', '2024-12-11 01:20:00'),
(4, 4, 6, 'TLID vs RRQ tadi seru banget! Moga TLID bisa sampai grand final.', '2024-12-11 02:25:00'),
(5, 2, 7, 'Alhamdulillah UMP naik 6.5%. Semoga bisa membantu pekerja menghadapi inflasi.', '2024-12-11 01:40:00'),
(6, 4, 7, 'Kapan ya Jakarta diumumin? Ditunggu banget nih kenaikannya.', '2024-12-11 03:05:00'),
(7, 4, 8, 'Wah ASN udah mulai pindah April 2025. Semoga infrastruktur IKN siap semua.', '2024-12-11 02:35:00'),
(8, 2, 8, 'Istana Garuda rampung Desember ini? Keren banget progressnya!', '2024-12-11 03:20:00'),
(9, 4, 9, 'Crypto emang volatil banget. Barusan tembus $100k eh turun lagi ke $95k.', '2024-12-11 02:55:00'),
(10, 2, 9, 'Yang penting HODL aja sih. Ini cuma koreksi sebelum naik lagi.', '2024-12-11 04:00:00'),
(11, 2, 10, 'Integrasi LRT sama kereta bandara bakal sangat membantu! Gak perlu gonta-ganti transportasi.', '2024-12-11 02:10:00'),
(12, 4, 10, 'Menhub kayaknya serius nih benerin konektivitas transportasi Jakarta.', '2024-12-11 03:10:00'),
(13, 2, 11, 'Jahe sama kunyit emang manjur buat diabetes. Nenek saya juga sering minum rebusan jahe.', '2024-12-11 03:25:00'),
(14, 4, 11, 'Bawang putih juga bagus ya ternyata. Mau coba konsumsi rutin ah.', '2024-12-11 03:40:00'),
(15, 4, 12, 'Info yang sangat berguna! Banyak yang terjebak pinjol ilegal karena tidak tahu cara hapus datanya.', '2024-12-11 03:35:00'),
(16, 2, 12, 'Penting banget laporin ke OJK kalau masih diteror. Jangan diam aja.', '2024-12-11 04:10:00'),
(17, 2, 10, 'test', '2025-06-07 10:58:20'),
(18, 1, 20, 'test admin', '2025-06-07 13:59:47'),
(19, 2, 20, 'test user 1', '2025-06-07 14:02:33');

-- --------------------------------------------------------

--
-- Table structure for table `interactions`
--

CREATE TABLE `interactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `type` enum('like','bookmark') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interactions`
--

INSERT INTO `interactions` (`id`, `user_id`, `news_id`, `type`, `created_at`) VALUES
(1, 2, 5, 'like', '2024-12-11 01:00:00'),
(2, 2, 6, 'like', '2024-12-11 01:15:00'),
(3, 2, 7, 'like', '2024-12-11 01:30:00'),
(5, 4, 5, 'like', '2024-12-11 02:15:00'),
(6, 4, 8, 'like', '2024-12-11 02:30:00'),
(7, 4, 9, 'like', '2024-12-11 02:45:00'),
(8, 4, 11, 'like', '2024-12-11 03:00:00'),
(9, 2, 5, 'bookmark', '2024-12-11 01:05:00'),
(10, 2, 7, 'bookmark', '2024-12-11 01:35:00'),
(11, 2, 11, 'bookmark', '2024-12-11 03:15:00'),
(12, 4, 6, 'bookmark', '2024-12-11 02:20:00'),
(13, 4, 9, 'bookmark', '2024-12-11 02:50:00'),
(14, 4, 12, 'bookmark', '2024-12-11 03:30:00'),
(15, 2, 10, 'like', '2025-06-07 10:58:25'),
(16, 2, 10, 'bookmark', '2025-06-07 10:58:26'),
(17, 1, 12, 'like', '2025-06-07 11:10:34'),
(18, 1, 12, 'bookmark', '2025-06-07 11:10:36'),
(19, 1, 20, 'like', '2025-06-07 13:59:56'),
(21, 2, 20, 'bookmark', '2025-06-07 14:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `release_date` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `release_date`, `image`, `category_id`, `created_by`) VALUES
(5, 'gpu Intel yang Ditunggu-tunggu Akhirnya Dirilis', 'Surabaya - Intel mengumumkan kehadiran dua kartu grafis terbarunya dengan arsitektur Battlemage, yaitu Arc B580 dan Arc B570. Seperti apa kemampuannya?\r\nArc B580 akan diluncurkan pada 13 Desember 2024 mendatang, dan dijanjikan punya performa yang bisa menyalip RTX 4060. VRAM B580 adalah 12GB dan B570 adalah 10GB, yang membuatnya cocok untuk nge-game di resolusi 1440p (RTX 4060 hanya punya VRAM 8GB).\r\n\r\nTentu bukan cuma performanya yang menarik. Intel melengkapi B580 dengan XeSS 2, yang merupakan teknologi AI super resolution terbaru Intel yang mirip dengan Nvidia DLSS 3. Ada juga Xe Low Latency yang bisa mengurangi latensi di game.\r\n\r\n\"GPU Intel Arc B-Series terbaru hadir dengan peningkatan yang sempurna bagi para gamer. GPU ini menawarkan performance-per-dollar terdepan dan pengalaman gaming 1440p yang luar biasa dengan XeSS 2, ray tracing engine generasi kedua, dan engine AI XMX. Kami sangat senang dapat bekerja sama dengan lebih banyak mitra dari sebelumnya, sehingga para gamer memiliki lebih banyak pilihan dalam mencari desain yang sempurna bagi mereka,\" kata Vivian Lien, Intel vice president dan general manager Client Graphics, dalam keterangan yang diterima detikINET, Selasa (10/12/2024).\r\n\r\nXeSS 2 kini memiliki tiga teknologi: XeSS Super Resolution, XeSS Frame Generation, dan Xe Low Latency. XeSS Super Resolution adalah teknologi utama yang mendasari generasi pertama XeSS, menawarkan peningkatan resolusi berbasis AI selama lebih dari dua tahun dan kini mendukung lebih dari 150 game.\r\n\r\nTeknologi baru XeSS Frame Generation yang didukung AI menambahkan frame interpolasi menggunakan aliran optik dan proyeksi ulang vektor gerakan untuk memberikan pengalaman gaming yang lebih lancar. Dan Xe Low Latency yang baru terintegrasi dengan game engine untuk memberikan respons lebih cepat terhadap input pemain. Dengan diaktifkannya tiga teknologi ini, XeSS 2 mampu meningkatkan output frame-per-second hingga 3,9x, menghadirkan performa tinggi pada game-game AAA.\r\n\r\nSoftware grafis Intel yang baru akan memberikan akses ke pengaturan tampilan termasuk mode warna dan scaling, serta dukungan variable refresh rate (VRR). Pengaturan grafis 3D mencakup pembatas frames-per-second dan mode latensi rendah pada tingkat driver.\r\n\r\nSalah satu fitur menarik dari GPU Arc-B ini adalah dukungan AI Playground, sebuah aplikasi starter AI serba guna dan mudah digunakan. Dirancang untuk menjalankan beban kerja AI generatif secara lokal, memungkinkan pengguna dengan mudah mengubah teks jadi gambar, pengeditan foto, dan upscaling, serta menyesuaikan chatbot dengan data mereka sendiri.\r\n\r\nKartu grafis Intel Arc B580 Limited Edition dan model-model dari mitra seperti Acer, ASRock, Gunnir, Onix Technology, Maxsun, dan Sparkle akan tersedia mulai 13 Desember 2024, dengan harga mulai USD 249 atau sekitar Rp 3,9 juta.\r\n\r\nSementara itu Arc B570 tersedia dari mitra yang sama mulai 16 Januari, dan harganya mulai USD 219 atau sekitar Rp 3,4 juta.', '2024-12-11 00:00:00', 'assets/news/684444b77cfa0.png', 1, 9),
(6, 'Jadwal M6 Mobile Legends Knockout Stage: RRQ dan TLID Main 11 Desember', 'Jakarta - Dua wakil Indonesia di kompetisi M6 Mobile Legends, RRQ Hoshi dan Team Liquid ID, akan kembali tampil pada Rabu esok hari di babak knockout stage. Berikut informasi jadwal mainnya.\r\nPertandingan mereka akan terselenggara secara offline di Axiata Arena, Kuala Lumpur, Malaysia. RRQ Hoshi akan bermain duluan di lower bracket pada pagi hari. Sementara penampilan Team Liquid ID di final upper bracket akan menjadi penutupnya.\r\n\r\nUntuk lawan yang akan dihadapi RRQ masih menunggu hasil duel Selangor Red Giants Vs NIP Flash. Pemenangnya akan melaju ke quarter final lower bracket dan bertemu Sang Raja dari Segala Raja.\r\n\r\nRRQ berada di lower bracket, karena kalah adu mekanik dari sedulurnya Team Liquid ID di semifinal upper bracket. Persaingan keduanya dalam memperebutkan slot final upper begitu sengit. Namun di sini Team Liquid ID yang berhasil menang dengan skor tipis 3-2.\r\n\r\nLalu kemenangan Team Liquid ID membawanya ke final upper dan berhadapan dengan Fnatic Onic PH. Ini menjadi pertemuan mereka yang kedua kalinya.\r\n\r\nUntuk skema pertandingannya ialah best of 5 (Bo5). Jadi bila ingin lanjut ke fase berikutnya di babak knockout stage, wajib memenangkan tiga game dulu dengan skenario skor 3-0, 3-1, atau 3-2.\r\n\r\nBagi yang ingin memberikan dukungan kepada tim asal Indonesia, para penggemar bisa menyaksikannya secara online. Pihak penyelenggara menayangkan siaran langsungnya di kanal YouTube MLBB Esports.', '2024-12-02 00:00:00', 'assets/news/Esport.jpeg.jpg', 2, 1),
(8, 'Istana hingga Kantor Kemenko di IKN Ditargetkan Rampung Bulan Ini', 'Jakarta - Kementerian Pekerjaan Umum (PU) menargetkan beberapa infrastruktur di Ibu Kota Nusantara (IKN) akan selesai pada Desember 2024 ini. Infrastruktur tersebut di antaranya Istana Garuda, Kantor Sekretariat Negara, serta Gedung dan Kawasan Kantor Kementerian Koordinator.\r\nWakil Menteri PU Diana Kusumastuti memastikan sejumlah infrastruktur itu akan diresmikan juga dalam waktu dekat. Persiapan infrastruktur itu untuk mendukung pemindahan Aparatur Sipil Negara (ASN) pada awal 2025 dan rencana pemindahan ibu kota negara 2028.\r\n\r\nDiana menuturkan, berdasarkan arahan Presiden Prabowo Subianto, pemindahan ibu kota negara ke IKN harus tetap dilakukan, salah satunya karena peningkatan air muka laut yang mengancam wilayah Jakarta. Prabowo berencana untuk mulai berkantor di IKN pada 17 Agustus 2028.\r\n\r\n\"Kami tetap semangat untuk menyesaikan IKN, alokasi anggarannya pun tetap ada juga di Kementerian untuk melanjutkan infrastrukturnya. Persiapan untuk pemindahan ke IKN juga sudah mulai kita lakukan dari sekarang,\" kata Diana dalam keterangannya dikutip dari Instagram @Kementerianpu, Selasa (10/12/2024).\r\n\r\nSementara itu, Kepala OIKN Basuki Hadimuljono menyampaikan ucapan terima kasih kepada Kementerian PU serta Kementerian/ Lembaga lainnya yang telah memberi masukan terkait bagaimana pembangunan, pemindahan, dan penyelenggaraan IKN perlu dilakukan ke depannya.\r\n\r\nNusantara (IKN), Kalimantan Timur. Menurutnya, ASN akan mulai pindah pada\r\nbulan April 2025 mendatang.\r\n\r\nDia bilang informasi ini didapatkan langsung dari Kementerian PAN-RB.\r\nMenurutnya, rencana awal ASN bisa pindah pada Januari 2025, namun karena\r\nmendekati bulan puasa maka diundur.\r\n\r\nMaka dari itu, ditetapkan lah ASN akan pindah ke IKN mulai April 2025 atau\r\nbisa disebut sehabis hari raya Lebaran.\r\n\r\n\"Menurut Menteri PAN-RB yang kita siapkan dan hitung semua itu mulai April.\r\nSebenarnya kan bulai Januari, cuma Maret kan lebaran. Ada lebaran mungkin\r\ndihitung itu,\" sebut Basuki ketika ditanya kapan ASN pindah ke IKN, di\r\nKompleks Istana Kepresidenan, Jakarta Pusat, Selasa (10/12).', '2024-12-05 00:00:00', 'assets/news/Infrastruktur.jpeg.jpg', 5, 1),
(9, 'Harga Bitcoin Terjun Bebas, Ini Penyebabnya', 'Jakarta - Harga mata uang kripto, Bitcoin (BTC) terjun bebas setelah menembus level US$ 100.000 pada awal Desember lalu. Kripto dengan kapitalisasi pasar terbesar, Bitcoin anjlok 5% menjadi US$ 95.519 pada Senin (9/12) kemarin.\r\nMengutip Coindesk, Selasa (10/12/2024) kapitalisasi pasar kripto global turun. Bitcoin kembali turun ke level US$ 95.000 atau 5% selama 24 jam terakhir. Sementara itu, Ether (ETH) turun 10% menjadi US$ 3.590.\r\n\r\nBerdasarkan Indeks CoinDesk20, penurunan juga terjadi di beberapa aset kripto. Bahkan penurunan 20% untuk Cardano (ADA), Avalanche (AVAX), dan XRP (XRP).\r\nAda beberapa tanda menurunnya momentum di pasar kripto, termasuk menurunnya volume dan aksi ambil untung besar-besaran oleh pemegang jangka panjang. Pendiri 10x Research, Markus Thielen mengatakan fase ini merupakan salah satu fase konsolidasi sementara sebelum pasar kembali bullish.\r\n\r\n\"Namun, para trader sekarang harus memperhatikan dengan seksama posisi mana yang berkinerja lebih baik dan mana yang berkinerja buruk, karena reli memasuki fase di mana tidak semuanya akan terus meningkat,\" kata Thielen.\r\n\r\nDia mengimbau agar para trader menjauhi segmen yang lebih lemah dan fokus pada aset kripto pilihan masing-masing. Hal ini dilakukan agar para trader dapat menavigasi pasar kripto secara efektif.\r\n\r\n\"Untuk menavigasi pasar ini secara efektif, para trader harus menjauhi segmen yang lebih lemah dan berfokus pada posisi inti mereka yang memiliki keyakinan tinggi,\" tambahnya.\r\n\r\nSementara itu, perusahaan perdagangan aset kripto terkemuka di Singapura, QCP Capital dalam laporannya menyebut kondisi tersebut disebabkan beberapa hal, di antaranya para trader di pasar semakin memposisikan diri untuk dalam kondisi sideways hingga akhir tahun, mengambil untung dari tren bullish mereka sebelumnya, hingga berpotensi memperpanjang posisi hingga awal tahun depan.\r\n\r\n\"Meskipun kami masih bullish secara struktural, (harga) spot kemungkinan seperti sekarang selama sisa musim liburan,\" tulis laporan tersebut.', '2024-12-01 00:00:00', 'assets/news/Fintech.jpeg.jpg', 6, 7),
(10, 'MRT Bakal Terhubung Kereta Bandara?', 'Jakarta - Menteri Perhubungan (Menhub) Dudy Purwagandhy menyatakan saat ini sedang mengkaji rencana mengintegrasikan Kereta Api (KA) Bandara dengan LRT Jabodebek. Langkah itu dilakukan untuk mempermudah traveler menuju bandara.\r\nRencana itu sempat disampaikan oleh Menteri BUMN Erick Thohir. Dudy mengatakan saat ini Kementerian Perhubungan memetakan titik-titik mana saja yang bisa diintegrasikan antara LRT Jabodebek dengan KA Bandara.\r\n\r\n\"Itu kita lagi kerjakan, misalnya ada titik yang bisa kita sambungkan itu kita akan lakukan. Kita lagi mengkaji kira-kira titik mana yang bisa kita sambung antara LRT sama kereta bandara,\" kata Dudy seperti dikutip dari detikFinance, Selasa (10/12/2024).\r\n\r\nDudy belum dapat memastikan waktu pengintegrasian antara LRT Jabodebek dengan KA Bandara berjalan.\r\n\r\n\"Saya harapkan sih dalam waktu dekat ya. Kita lagi usahakan. Maunya lebih cepat lebih baik,\" kata dia.\r\n\r\nSebelumnya, Menteri BUMN Erick Thohir mengungkapkan bahwa akan ada inovasi dari Kementerian Perhubungan untuk mengintegrasikan Kereta Api (KA) Bandara dengan LRT Jabodebek.\r\n\r\nDia mengatakan inovasi tersebut dilakukan lantaran konektivitas masih menjadi tantangan bagi pemerintah untuk menghubungkan masyarakat menggunakan kereta menuju ke pusat kota Jakarta.\r\n\r\nSaat ini, KA Bandara sudah terhubung dengan KRL Jabodetabek. Traveler bisa menggunakan KA Bandara melalui Stasiun Manggarai, Stasiun Sudirman Baru (BNI City), Stasiun Duri, Stasiun Rawa Buaya dan Stasiun Batu Ceper.\r\n\r\n\"PR nya satu, bagaimana konektivitas waktu keluar, naik, tentu kereta api yang menuju kota,\" kata Erick di Bandara Soekarno-Hatta, Tangerang, Banten, Kamis (5/12).\r\n\r\n\"Menhub ingin menyambungkan dari kereta dan ke LRT, dari kereta airport. Nah, itu pakai apa? Saya nggak boleh ngomong. Beliau nanti yang ngomong,\" kata Erick.', '2024-12-09 00:00:00', 'assets/news/Travel.jpg', 7, 1),
(12, 'Catat, Ini Cara Menghapus Data di Aplikasi Pinjol Ilegal', 'Jakarta - Aplikasi pinjaman online (pinjol) menjadi solusi cepat bagi orang-orang yang membutuhkan dana darurat. Sayangnya, banyak aplikasi pinjol ilegal yang merugikan masyarakat.\r\nSaat menggunakan aplikasi ini, peminjam seringkali melibatkan data pribadi. Diketahui bahwa pinjol ilegal mempunyai sejumlah resiko, seperti penyalahgunaan data pribadi. Untuk itu, peminjam yang berurusan dengan pinjol legal harus mengetahui cara menghapus data di aplikasi.\r\n\r\nCara Menghapus Data di Aplikasi Pinjol Ilegal\r\nUntuk menghapus data di Pinjol ilegal, ada beberapa cara yang bisa dilakukan. Mengutip laman OCBC, berikut caranya:\r\n\r\n1. Lunasi Pinjaman\r\nKetika pinjaman dilunasi dan tidak mengajukan pinjaman baru, maka penyedia jasa pinjol tidak akan menghubungi lagi. Datamu pun akan terhapus.\r\nMemang terjadi perdebatan di kalangan masyarakat terkait pembayaran tagihan di pinjol. Pinjol ilegal dianggap tidak perlu dibayar sebab tidak berizin.\r\nNamun, kamu bisa melunasinya sebagai bentuk tanggung jawab agar tidak dihubungi oleh pihak pinjol. Setelah itu berhenti dan jangan lakukan pinjaman lagi.\r\n\r\n2. Lapor ke OJK\r\nKetika pinjaman sudah dilunasi namun masih diteror, laporkan ke OJK. Sampaikan masalah yang dialami dan minta solusi. Pelaporan bisa dilakukan ke situs OJK, email, atau kontak resminya di\r\nAlamat email OJK: waspadainvestasi@ojk.go.id\r\nSitus resmi OJK: ojk.go.id\r\nWhatsApp OJK: 081-157-157\r\nKontak resmi OJK: 157.\r\n\r\n3. Hapus Akun dan Uninstall Aplikasi\r\nPenghapusan data dapat dilakukan dengan cara menghapus akun dan\r\naplikasi. Begini caranya:\r\nBuka aplikasi pinjol\r\nPilih menu Pengaturan\r\nKlik opsi Hapus Akun\r\nIkuti langkah selanjutnya sesuai panduan\r\nKonfirmasi keinginan penghapusan akun\r\nAkun di aplikasi sudah terhapus.\r\nJangan lupa untuk uninstall aplikasi pinjol. Dengan begitu, kamu tidak akan dihubungi lagi oleh penyedia jasa pinjol ilegal.\r\n\r\nCiri-ciri Pinjaman Online Legal dan Ilegal\r\nPenting untuk mengetahui mana pinjaman legal dan ilegal sebelum meminjam. Menurut laman Otoritas Jasa Keuangan (OJK), berikut ciri-cirinya.\r\nPinjaman Online Legal\r\nTerdaftar/berizin dari OJK\r\nPinjol legal tak pernah menawarkan melalui komunikasi pribadi\r\nPemberian pinjaman akan diseleksi terlebih dahulu\r\nBunga atau biaya pinjaman dilakukan secara transparan\r\nPeminjam yang tak bisa membayar setelah batas waktu 90 hari akan masuk ke daftar hitam (blacklist) Fintech Data Center. Dalam kondisi ini peminjam tidak dapat meminjam dana ke platform fintech yang lain\r\nMemiliki layanan pengaduan\r\nIdentitas pengurus dan alamat kantor diketahui dengan jelas\r\nHanya mengizinkan akses kamera, mikrofon, dan lokasi pada gawai peminjam\r\nPihak penagih wajib mempunyai sertifikasi penagihan yang diterbitkan oleh AFPI.\r\n\r\nPinjaman Online Ilegal\r\nTidak terdaftar/tidak berizin dari OJK\r\nSaat memberikan penawaran, penyedia layanan pinjol memberi pesan melalui SMS/Whatsapp dalam memberikan penawaran\r\nPemberian pinjaman sangat mudah\r\nBunga atau biaya pinjaman dan denda tidak jelas\r\nAdanya ancaman teror, intimidasi, dan pelecehan bagi peminjam yang tidak bisa membayar\r\nTidak mempunyai layanan pengaduan\r\nTidak memiliki identitas pengurus dan alamat kantor tidak jelas\r\nMeminta akses seluruh data pribadi yang ada di dalam gawai peminjam		\r\nPihak yang menagih tidak mempunyai sertifikasi penagihan yang dikeluarkan Asosiasi Fintech Pendanaan Bersama Indonesia (AFPI).\r\nKetika sudah terlanjur meminjam di pinjaman online ilegal, pastikan kamu tidak melakukan pinjaman lagi. Jika ingin meminjam, maka pilih pinjol yang sudah terdaftar di OJK.\r\n', '2024-12-09 00:00:00', 'assets/news/Financial2.jpg', 4, 1),
(21, 'test', 'test', '2024-12-11 00:00:00', 'assets/news/68444bad27506.png', 8, 1),
(23, 'test2', 'test2', '2024-12-11 00:00:00', 'assets/news/68444dc645f9f.png', 8, 1),
(24, 'test3', 'test3', '2025-06-07 00:01:00', 'assets/news/684454c631e7c.png', 8, 1),
(25, 'test4', 'test4', '2025-06-07 00:02:00', 'assets/news/68445521ed130.png', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `birth_date` date NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `birth_date`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@nextc.id', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'Male', '1990-01-01', 'admin', '2024-12-11 01:07:46'),
(2, 'user', 'user@example.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'Female', '1995-05-15', 'user', '2024-12-11 01:07:46'),
(4, 'zaky', 'zaky@gmail.com', 'bf0b52439529700a4a04cea0ab5a0302283f86be667d49d8edc5209a22cab01d', 'Male', '2005-08-14', 'user', '2024-12-12 00:28:39'),
(5, 'Illona', 'illona@example.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'Female', '2003-08-09', 'user', '2025-06-06 05:28:14'),
(7, 'admin2', 'admin2@nextc.id', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Male', '2025-06-06', 'admin', '2025-06-06 21:33:09'),
(8, 'zaky', 'zaky@example.com', '6b51d431df5d7f141cbececcf79edf3dd861c3b4069f0b11661a3eefacbba918', 'Male', '2005-08-14', 'user', '2025-06-07 13:48:58'),
(9, 'Illona', 'illona@nextc.id', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'Female', '2025-06-07', 'admin', '2025-06-07 14:53:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_news_id` (`news_id`),
  ADD KEY `idx_news_created` (`news_id`,`created_at`);

--
-- Indexes for table `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_news_type` (`user_id`,`news_id`,`type`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_news_id` (`news_id`),
  ADD KEY `idx_type_news` (`type`,`news_id`),
  ADD KEY `idx_user_type` (`user_id`,`type`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_category_fk` (`category_id`),
  ADD KEY `fk_news_created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `interactions`
--
ALTER TABLE `interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_news_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
