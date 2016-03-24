<?php

function deliver_response($response){
	// Define HTTP responses
	$http_response_code = array(
		100 => 'Continue',  
		101 => 'Switching Protocols',  
		200 => 'OK',
		201 => 'Created',  
		202 => 'Accepted',  
		203 => 'Non-Authoritative Information',  
		204 => 'No Content',  
		205 => 'Reset Content',  
		206 => 'Partial Content',  
		300 => 'Multiple Choices',  
		301 => 'Moved Permanently',  
		302 => 'Found',  
		303 => 'See Other',  
		304 => 'Not Modified',  
		305 => 'Use Proxy',  
		306 => '(Unused)',  
		307 => 'Temporary Redirect',  
		400 => 'Bad Request',  
		401 => 'Unauthorized',  
		402 => 'Payment Required',  
		403 => 'Forbidden',  
		404 => 'Not Found',  
		405 => 'Method Not Allowed',  
		406 => 'Not Acceptable',  
		407 => 'Proxy Authentication Required',  
		408 => 'Request Timeout',  
		409 => 'Conflict',  
		410 => 'Gone',  
		411 => 'Length Required',  
		412 => 'Precondition Failed',  
		413 => 'Request Entity Too Large',  
		414 => 'Request-URI Too Long',  
		415 => 'Unsupported Media Type',  
		416 => 'Requested Range Not Satisfiable',  
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',  
		501 => 'Not Implemented',  
		502 => 'Bad Gateway',  
		503 => 'Service Unavailable',  
		504 => 'Gateway Timeout',  
		505 => 'HTTP Version Not Supported'
		);

	// Set HTTP Response
	header('HTTP/1.1 '.$response['status'].' '.$http_response_code[ $response['status'] ]);
	// Set HTTP Response Content Type
	header('Content-Type: application/json; charset=utf-8');
	// Format data into a JSON response
	$json_response = json_encode($response['data']);
	// Deliver formatted data
	echo $json_response;

	exit;
}


// Set default HTTP response of 'Not Found'
$response['status'] = 404;
$response['data'] = NULL;

$url_array = explode('/', $_SERVER['REQUEST_URI']);
array_shift($url_array); // remove first value as it's empty
// remove 2nd and 3rd array, because it's directory
array_shift($url_array); // 2nd = 'NativeREST'
array_shift($url_array); // 3rd = 'api'

// get the action (resource, collection)
$action = $url_array[0];
// get the method
$method = $_SERVER['REQUEST_METHOD'];

require_once("barang.php");
if( strcasecmp($action,'barang') == 0){
	$barang = new Barang();
	if($method=='GET'){
		if(!isset($url_array[1])){ // if parameter idBarang not exist
			// METHOD : GET api/barang
			$data=$barang->getAllBarang();
			$response['status'] = 200;
			$response['data'] = $data;
		}else{ // if parameter idBarang exist
			// METHOD : GET api/barang/:idBarang
			$idBarang=$url_array[1];
			$data=$barang->getBarang($idBarang);
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Barang tidak ditemukan');	
			}else{
				$response['status'] = 200;
				$response['data'] = $data;	
			}
		}
	}
	elseif($method=='POST'){
		// METHOD : POST api/barang
		// get post from client
		$json = file_get_contents('php://input');
		$post = json_decode($json); // decode to object

		// check input completeness
		if($post->namaBarang=="" || $post->kategori=="" || $post->stok=="" || $post->hargaBeli=="" || $post->hargaJual==""){
			$response['status'] = 400;
			$response['data'] = array('error' => 'Data tidak lengkap');
		}else{
			$status = $barang->insertBarang($post->namaBarang, $post->kategori, $post->stok, $post->hargaBeli, $post->hargaJual);
			if($status==1){
				$response['status'] = 201;
				$response['data'] = array('success' => 'Data berhasil disimpan');
			}else{
				$response['status'] = 400;
				$response['data'] = array('error' => 'Terjadi kesalahan');
			}
		}
	}
	elseif($method=='PUT'){
		// METHOD : PUT api/barang/:idBarang
		if(isset($url_array[1])){
			$idBarang = $url_array[1];
			// check if idBarang exist in database
			$data=$barang->getBarang($idBarang);
			if(empty($data)) { 
				$response['status'] = 404;
				$response['data'] = array('error' => 'Data tidak ditemukan');	
			}else{
				// get post from client
				$json = file_get_contents('php://input');
				$post = json_decode($json); // decode to object

				// check input completeness
				if($post->namaBarang=="" || $post->kategori=="" || $post->stok=="" || $post->hargaBeli=="" || $post->hargaJual==""){
					$response['status'] = 400;
					$response['data'] = array('error' => 'Data tidak lengkap');
				}else{
					$status = $barang->updateBarang($idBarang, $post->namaBarang, $post->kategori, $post->stok, $post->hargaBeli, $post->hargaJual);
					if($status==1){
						$response['status'] = 200;
						$response['data'] = array('success' => 'Data berhasil diedit');
					}else{
						$response['status'] = 400;
						$response['data'] = array('error' => 'Terjadi kesalahan');
					}
				}
			}
		}
	}
	elseif($method=='DELETE'){
		// METHOD : DELETE api/barang/:idBarang
		if(isset($url_array[1])){
			$idBarang = $url_array[1];
			// check if idBarang exist in database
			$data=$barang->getBarang($idBarang);
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Data tidak ditemukan');	
			}else{
				$status = $barang->deleteBarang($idBarang);
				if($status==1){
					$response['status'] = 200;
					$response['data'] = array('success' => 'Data berhasil dihapus');
				}else{
					$response['status'] = 400;
					$response['data'] = array('error' => 'Terjadi kesalahan');
				}
			}
		}
	}
}

// Return Response to browser
deliver_response($response);

?>