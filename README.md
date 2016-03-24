# PHP-RESTful-native
Sample of REST API build with native PHP. <br/>
Use PDO to manipulate MySQL database.<br/>
There also sample of client that access the API.


# setting
#### .htaccess
Configure url in .htacess based with your path
```
RewriteRule ^(.*)$ /nativerest/api/index.php
```
#### client
Configure url in the client code based with API url
```php
$url = 'http://localhost:8080/NativeREST/api/barang';
```

# screenshot 
####1. API
![alt tag](https://raw.githubusercontent.com/marselsampe/PHP-RESTful-native/master/screenshot1_apiGet.png)
<br/><br/>
![alt tag](https://raw.githubusercontent.com/marselsampe/PHP-RESTful-native/master/screenshot2_apiGetDetail.png)
####2. Client
![alt tag](https://raw.githubusercontent.com/marselsampe/PHP-RESTful-native/master/screenshot3_clientGet.png)
<br/><br/>
![alt tag](https://raw.githubusercontent.com/marselsampe/PHP-RESTful-native/master/screenshot3_clientPost.png)
####3. Sample Client App
![alt tag](https://raw.githubusercontent.com/marselsampe/PHP-RESTful-native/master/screenshot4_clientApp.PNG)
