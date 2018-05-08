<?php

    
    $config = include(__DIR__.'/../config.php');
    try 
    {
        $dbh = new PDO('mysql:host=localhost;dbname='.$config['dbname'], $config['username'],$config['password']);
        $cnx = $dbh;
    }
    catch (PDOException $e) 
    {
        print "Error!: " . $e->getMessage() . "<br/>";
    }
    $tit=$_GET['gameid'];
    $sql="SELECT id,title,releaseDate,developper FROM game WHERE title like ?";
    $sth=$cnx->prepare($sql);
    $params = array("%$tit%");
    $sth->execute($params);
    $data=$sth->fetchAll();

    foreach($data as $row)
    {
        echo'<div style="border-bottom:3px double grey;">';
        echo '<h3><a href="addgamefollow.php?id='.$row['id'].'">'.$row['title'].'</a></h3>';
        echo '<p>'.$row['releaseDate'].' - '.$row['developper'].'</p>';
        echo '</div>';
    }
    
?>