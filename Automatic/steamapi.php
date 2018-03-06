<?php
$api_key = "C733CABCDEA284269349EF53D28157F9";
$steamid = "76561198065539419"

<?php

    $api_key = "C733CABCDEA284269349EF53D28157F9";
    $steamid = "76561198065539419";

    $api_url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$steamid";

    $json = json_decode(file_get_contents($api_url), true);

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
