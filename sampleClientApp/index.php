
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Sample Client App</title>
	<link href="bootstrap-3.3.51/css/bootstrap.css" rel="stylesheet"/>
</head>

<body>

	<div class="container">
		<br/>

		<?php

		// URL API
		$url = 'http://localhost:8080/NativeREST/api/barang';
		$client = curl_init();
		$options = array(
	    CURLOPT_URL				=> $url, // Set URL of API
	    CURLOPT_CUSTOMREQUEST 	=> "GET", // Set request method
	    CURLOPT_RETURNTRANSFER	=> true, // true, to return the transfer as a string
	    );
		curl_setopt_array( $client, $options );

		// Execute and Get the response
		$response = curl_exec($client);
		// Get HTTP Code response
		$httpCode = curl_getinfo($client, CURLINFO_HTTP_CODE);
		// Close cURL session
		curl_close($client);

		$daftarBarang=null;
		if($httpCode=="200"){ // if success
			$daftarBarang=json_decode($response);
		}else{ // if failed
			$response=json_decode($response);
			echo "<div class='alert alert-danger' style='width:300px;'>Terjadi Kesalahan<br/>".$response->error."</div>";
		}

		?>

		<h1>Data Barang</h1>
		<br/>
		<div class="col-sm-12">
			<a type="button" class="btn btn-primary" href="tambah.php">Tambah Barang</a>
		</div>
		<br/><br/>
		<table class="table" cellspacing="0" width="100%">
			<tr>
				<th>No.</th>
				<th>Nama Barang</th>
				<th>Kategori</th>
				<th>Stok</th>
				<th>Harga Jual</th>
				<th>Harga Beli</th>
				<th>Action</th>
			</tr>
			<?php
			if($daftarBarang!=null){
				$i=1;
				foreach($daftarBarang as $barang){
					echo "<tr>";
					echo "<td>".$i++.".</td>";
					echo "<td>".$barang->namaBarang."</td>";
					echo "<td>".$barang->kategori."</td>";
					echo "<td>".$barang->stok."</td>";
					echo "<td>".$barang->hargaJual."</td>";
					echo "<td>".$barang->hargaBeli."</td>";
					echo "<td>";
					echo "<a class='btn btn-warning btn-sm' href='edit.php?idBarang=".$barang->idBarang."'>EDIT</a> ";
					echo "<a class='btn btn-danger btn-sm' href='hapus.php?idBarang=".$barang->idBarang."'>HAPUS</a> ";
					echo "</td>";
					echo "</tr>";
				}
			}
			?>
		</table>

	</div>
</body>
</html>