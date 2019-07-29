<html>
<head>
<title>License Creator</title>
<link rel="stylesheet" href="lm.css">
</head>
<script type="text/javascript" src="lm.js"></script>
<body>
	<div class="container">

		<img src="White_Papers_Banner.jpg">
		<div class="top-left ">
			<h1>Sesame Software: License Creator v2.0</h1>
		</div>
		<div class="bottom-left">
			<form action="" method="post">
				<input type="radio" onchange="handleChange1();" name="KeyType"
					value="ETL"> ETL <input type="radio" onchange="handleChange1();"
					name="KeyType" value="REPLICATION" checked> Replication<br>
				<table style="color: white;" class="left">
					<tr>
						<td valign="top"><table style="color: white;" class="left">
								<tr>
									<th>host:</th>
									<td><input type="text" name="host" required></td>
								</tr>
								<tr>
									<th>user:</th>
									<td><input type="number" name="user" required></td>
								</tr>
								<tr>
									<th>expire:</th>
									<td><input type="date" name="expire" required></td>
								</tr>
							</table></td>
						<td>
							<table style="color: white; valign: top" class="left">
								<tr>
									<th valign="top">product:</th>
									<td><select id='bob' name='product[]' size="8" required>
											<option value='RJ4Salesforce.Enterprise'>Enterprise</option>
											<option value='RJ4Salesforce.Warehouse'>Warehouse</option>
											<option value='RJ4Salesforce.Basic'>Basic</option>
											<option value='RJ4Salesforce.RTO'>RTO</option>
											<option value='RJ4Pardot.Production'>RJ4Pardot</option>
											<option value='RJ4NetSuite.Enterprise'>RJ4NetSuite</option>
									</select></td>
							
							</table>
						</td>
					</tr>
				</table>
				<input type="submit" name="submit" value="Submit">
			</form>
		</div>




	</div>
	<div>
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
    $ipAdd='192.168.1.4';
    if (isset($_POST['submit'])) {
        $Product = $_POST['product'];
        $ret = "";
        foreach ($Product as $selectedOption) {

            $ret .= "$selectedOption";
            if (next($Product) == true)
                $ret .= ",";
        }
        $data = array(
            'host' => $_POST['host'],
            'user' => $_POST['user'],
            'expire' => $_POST['expire'],
            'product' => trim($ret)
        );

        if ($_POST['KeyType'] == 'ETL') {
            $URL = 'http://'.$ipAdd.':5001/gateway/rest/license/createXmlLicense';
        } else {
            $URL = 'http://'.$ipAdd.':5001/gateway/rest/license/createLicense';
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
        } else {

            echo $obj->message;

            echo "<table border='1' >";
            echo "<tr><th> Key:  </th>";
            echo "<td style='word-wrap: break-word;'>";
            echo $obj->key;
        }
    }

    ?>

</div>
				</td>
			</tr>
		</table>
	</div>

</body>
</html>
