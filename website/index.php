

<html>
<head>
<title>My Shop</title>
<style>
img{

height: 300px;

width: 100%

}
.container {
  position: relative;
  text-align: center;
  color: white;
}

/* Bottom left text */
.bottom-left {
  position: absolute;
  bottom: 8px;
  left: 16px;
}

/* Top left text */
.top-left {
  position: absolute;
  top: 8px;
  left: 30px;
}
/* Top left text */
.left-center {
  position: absolute;
  top: 50%;
  left: 16px;
}
/* Top right text */
.top-right {
  position: absolute;
  top: 8px;
  right: 16px;
}

/* Bottom right text */
.bottom-right {
  position: absolute;
  bottom: 8px;
  right: 16px;
}

/* Centered text */
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
/* Centered text */
.top_centered{
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.left{
	text-align: left;
}
.center{
	text-align: center;
}
</style>
</head>
<script>

function handleChange1(){
var etl = {
    'RJ.ETL' : 'basic',
    'RJ.ETL.jdbc' : 'JDBC',
    'RJ.ETL.report' : 'Report',
    'RJ.ETL.driver' : 'Driver',
    'RJ.ETL.fileio' : 'fileio'


};
var rep = {
	'RJ4Salesforce.Enterprise':'Enterprise',
	'RJ4Salesforce.Warehouse':'Warehouse',
	'RJ4Salesforce.Basic':'Basic',
	'RJ4Salesforce.RTO':'RTO',
	'RJ4Pardot.Production':'RJ4Pardot',
	'RJ4NetSuite.Enterprise':'RJ4NetSuite'
};
 


                

                   
							 
							
var select = document.getElementById("bob");
var length = select.options.length;
for (i = 0; i < length; i++) {
select.options[i] = null;
}
	var radios = document.getElementsByName('KeyType');

		for (var i = 0, length = radios.length; i < length; i++)
		{
			if (radios[i].checked)
			{

				if(document.querySelector('input[name="KeyType"]:checked').value=="ETL"){

					
					for(index in etl) {
					    select.options[select.options.length] = new Option(etl[index], index);
					}
				}else{


					for(index in rep) {
					    select.options[select.options.length] = new Option(rep[index], index);
					}				
				}
			break;
			}
		}
}



</script>
<body>
<div class="container">

<img src="White_Papers_Banner.jpg">
<div class="top-left "><h1>Sesame Software: License Creater</h1></div>
		<div  class="bottom-left">		
		<form action="" method="post">
			<input type="radio" onchange="handleChange1();" name="KeyType" value="ETL"> ETL 
			<input type="radio" onchange="handleChange1();" name="KeyType" value="REPLICATION" checked>	Replication<br>
			<table style="color: white;" class="left">

				<tr>
					<th>host:</th>
					<td><input type="text" name="host"></td>
				</tr>
				<tr>
					<th>user:</th>
					<td><input type="text" name="user"></td>
				</tr>
				<tr>
					<th>expire:</th>
					<td><input type="text" name="expire"></td>
				</tr>
				<tr>
					<th>product:</th>
					<td>
               

                    <select id='bob' name='product[]' multiple> 
							  <option value='RJ4Salesforce.Enterprise'>Enterprise</option>
							  <option value='RJ4Salesforce.Warehouse'>Warehouse</option>
							  <option value='RJ4Salesforce.Basic'>Basic</option>
							  <option value='RJ4Salesforce.RTO'>.RTO</option>
							  <option value='RJ4Pardot.Production'>RJ4Pardot</option>
							  <option value='RJ4NetSuite.Enterprise'>RJ4NetSuite</option>
							</select>

                

							
	</td>						
</tr>
			</table>
			<input type="submit" name="submit" value="Submit">
		</form>
</div>

	


</div>
	
	<table>
		
		<tr>
			<td colspan="2">
				<div>


 <?php         

            function json_decode_nice($json, $assoc = TRUE)
            {
                $json = str_replace(array(
                    "\n",
                    "\r"
                ), "\\n", $json);
                $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/', '$1"$3":', $json);
                $json = preg_replace('/(,)\s*}$/', '}', $json);
                return json_decode($json, $assoc);
            }
            if (isset($_POST['submit'])) {
$Product=$_POST['product'];
$ret="";
foreach ( $Product as $selectedOption){

	$ret .= "$selectedOption";
    if (next($Product)==true) $ret .= ",";
         
    		
          
                 }
                $data = array(
                    'host' => $_POST['host'],
                    'user' => $_POST['user'],
                    'expire' => $_POST['expire'],
                    'product' => trim($ret)
                );
		


                if ($_POST['KeyType'] == 'ETL') {
                    $URL = 'http://192.168.1.4:5001/gateway/rest/license/createXmlLicense';
                } else {
                    $URL = 'http://192.168.1.4:5001/gateway/rest/license/createLicense';
                }
                $options = array(
                    'http' => array(
                        'method' => 'POST',
                        'content' => json_encode($data),
                        'header' => "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
                    )
                );

                $context = stream_context_create($options);
                $json = file_get_contents($URL, false, $context);
                $obj = json_decode($json);

                function formatXmlString($xml)
                {
                    $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
                    $token = strtok($xml, "\n");
                    $result = '';
                    $pad = 0;
                    $matches = array();
                    while ($token !== false) :
                        if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
                            $indent = 0;
                         elseif (preg_match('/^<\/\w/', $token, $matches)) :
                            $pad --;
                            $indent = 0;
                         elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
                            $indent = 1;
                        else :
                            $indent = 0;
                        endif;
                        $line = str_pad($token, strlen($token) + $pad, ' ', STR_PAD_LEFT);
                        $result .= $line . "\n";
                        $token = strtok("\n");
                        $pad += $indent;
                    endwhile
                    ;
                    return $result;
                }
		if ($_POST['KeyType'] == 'ETL') {
		        echo "<b>HOST: </b> ";
		        echo $obj->host;
		        echo "  <b>Expiration: </b> ";
		        echo $obj->expire;
		        echo "  <b>Product: </b> ";
		        echo $obj->product;

		        echo "<table border='1' >";
		        echo "<tr><th> Key:  </th>";
			echo "<td style='word-wrap: break-word;'>";
			
				echo "<xmp>";
					echo formatXmlString($obj->key);
				echo "</xmp>";
		}else{

		        echo $obj->message;

		        echo "<table border='1' >";
		        echo "<tr><th> Key:  </th>";
			echo "<td style='word-wrap: break-word;'>";
			echo $obj->key;
		}
		echo  "</td></tr>";
 	  }
            

?>
	
	</table>
	</div>
	</td>
	</tr>
	</table>
</body>
</html>
