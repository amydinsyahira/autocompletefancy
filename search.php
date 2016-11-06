<?php
	/* 
	 * JQuery autocomplete selalu mengirimkan parameter dengan nama "q"
	 * dimana isi dari "q" adalah inputan dari textbox pada file "index.html"
	 * */
	if(isset($_GET['q'])){
		$con = mysqli_connect("localhost","root","your_password","autocomplete");
		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			die();
		}
		
		/* 
		 * parameter "q" harus di-filter minimal dengan mysqli_escape_string 
		 * hanya untuk berjaga-jaga apabila ada inputan dengan karakter khusus
		 * yang error ketika dibaca oleh syntax query MySQL
		 * */
		$param = mysqli_real_escape_string($con, $_GET['q']); 
		
		# lakukan pencarian, tampilkan nama pegawai yang berawalan nilai parameter "q"
		$query = mysqli_query($con, "SELECT * FROM pegawai WHERE nama LIKE '$param%'") or die(mysqli_error());		
		if(mysqli_num_rows($query) > 0){
			$data = array(); # siapkan variable untuk menampung keseluruhan data
			while($row = mysqli_fetch_object($query)){
				$data[] = $row; # input data ke variable array satu per satu baris hasil query
			}
			/*
			 * Variable yang mengandung keseluruhan data dari query lalu di konversi
			 * ke JSON dengan fungsi dari PHP5 "json_encode". Hasil keluaran ini akan 
			 * diterima dan di proses oleh Ajax di plugin autocomplete pada file "index.html"
			 * */
			die(json_encode($data)); 
			/* 
			 * lebih jauh tentang implementasi JSON pada aplikasi Ajax dapat anda lihat di artikel di blog saya
			 * http://chandrajatnika.com/2009/02/implementasi-json-pada-aplikasi-ajax/
			 * */			
		}
	}
?>
