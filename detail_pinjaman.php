<?php 

    if(session_status() == PHP_SESSION_NONE) {session_start();}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pinjaman</title>
    <style>
        *, body, html{
            padding: 0;
            margin: 0;
            text-decoration: none;
            box-sizing: border-box;
            font-size: 16px;
            background-color: rgba(211, 253, 230, 0.514);
            font-family: Ubuntu;
        }

        main{
            display: grid;
            grid-template-rows: repeat(2, 1fr);
            min-height: 100vh;
            padding: 10px;
        }

        img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        p{
            text-transform: capitalize;
            font-size: 1.3rem;
            margin: 10px;
        }

        h1{
            text-align: center;
            margin: 10px;
            font-size: 1.5rem;
            font-weight: normal;
            margin-bottom: 15px;
        }

        .action{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
        }

        button{
            padding: 10px;
            outline: none;
            border: none;
            border-radius: 10px;
            margin-top: 15px;
            font-size: 1.1rem;
            font-weight: 800;
            cursor: pointer;
            transition: 300ms ease-in-out;
            text-transform: capitalize;
            width: 100%;
            color: white;
        }

        .kembali{
            background-color: rgb(12, 168, 179);
        }

        .back{
            background-color: rgba(0,0,0,0.6);
        }

        .delete{
            background-color: red;
        }

        button:hover,
        button:active{
            background-color: #2d483a;
            color: white;
        }

        
        .modal-container{
            display: grid;
            place-content: center;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: transparent;
        }
        
        .modal-container > img{
            background-color: rgba(31, 31, 31, 0.9);
            height: 100vh;
            width: 100vw;
            object-fit: contain;
            z-index: 99;
        }

        .hidden{
            display: none;
        }

        .image {
            display: grid;
            place-content: center;
        }

        .image img {
            width: 100vw;
            object-fit: contain;
            object-position: center;
            max-width: 300px;
        }

        @media screen and (min-width: 800px){
            main{
                grid-template-rows: 1fr;
                grid-template-columns: repeat(2, 1fr);
            }

            .action{
                margin-top: auto;
                padding: 0 15px;
                gap: 20px;
            }

            h1{
                margin-bottom: 30px;
            }

            p{
                margin: 20px 10px;
            }
        }
    </style>
</head>
<body>
    <?php 
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            include("./action/connection.php");

            $semua_pinjaman = mysqli_query($mysqli, "SELECT denda, date_end, lunas FROM pinjam WHERE id = '$id'");
            if (!mysqli_error($mysqli)) {
                while ($pinjaman = mysqli_fetch_array($semua_pinjaman)) {
                    $denda = $pinjaman['denda'];
                    $date_end = $pinjaman['date_end'];
                    $lunas = $pinjaman['lunas'];
                }

                
                $tenggat_date = (strtotime(date("Y-m-d")) - strtotime($date_end))/60/60/24;
                if ($tenggat_date > 0 && $lunas !== "1") {
                    $total = $denda * $tenggat_date;
                    mysqli_query($mysqli, "UPDATE pinjam SET total_denda = $total");
                }

                $semua_pinjaman = mysqli_query($mysqli, "SELECT * FROM pinjam LEFT JOIN (SELECT no_anggota, nama FROM anggota) as agt ON pinjam.kode_peminjam = agt.no_anggota INNER JOIN (SELECT kode, judul, images FROM buku) as bk ON pinjam.kode_buku = bk.kode WHERE pinjam.id = '$id' ORDER BY date_start");

                while ($pinjaman = mysqli_fetch_array($semua_pinjaman)) {
                    $id = $pinjaman['id'];
                    $kode_peminjam = $pinjaman['kode_peminjam'];
                    $kode_buku = $pinjaman['kode_buku'];
                    $tenggat = $pinjaman['tenggat'];
                    $denda = $pinjaman['denda'];
                    $total_denda = $pinjaman['total_denda'];
                    $date_start = $pinjaman['date_start'];
                    $date_end = $pinjaman['date_end'];
                    $lunas = $pinjaman['lunas'];
                    $nama = $pinjaman['nama'];
                    $judul = $pinjaman['judul'];
                    $images = $pinjaman['images'];

                    if ($lunas === "1") {
                        $lunas = "lunas";
                    } else {
                        $lunas = "belum";
                    }

                    echo '<main>';
                        echo '<section class="image">';
                            echo '<img src="/web-perpus/uploads/buku/'.$images.'" alt="'.$judul.'" onclick="imgClick(this.src)">';
                        echo '</section>';
                        echo '<section class="info">';
                            echo '<article>';
                                echo '<h1>Peminjaman oleh '.$nama.'</h1>';
                                echo '<p>Peminjam: '.$nama.'</p>';
                                echo '<p>Kode Peminjam: '.$kode_peminjam.'</p>';
                                echo '<p>Judul Buku: '.$judul.'</p>';
                                echo '<p>kode buku: '.$kode_buku.'</p>';
                                if ($lunas === "belum") {
                                    echo '<p>lunas: <span style="color:red;font-size: 1.3rem;">'.$lunas.'</span></p>';
                                } else {
                                    echo '<p>lunas: <span style="color:green;font-size: 1.3rem;">'.$lunas.'</span></p>';
                                }
                                echo '<p>total denda: <span style="color:red;font-size: 1.3rem;">'.$total_denda.'</span></p>';
                                echo '<p>mulai pinjam: '.$date_start.'</p>';
                                echo '<p>tenggat hari pengembalian: '.$date_end.'</p>';
                                echo '<p>tenggat pengembalian: '.$tenggat.' hari sejak '.$date_start.'</p>';
                                echo '<p>denda: <span style="color:red;font-size: 1.3rem;">'.$denda.'</span> per hari sejak hari pertama keterlambatan</p>';
                            echo '</article>';

                            echo '<div class="action">';
                                echo '<button class="back" onclick="back()">back</button>';
                                if ($lunas === "belum") {
                                    echo '<button class="kembali" onclick="kembali(`'.$id.'`)">mengembalikan buku</button>';
                                } else {
                                    echo '<a href="/web-perpus/action/pinjam/delete.php?id='.$id.'" style="height:100%;display:inherit;"><button class="delete">Hapus</button></a>';
                                }
                            echo '</div>';
                        echo '</section>';
                    echo '</main>';
                }
            } 
                
            echo mysqli_error($mysqli);
        }

    ?>

    <section class="modal-container hidden">
        <img src="" class="modal-img" >
    </section>

    <script>
        function imgClick(src) {
            const modalContainer = document.querySelector(".modal-container")
            const modalImg = document.querySelector(".modal-img")
            
            modalImg.src = src
            modalContainer.classList.remove("hidden")
            
            modalImg.addEventListener("click", () => {
                modalContainer.classList.add("hidden")
            })
        }

        function back() {
            window.history.back()
        }

        function kembali(id) {
            location.replace("/web-perpus/action/pinjam/kembali.php?id=" + id)
        }
    </script>
</body>
</html>