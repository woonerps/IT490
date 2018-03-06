<?php
    $api_key = "362A5E75C799470C96F131181C7AB807";
    $steamid = "76561198065539419";
    $api_url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$steamid";
    $json = json_decode(file_get_contents($api_url), true);
	echo $json_decoded->response->players[0]->lastlogoff;
    $join_date = date("D, M j, Y", $json["response"]["players"][0]["timecreated"]);
 function personaState($state)
    {
        if ($state == 1)
        {
            return "Online";
        }
        elseif ($state == 2)
        {
            return "Busy";
        }
        elseif ($state == 3)
        {
            return "Away";
        }
        elseif ($state == 4)
        {
            return "Snooze";
        }
        elseif ($state == 5)
        {
            return "Looking to trade";
        }
        elseif ($state == 6)
        {
            return "Looking to play";
        }
        else
        {
            return "Offline";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
    <body>
        <h1><?=$json["response"]["players"][0]["personaname"];?></h1>
        <img src="<?=$json["response"]["players"][0]["avatarfull"];?>">
        <ul>
            <li>SteamID: <?=$json["response"]["players"][0]["steamid"];?></li>
            <li>Display Name: <?=$json["response"]["players"][0]["personaname"];?></li>
            <li><a href=http://steamcommunity.com/profiles/76561198065539419>URL: <?=$json["response"]["players"][0]["profileurl"];?></a></li>
            <li>Small Avatar: <?=$json["response"]["players"][0]["avatar"];?></li>
            <li>Medium Avatar: <?=$json["response"]["players"][0]["avatarmedium"];?></li>
            <li>Full Avatar: <?=$json["response"]["players"][0]["avatarfull"];?></li>
            <li>Status: <?=personaState($json['response']['players'][0]['personastate']);?></li>
            <li>Real Name: <?=$json["response"]["players"][0]["realname"];?></li>
            <li>Joined: <?=$join_date;?></li>
        </ul>
    </body>
</html>
