<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if(isset($_POST['fu_submit']))
        updateFollow();
    if(isset($_POST['gf_submit']))
        addFollow();
    if(isset($_POST['c_submit']))
        addComment();
    if(isset($_POST['r_submit']))
        addReview();
    if(isset($_GET['op']))
        if($_GET['op']=='deleteGame')
            deleteGame();
    function connect()
    {
        $config = include(__DIR__.'/../config.php');
        try 
        {
            $dbh = new PDO('mysql:host=localhost;dbname='.$config['dbname'], $config['username'],$config['password']);
            return $dbh;
        }
        catch (PDOException $e) 
        {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    }
    function getUserInfoById($id)
    {
        $cnx=connect();
        $sql='SELECT * FROM usertable WHERE id=:id';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }
    function getGames()
    {
        $cnx=connect();
        return $cnx->query('SELECT * FROM game ORDER BY id desc');
    }
    function getGameById($id)
    {
        $cnx=connect();
        $sql='SELECT * FROM game WHERE id=:id';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data[0];
    }
    function getCommentsOfGame($id)
    {
        $cnx=connect();
        $sql='SELECT * FROM comment WHERE gameid=:id';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }
    function checkComment($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return'-The email address is invalid</br>';
        }
        return null;
    }
    function addComment()
    {
        $user=$_SESSION['loggedinUser'];
        $message=$_POST['c_message'];
        $game=$_POST['c_game'];

        if($message!="" && $message!=null)
        {
            $cnx=connect();
            $sql='INSERT INTO comment(gameid,userid,message,addDate) values(:gi,:us,:me,NOW())';
            $stm=$cnx->prepare($sql);
            $stm->bindParam(':gi',$game,PDO::PARAM_INT);
            $stm->bindParam(':us',$user,PDO::PARAM_STR);
            $stm->bindParam(':me',$message,PDO::PARAM_STR);
            $stm->execute();
            header('Location: ../game.php?id='.$game.'&suc=1');
        }
        else
        {
            header('Location: ../game.php?id='.$game.'&error=comment');
        }
    }
    function addReview()
    {
        $gameplay=$_POST['r_gameplay'];
        $graphics=$_POST['r_graphics'];
        $sounds=$_POST['r_sound'];
        $storyline=$_POST['r_storyline'];
        $presentation=$_POST['r_presentation'];
        $game=$_POST['r_game'];

        $cnx=connect();
        $sql='INSERT INTO review(gameid,gameplay,graphics,sounds,storyline,presentation) values(:gi,:gp,:gr,:so,:st,:pr)';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':gi',$game,PDO::PARAM_INT);
        $stm->bindParam(':gp',$gameplay,PDO::PARAM_INT);
        $stm->bindParam(':gr',$graphics,PDO::PARAM_INT);
        $stm->bindParam(':so',$sounds,PDO::PARAM_INT);
        $stm->bindParam(':st',$storyline,PDO::PARAM_INT);
        $stm->bindParam(':pr',$presentation,PDO::PARAM_INT);
        $stm->execute();
        header('Location: ../game.php?id='.$game);
    }
    function getGameReview($id)
    {
        $cnx=connect();
        $sql='SELECT * FROM review WHERE gameid=:id';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        $graphicsAvg=0;$gameplayAvg=0;$soundsAvg=0;$storylineAvg=0;$presentationAvg=0;
        if(count ($data)>0)
        {
            foreach($data as $row)
            {
                $graphicsAvg+=$row['graphics'];
                $gameplayAvg+=$row['gameplay'];
                $soundsAvg+=$row['sounds'];
                $storylineAvg+=$row['storyline'];
                $presentationAvg+=$row['presentation'];
            }
            $graphicsAvg/=count($data);
            $gameplayAvg/=count($data);
            $soundsAvg/=count($data);
            $storylineAvg/=count($data);
            $presentationAvg/=count($data);
    
            $graphicsAvg*=100/5;
            $gameplayAvg*=100/5;
            $soundsAvg*=100/5;
            $storylineAvg*=100/5;
            $presentationAvg*=100/5;
    
            $avg=($graphicsAvg+$gameplayAvg+$soundsAvg+$storylineAvg+$presentationAvg)/5;
            $reviewData= array('graphics' => $graphicsAvg,'gameplay' => $gameplayAvg,'sounds' => $soundsAvg,'storyline' => $storylineAvg,'presentation' => $presentationAvg,'avg' =>$avg);
            return $reviewData;
        }
        return "no reviews";
        
    }

    function getRecentComments()
    {
        
        $cnx=connect();
        $sql='SELECT userid,gameid,message,addDate FROM comment ORDER BY id DESC LIMIT 6';
        $stm=$cnx->prepare($sql);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }
    function getrecentReview()
    {
        $cnx=connect();
        $sql='SELECT * FROM review ORDER BY id DESC LIMIT 9';
        $stm=$cnx->prepare($sql);
        $stm->execute();
        $data=$stm->fetchAll();
        $reviews=array();
        foreach($data as $review)
        {
            $sql2='SELECT title FROM game WHERE id='.$review['gameid'];
            $stm2=$cnx->prepare($sql2);
            $stm2->execute();
            $game=$stm2->fetchAll();
            $title=$game[0]['title'];
            $rev='';

            $grade=($review['graphics']+$review['gameplay']+$review['sounds']+$review['storyline']+$review['presentation'])/5;
            if($grade<1)
                $rev='Terrible';
            else if($grade<2)
                $rev='Bad';
            else if($grade<3)
                $rev='Mediocre';
            else if($grade<4)
                $rev='Good';
            else if($grade<5)
                $rev='Very good';
            else if($grade==5)
                $rev='Master piece';
            $grade*=100/5;
            $tempData=array('title'=>$title,'grade'=>$grade,'review'=>$rev,'gameid'=>$review['gameid']);
            array_push($reviews,$tempData);
        }

        return $reviews;
    }

    function getGameScore($id)
    {
        $score=null;
        $review=getGameReview($id);
        if($review!="no reviews")
            $score=$review['avg'];
        if($score!=null)
            return $score;
        else
            return 0;
    }
    function deleteGame()
    {
        $cnx=connect();
        $sql='DELETE FROM game WHERE id = :id';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
        $stm->execute();
        header('Location:../index.php');
    }
    function getTimeToBeat($id)
    {
        $cnx=connect();
        $sql="SELECT timePlayed as 'timetobeat' FROM gamefollow WHERE gameid=:id AND state='completed'";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        $houre=0;$min=0;$sec=0;
        if(count($data))
        {
            foreach($data as $row)
            {
                $time=explode(':',$row['timetobeat']);
                $houre+=$time[0];
                $min+=$time[1];
                $sec+=$time[2];
            }
            $houre*=3600;
            $min*=60;
            $sec+=$houre+$min;
            $sec/=count($data);
    
            $finalS=$sec;
            $finalM=floor($finalS/60);
            $finalS=$finalS%60;
    
            $finalH=floor($finalM/60);
            $finalM=$finalM % 60;
            $timeRet=array('houre'=>$finalH.'H','min'=>$finalM.'M','sec'=>$finalS.'S');
            return $timeRet;
        }
        return "";
    }

    function addFollow()
    {
        $hour=$_POST['gf_hour'];
        $min=$_POST['gf_min'];
        $sec=$_POST['gf_sec'];
        $platform=$_POST['gf_platform'];
        $state=$_POST['gf_state'];
        $game=$_POST['gf_game'];
        $timePlayed=$hour.':'.$min.':'.$sec;
        $cnx=connect();
        $sql = 'INSERT INTO gamefollow(gameid,userid,state,platform,timeplayed) VALUES(:gm,:us,:st,:pl,:tp)';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':gm',$game,PDO::PARAM_INT);
        $stm->bindParam(':us',$_SESSION['loggedinUser'],PDO::PARAM_INT);
        $stm->bindParam(':st',$state,PDO::PARAM_STR);
        $stm->bindParam(':pl',$platform,PDO::PARAM_STR);
        $stm->bindParam(':tp',$timePlayed,PDO::PARAM_STR);
        $stm->execute();
        header('Location:../profile.php');
    }
    function getGameFollow($id)
    {
        $cnx=connect();
        $sql = 'SELECT * FROM gamefollow WHERE gameid=:game AND userid=:user';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':game',$id,PDO::PARAM_INT);
        $stm->bindParam(':user',$_SESSION['loggedinUser'],PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data[0];
    }
    function updateFollow()
    {
        $hour=$_POST['fu_hour'];
        $min=$_POST['fu_min'];
        $sec=$_POST['fu_sec'];
        $platform=$_POST['fu_platform'];
        $state=$_POST['fu_state'];
        $fgame=$_POST['fu_fg'];
        $timePlayed=$hour.':'.$min.':'.$sec;
        $cnx=connect();
        $sql = 'UPDATE gamefollow SET userid=:us,state=:st,platform=:pl,timeplayed=:tp WHERE id=:id';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$fgame,PDO::PARAM_INT);
        $stm->bindParam(':us',$_SESSION['loggedinUser'],PDO::PARAM_INT);
        $stm->bindParam(':st',$state,PDO::PARAM_STR);
        $stm->bindParam(':pl',$platform,PDO::PARAM_STR);
        $stm->bindParam(':tp',$timePlayed,PDO::PARAM_STR);
        $stm->execute();
        header('Location:../profile.php');
    }
    function getSliderGames()
    {
        $cnx=connect();
        $sql="SELECT g.* ,count(c.id) as 'nbrc' from game g,comment c where c.gameid=g.id group by c.gameid order by nbrc desc";
        $stm=$cnx->prepare($sql);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }
    
?>