<?php

    require_once('game_controller.php');

    function getGamesByPage($page)
    {
        $cnx=connect();
        $offset=($page-1)*10;
        $sql='SELECT * FROM game  ORDER BY id DESC LIMIT 10 OFFSET '.$offset;
        $stm=$cnx->prepare($sql);
        $stm->execute();
        $games=$stm->fetchAll();
        return $games;
    }


    function getPagesNumber()
    {
        $cnx=connect();
        $total=$cnx->query('SELECT COUNT(*) FROM game')->fetchColumn();
        $limit = 10;
        $pages = ceil($total / $limit);
        return $pages;
    }

    function paginate()
    {
       
    }

?>