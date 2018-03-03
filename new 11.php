<?php
$api = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=C733CABCDEA284269349EF53D28157F9&steamids=76561198065539419";

$json = file_get_contents($api);

$decoded = json_decode($json);

print_r($decoded->{'response'}->{'players'}->{'steamid'});
?>

<html>
<head>
<title>Profile Info</title>
<body>
<form method = "post" action="<?PHP_SELF;?>">
api:<input type="text"  name="api"><br/>
json: <input type="text" name="json"><br/>
decoded: <input type = "text" name = "decoded">< br/>
</form>

<?
echo ".$api." ".$json." ".$decoded.".<br />";
?>