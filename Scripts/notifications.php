<?php

    function getNotification()
    {
        $cnx=connect();
        $sql='SELECT * from notification where userid='.$_SESSION['loggedinUser'].' AND checked=0';
        $stm=$cnx->prepare($sql);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }
    $notifications=getNotification();
    $color="";
    if(count($notifications)>0)
        $color='style="color:#a31a1a;"';
    echo '<ul class="responsivemenu right" rel="Main Menu">				
        <li><a href="#"><span class="icon-text" '.$color.'>&#128227;<i>,</i></span></a>
            <ul class="sub-menu">';
            if(count($notifications)>0)
            {
                foreach($notifications as $not)
                {
                    if($not['message']=='invite')
                        echo'<li><a href="Controllers/groupe_controller.php?op=invt&not='.$not['id'].'">You have recieved an invite for '.$not['grname'].' at '.$not['ndate'].'</a></li>';
                    else
                        echo'<li><a href="Controllers/groupe_controller.php?op=rfrsh&hrs='.$not['pldate'].'&id='.$not['groupid'].'&not='.$not['id'].'">a planning has been added to '.$not['grname'].' for '.$not['pldate'].'</a></li>';
                }
            }
            else
                echo'<li><a href="#">You have no new notification </a></li>';
    echo '
            </ul>
        </li>	
    </ul>';
?>

