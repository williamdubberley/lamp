<?php

error_reporting(E_ERROR | E_PARSE);
// Set maintenance to 1 for normal operation
$maintenance=0;
$proxy = "";
$host = "";
$orgId = "UNKNOWN";
$org = "";
$rel = "";
$sfdcUser = "";
$userFullName = "";
$standardUsers = 0;
$partnerUsers = 0;
$HVPortalUsers = 0;
$portalUsers = 0;
$portalManagerUsers = 0;
$chatterFreeUsers = 0;
$userCount = 0;
$platformUsers = 0;
$userEmail = "";
$licensedUsers = 0;
$expires = "";
$referrer=$_SERVER['REMOTE_HOST'];
$dbms = "";
$assetNumber="";
$dbVersion = "";
$os = "";
$product = "RJ4Salesforce.Enterprise";
$apiServer = "UNKNOWN";
$apiVersion = "UNKNOWN";
$macAddress= "UNKNOWN";
$etlversion = "4.7.0.0123";
$rjversion = "5.3.0.0123";
$queryString = $_SERVER['QUERY_STRING'];
parse_str($queryString);
$startDate = gmdate("Y-m-d");

if ($maintenance != 0) {
    echo "startDate  $startDate old";
    exit;
}

//get blacklist
$blacklist = array();
try{
    if($file_handle = @fopen("blacklist", "r")){
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            $blacklist[] = trim($line);
        }
        fclose($file_handle);
        
    }
}catch(Exception $e){
    //unable to open blacklist file
}
// get a random number between 0 and 3, if it is 0, then true
if(in_array(trim($orgId), $blacklist) && rand(0,1) == 0){
    die ("");
}


if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    if ($_SERVER["HTTP_CLIENT_IP"]) {
        $proxy = $_SERVER["HTTP_CLIENT_IP"];
    }
    else {
        $proxy = $_SERVER["REMOTE_ADDR"];
    } $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else
{
    if ($_SERVER["HTTP_CLIENT_IP"]) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }
}

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
// Connecting, selecting database

$servername = "192.168.1.223";
$username = "root";
$password = "R3lational";

// Create connection
$link = new mysqli($servername, $username, $password);

if (!$link) {
    echo "startDate $startDate old" . PHP_EOL ."<br>";
    echo date(DATE_RFC2822) . " Unable to connect to MySQL. " . mysqli_connect_error() . PHP_EOL;
    $ERRLOG = fopen('userCount.err', 'a');
    fwrite($ERRLOG, date(DATE_RFC2822) . " Unable to connect to MySQL. " . mysqli_connect_error() . PHP_EOL);
    fclose($ERRLOG);
    exit;
}
mysqli_select_db($link,'licensedb') or die(' Could not select database');

// Performing SQL query
$query = "SELECT * FROM SF_LICENSE WHERE ORG_ID = '$orgId' and HOSTX = '$host' and PRODUCT = '$product' and API_SERVER in ('$apiServer','UNKNOWN') ";
$result = mysqli_query($link, $query) or die(' Query failed: ' . mysqli_error() . "\n" . "$query");
$obj = json_decode($result );
echo $obj;
$lastUsed = gmdate("Y-m-d H:i:s");

if (mysqli_num_rows($result) == 0) {
    echo "startDate $startDate new";
    $insert = "INSERT INTO SF_LICENSE (ID, DELETE_FLAG, ORG_ID, IP, PROXY, REFERRER, HOSTX, NAMEX, USER_FULL_NAME, SALESFORCE_USER, USER_EMAIL, PRODUCT, PRODUCT_RELEASE, ACTIVE_USERS, PLATFORM_USERS, START_DATE, LAST_USED, LICENSED_USERS, DBMS, DATABASE_VERSION, OPERATING_SYSTEM, API_SERVER, API_VERSION, MAC_ADDRESS,STANDARDX,PARTNER,HIGH_VOLUME_PORTAL,CUSTOMER_PORTAL_USER,CUSTOMER_PORTAL_MANAGER,CHATTER_FREE,ASSET_NUMBER)";
    $insert .= " values (substring(CONCAT('X-', CAST(rand() AS CHAR),'1234567890123456789'), 1,18), 'I', '$orgId', '$ip', '$proxy', '$referrer', '$host', '$org', '$userFullName', '$sfdcUser', '$userEmail', '$product', '$rel', $userCount, $platformUsers, '$startDate', '$lastUsed', $licensedUsers, '$dbms', '$dbVersion', '$os', '$apiServer', '$apiVersion', '$macAddress', '$standardUsers', '$partnerUsers', '$HVPortalUsers', '$portalUsers', '$portalManagerUsers', '$chatterFreeUsers', '$assetNumber') ";
    $LOG = fopen('userCount.log', 'a');
    fwrite($LOG, "$insert \n");
    fclose($LOG);
    #mysqli_query($link, $insert) or die(' Insert failed: ' . mysqli_error($link)  . " - " . mysqli_getCode($link) . " - " . mysqli_getMessage($link) . "\n" . "$insert");
    #mysqli_query($link, $insert) or die(' Insert failed: ' . mysqli_getMessage($link) . "\n" . "$insert");
    #mysqli_query($link, $insert) or die(' Insert failed: ' . mysqli_error() . "\n" . "$insert");
    if (!mysqli_query($link, $insert) === TRUE) {
        printf("\nError: %s\n", mysqli_error($link) . " $insert");
        mysqli_close($link);
        exit;
    }
    mysqli_commit($link);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $startDate = $row["START_DATE"];
        $startDate = substr($startDate, 0, 10);
        
        if ($licensedUsers <= 0) {
            $licensedUsers = $row["LICENSED_USERS"];
        }
        echo "startDate  $startDate old";
    }
    $update = "UPDATE SF_LICENSE set DELETE_FLAG = 'U', PROXY = '$proxy', REFERRER = '$referrer', STANDARDX ='$standardUsers',PARTNER =  '$partnerUsers', HIGH_VOLUME_PORTAL = '$HVPortalUsers',CUSTOMER_PORTAL_USER = '$portalUsers',CUSTOMER_PORTAL_MANAGER = '$portalManagerUsers',CHATTER_FREE = '$chatterFreeUsers',ASSET_NUMBER = '$assetNumber', HOSTX = '$host', NAMEX = '$org', USER_FULL_NAME = '$userFullName', SALESFORCE_USER = '$sfdcUser', USER_EMAIL = '$userEmail', PRODUCT_RELEASE = '$rel', ACTIVE_USERS = $userCount, PLATFORM_USERS = $platformUsers, LICENSED_USERS = $licensedUsers, LAST_USED = '$lastUsed', DBMS = '$dbms', DATABASE_VERSION = '$dbVersion', OPERATING_SYSTEM = '$os', API_SERVER = '$apiServer', API_VERSION = '$apiVersion', MAC_ADDRESS = '$macAddress' where ORG_ID = '$orgId' and HOSTX = '$host' and PRODUCT = '$product' and API_SERVER in ('$apiServer','UNKNOWN') and DELETE_FLAG in ('U','N') ";
    mysqli_query($link, $update) or die(' Update failed: ' . mysqli_error() . "\n" . "$update");
    mysqli_commit($link);
}

// Free resultset
mysqli_free_result($result);

// Closing connection
mysqli_close($link);
?>