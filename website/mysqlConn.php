<?php
require 'header.php';
?>
<div class="top-left ">
	<h1>Sesame Software: License Creator v2.0</h1>
</div>
<div class="bottom-left">
	<form action="" method="post">

		<table style="color: white; valign: top" class="left">
			<tr>
				<th valign="top">Account:</th>
				<td><select id='bob' name='account[]' size="8" required>

											
<?php
$servername = "192.168.1.223";
$username = "root";
$password = "R3lational";

// Create connection
$link = new mysqli($servername, $username, $password);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

mysqli_select_db($link, 'licensedb') or die(' Could not select database');

$query = "SELECT * FROM SF_ACCOUNT order by NAMEX";
If ($result = $link->query($query)) {

    /* fetch object array */

    while ($obj = $result->fetch_object()) {
        echo " <option value='$obj->ID'>$obj->NAMEX</option>";
    }
    /* free result set */
    $result->close();
}
$link->close();
/* close connection */
?>

</select></td>
		
		</table>
		</td>
		</tr>
		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
</div>
</div>
<table id="myTable" class="display" style="width: 100%">
		<thead>
			<tr>
				<th>select</th>
				<th>ASSETNUMBER</th>
				<th>NAMEX</th>
				<th>USAGEENDDATE</th>
				<th>QUANTITY</th>
				<th>STANDARDX</th>
				<th>HOSTX</th>
				<th>HOST2</th>
				<th>MAC_ADDRESS1</th>
				<th>MAC_ADDRESS2</th>
			</tr>
		</thead>
		<tbody>

<?php
if (isset($_POST['submit'])) {
    $servername = "192.168.1.223";
    $username = "root";
    $password = "R3lational";
    $Account = $_POST['account'];
    $ret = "";
    foreach ($Account as $selectedOption) {
        
        $ret .= "$selectedOption";
        if (next($Account) == true)
            $ret .= ",";
    }
    $Mysqli = new mysqli($servername, $username, $password);
    // Check connection
    if ($link->connect_error) {
        die("Connection failed: " . $Mysqli->connect_error);
    }

    mysqli_select_db($Mysqli, 'licensedb') or die(' Could not select database');

    $query = "SELECT * from SF_ASSET where accountid ='$ret'";
    If ($result = $Mysqli->query($query)) {

        /* fetch object array */
        while ($obj = $result->fetch_object()) {

            echo "<tr>
                    <td> <input type='checkbox' name='$obj->ASSETNUMBER'> </td>
                    <td>  $obj->ASSETNUMBER </td>
                    <td>  $obj->NAMEX </td>
                    <td>   $obj->USAGEENDDATE </td>
                    <td>   $obj->QUANTITY </td>
                     <td>  $obj->STANDARDX </td>
                   <td>  $obj->HOSTX </td>
                    <td>  $obj->HOST2 </td>
                    <td>  $obj->MAC_ADDRESS1 </td>
                    <td>  $obj->MAC_ADDRESS2 </td>

";
        }
    }
    /* free result set */
    $result->close();


/* close connection */
$Mysqli->close();

}
?>






