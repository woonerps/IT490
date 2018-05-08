<?php
    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }
    if(isset($_GET['op']))
    {
        if($_GET['op']=='quite')
            quiteGroup($_GET['id']);
        if($_GET['op']=='delete')
            deleteGroup($_GET['id']);
    }
    if(isset($_POST['i_submit']))   
        sendInvite();

    if(isset($_POST['cg_submit']))
        createGroupe();
    if(isset($_POST['show_submit']))
        refreshPlanning();
    else
    {
        if(isset($_POST['g_houres']))
            addPlanning();
    }
    if(isset($_GET['op']))
        if($_GET['op']=='rfrsh')
            refreshPlanningGet($_GET['id'],$_GET['hrs']);
    if(isset($_GET['op']))
        if($_GET['op']=='invt')
        {
            notificationChecked();
            header('Location:../profile.php');
        }
            
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

    function addPlanning()
    {
        $cnx=connect();
        if(!isset($_SESSION['loggedinUser']))
        {
            header('Location: ../register.php');
            return;
        }
        $user=$_SESSION['loggedinUser'];
        $dateHours=$_POST['g_houres'];
        $groupe=$_POST['g_groupe'];
        $tempDateHours=explode('|',$dateHours);
        $date;
        $hours=array();
        for($i=0;$i<count($tempDateHours);$i++)
        {
            if($i==0)
            {
                $date=$tempDateHours[$i];
            }
            else
            {
                array_push($hours,$tempDateHours[$i]);
            }
        }
        $delet='DELETE FROM planning where planningDate=:pd AND userid=:us AND groupeid=:gr';
        $st=$cnx->prepare($delet);
        $st->bindParam(':gr', $groupe, PDO::PARAM_INT);
        $st->bindParam(':pd', $date, PDO::PARAM_INT);
        $st->bindParam(':us', $user, PDO::PARAM_INT);
        $st->execute();

        $sql='INSERT INTO planning(groupeid ,userid , planningDate) VALUES(:gr,:us,:pd)';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':gr', $groupe, PDO::PARAM_INT);
        $stm->bindParam(':us', $user, PDO::PARAM_INT);
        $stm->bindParam(':pd', $date, PDO::PARAM_STR);
        $stm->execute();

        $q = $cnx->query("SELECT max(id) as 'par' FROM planning")->fetch();

        $planningId=$q['par'];
        
        for ($i=0;$i<count($hours)-1;$i++)
        {
            $sql2='INSERT INTO planninghoure(planningid  ,houre ) VALUES('.$planningId.','.$hours[$i].')';
            $stm2=$cnx->prepare($sql2);
            $stm2->execute();
        }
        if(isset($_SESSION['groupUserPlanning']))
            $_SESSION['groupUserPlanning']=null;

        $msg="planning";
        $planningDate=$date;
        $groupn=getGroupeById($groupe)['name'];
        $groupi=$groupe;
        $users=getGroupUsers($groupi);
        foreach($users as $us)
        {
            $user=$us['userid'];
            if($user!=$_SESSION['loggedinUser'])
                addNotification($msg,$user,$planningDate,$groupn,$groupi);
        }
        refreshPlanningGet($groupe,$date);
    }
    function getUserGroupes($id)
    {
        $cnx=connect();
        $sql="SELECT m.groupeid as 'id' ,g.name as 'name',g.maker as 'maker' FROM groupe g,member m WHERE m.groupeid=g.id AND m.userid=:id";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }

    function getPlanning($groupe,$date)
    {
        $cnx=connect();
        $sql="SELECT ph.houre as 'houre' FROM planning p,planningHoure ph WHERE p.id=ph.planningid AND p.groupeid =:gr AND p.planningDate=:pd AND p.userid=:us";
        $stm->bindParam(':gr',$groupe,PDO::PARAM_INT);
        $stm->bindParam(':pd',$date,PDO::PARAM_STR);
        $stm->bindParam(':us',$_SESSION['loggedinUser'],PDO::PARAM_INT);
        $stm=$cnx->prepare($sql);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }

    function refreshPlanning()
    {
        $groupe=$_POST['g_groupe'];
        $date=$_POST['g_day'];
        $cnx=connect();
        $sql="SELECT ph.houre as 'houre' FROM planning p,planningHoure ph WHERE p.id=ph.planningid AND p.groupeid =:gr AND p.planningDate=:pd AND p.userid=:us";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':gr',$groupe,PDO::PARAM_INT);
        $stm->bindParam(':pd',$date,PDO::PARAM_STR);
        $stm->bindParam(':us',$_SESSION['loggedinUser'],PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        $getUrl=$date;
        foreach($data as $row)
        {
            $getUrl=$getUrl.'|'.$row['houre'];
            //$getUrl=substr($getUrl,1);
        }

        $sql2="SELECT u.username , ph.houre FROM planninghoure ph,planning p,usertable u where ph.planningid=p.id AND u.id=p.userid AND p.groupeid = ".$groupe." AND p.planningDate= '".$date."'";
        $stm2=$cnx->query($sql2);
        $stm2->execute();
        $data2=$stm2->fetchAll();
        if(count($data2)>0)
        {
            $_SESSION['groupUserPlanning']=$data2;
        }
        header('Location:../groupe.php?hrs='.$getUrl.'&id='.$groupe);
    }
    function createGroupe()
    {
        $cnx=connect();
        $sql='INSERT INTO groupe(name,maker) VALUES(:gn,:mk)';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':gn', $_POST['cg_name'], PDO::PARAM_STR);
        $stm->bindParam(':mk', $_SESSION['loggedinUser'], PDO::PARAM_INT);
        $stm->execute();

        $groupeid = $cnx->query("SELECT max(id) as 'par' FROM groupe")->fetch();

        $sql2='INSERT INTO member(userid,groupeid) VALUES(:us,:gr)';
        $stm2=$cnx->prepare($sql2);
        $stm2->bindParam(':gr', $groupeid['par'], PDO::PARAM_INT);
        $stm2->bindParam(':us', $_SESSION['loggedinUser'], PDO::PARAM_INT);
        $stm2->execute();
       
        header('Location:../invitegroup.php?id='.$groupeid['par']);
    }

    function getUserGroupesmk($id)
    {
        $cnx=connect();
        $sql="SELECT id as 'id' ,name FROM groupe WHERE  maker=:id";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }
    function addNotification($msg,$user,$planningDate,$groupn,$groupi)
    {
        $cnx=connect();
        $sql="INSERT INTO notification(message,ndate,userid,checked,pldate,grname,groupid) values(:ms,NOW(),:us,0,:pd,:grn,:gri)";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':ms',$msg,PDO::PARAM_STR);
        $stm->bindParam(':us',$user,PDO::PARAM_INT);
        $stm->bindParam(':pd',$planningDate,PDO::PARAM_STR);
        $stm->bindParam(':grn',$groupn,PDO::PARAM_INT);
        $stm->bindParam(':gri',$groupi,PDO::PARAM_INT);
        $stm->execute();
    }
    function sendInvite()
    {
        $group=$_POST['i_groupe'];
        $user=$_POST['i_username'];
        $cnx=connect();
        if($user!=$_SESSION['loggedinUsername'])
        {
            $sql='SELECT id FROM usertable WHERE username=:us';
            $stm=$cnx->prepare($sql);
            $stm->bindParam(':us', $user, PDO::PARAM_STR);
            $stm->execute();
            $data=$stm->fetchAll();
            if(count($data)>0)
            {
                $sql2='SELECT id FROM invite WHERE userid='.$data[0]['id'].' AND groupeid='.$group;
                $invites = $cnx->query($sql2)->fetch();
                $sql3='SELECT id from member WHERE userid='.$data[0]['id'].' AND groupeid='.$group;
                $members=$cnx->query($sql3)->fetch();
                if(count($invites)>1)
                    header('Location:../invitegroup.php?error=sent&count='.count($invites));
                else if(count($members)>1)
                    header('Location:../invitegroup.php?error=member&count='.count($invites)); 
                else
                {
                    $sql2='INSERT INTO invite(userid,groupeid,invfrom) VALUES(:us,:gr,:fr)';
                    $stm2=$cnx->prepare($sql2);
                    $stm2->bindParam(':gr', $group, PDO::PARAM_INT);
                    $stm2->bindParam(':us', $data[0]['id'], PDO::PARAM_INT);
                    $stm2->bindParam(':fr', $_SESSION['loggedinUser'], PDO::PARAM_INT);
                    $stm2->execute();
                    $msg='invite';
                    $user=$data[0]['id'];
                    $planningDate='';
                    $groupn=getGroupeById($group)['name'];
                    $groupi=$group;
                    addNotification($msg,$user,$planningDate,$groupn,$groupi);
                    header('Location:../invitegroup.php?success=sent');
                }
            }
            else
            {
                header('Location:../invitegroup.php?error=notfount');
            }
        }
        else
        {
            header('Location:../invitegroup.php?error=selftinv');
        }
        
    }
    function refreshPlanningGet($groupe,$date)
    {
        notificationChecked();
        $cnx=connect();
        $sql="SELECT ph.houre as 'houre' FROM planning p,planningHoure ph WHERE p.id=ph.planningid AND p.groupeid =:gr AND p.planningDate=:pd AND p.userid=:us";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':gr',$groupe,PDO::PARAM_INT);
        $stm->bindParam(':pd',$date,PDO::PARAM_STR);
        $stm->bindParam(':us',$_SESSION['loggedinUser'],PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        $getUrl=$date;
        foreach($data as $row)
        {
            $getUrl=$getUrl.'|'.$row['houre'];
            //$getUrl=substr($getUrl,1);
        }

        $sql2="SELECT u.username , ph.houre FROM planninghoure ph,planning p,usertable u where ph.planningid=p.id AND u.id=p.userid AND p.groupeid = ".$groupe." AND p.planningDate= '".$date."'";
        $stm2=$cnx->query($sql2);
        $stm2->execute();
        $data2=$stm2->fetchAll();
        if(count($data2)>0)
        {
            $_SESSION['groupUserPlanning']=$data2;
        }
        header('Location:../groupe.php?hrs='.$getUrl.'&id='.$groupe);
    }
    function notificationChecked()
    {
        $cnx=connect();
        $sql="UPDATE notification set checked=1 where id=:id";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$_GET['not'],PDO::PARAM_INT);
        $stm->execute();
    }
    function quiteGroup($id)
    {
        $cnx=connect();
        $sql='DELETE FROM member WHERE userid =:us AND groupeid=:gr';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':gr', $id, PDO::PARAM_INT);
        $stm->bindParam(':us', $_SESSION['loggedinUser'], PDO::PARAM_INT);
        $stm->execute();
        header('Location:../managegroup.php');
    }
    function deleteGroup($id)
    {
        $cnx=connect();
        $sql='DELETE FROM groupe WHERE id =:gr';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':gr', $id, PDO::PARAM_INT);
        $stm->execute();
        header('Location:../managegroup.php');
    }
    function getGroupeById($id)
    {
        $cnx=connect();
        $sql="SELECT * FROM groupe WHERE id=:id";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data[0];
    }
    function getGroupUsers($grp)
    {
        $cnx=connect();
        $sql="SELECT userid FROM member m WHERE groupeid=:id";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$grp,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }
?>