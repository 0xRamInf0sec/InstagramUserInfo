<html>
<head>
<title>Insta Users Details</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style>
.jumbotron {
 background-color:transparent;
  margin: 5px auto;
  height:500px;
  justify-content: center;
padding:0;
}

.bg-cover {
    background-attachment: static;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
input[type=submit] {
  background-color:#f4253e;
  color: white;
  position: 10px 100 px;
  padding: 6px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: center;
}
.text-line {
    background-color: transparent;
    color:solid #000000;
    outline: none;
    outline-style: none;
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: solid #000000 1px;
    padding: 3px 10px;
}
.text-line:focus
{
	    background-color: transparent;
}
</style>
<body >
<div class="jumbotron bg-cover" style="width:50%;">
<div style='background-color:#436cee;padding:30px;text-align:center'>
  <h3 style='color:white'>Instagram User Data Extractor</h3>
  <h5 style="float:right;color:white">by Ramalingasamy M K</h5>
  </div>
  <br>
<form action="<?php 
         echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

<div class="form-group">
<label for="Consumer_number :"><b>Enter Name</b></label>
<input type="text" name="name" placeholder="Username" class="text-line" required="">
</div>
<div class="form-group">
<input type="submit" name="form" value="Check" >
</div>
</form>
<div>
<?php
			 if ($_SERVER["REQUEST_METHOD"] == "POST") {

               $User= test_input($_POST["name"]);
			  
            }
		function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
         }
		 if(isset($_POST['form']))
		 {
		 $curl=curl_init();
		 curl_setopt_array($curl,array(
		 CURLOPT_URL => "https://www.instagram.com/".$User."/?__a=1",
		  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: cc3e7f07-b49c-4040-b511-c7f1af596954"
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} 
else 
{
  $data=json_decode($response,true);
  $proid=$data['logging_page_id'];
  $bio=$data['graphql']['user']['biography'];
  $url=$data['graphql']['user']['external_url'];
  $followedby=$data['graphql']['user']['edge_followed_by']['count'];
  $followed=$data['graphql']['user']['edge_follow']['count'];
  $private=$data['graphql']['user']['is_private'];
  $propic=$data['graphql']['user']['profile_pic_url_hd'];
  $post=$data['graphql']['user']['edge_owner_to_timeline_media']['count'];
  if(!isset($proid) && !isset($bio) && !isset($url) && !isset($followedby) && !isset($followed) && !isset($private) && !isset($propic)
	  && !isset($post))
	  {
		  echo '<b>No data Found </b><br>';
	  }
	  else{
  echo '<h3>Results For User '.$User.'</h3>';
  echo '<img src='.$propic.'><br>';
  echo '<b>Profile ID : </b>'.$proid.'<br>';
  echo '<b>Description : </b>'.$bio.'<br>';
  if(isset($url))
  {
  echo '<b>URL given in Description : </b><a href='.$url.' target=__blank>Link</a><br>';
  }
  else 
  {
	  echo '<b>There is No link in Description was found</b><br>';
  }
  echo '<b>Followers : </b>'.$followedby.'<br>';
  echo '<b>He/she Follows : </b>'.$followed.'<br>';
  if($private==1)
  {
	  echo 'The Account is <b>Private</b><br>';
  }
  else
  {
	  echo 'The Account is <b>Public</b><br>';
  }
  
  echo '<b>Posts Posted : </b>'.$post;
}
		 }	 }
?>
</div>
</body>
</html>