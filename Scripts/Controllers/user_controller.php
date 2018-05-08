<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST['l_submit']))
        login($_POST['username'],$_POST['password']);
    if(isset($_POST['c_submit']))
        subContact();
    if(isset($_POST['r_submit']))
        register();
    if(isset($_POST['p_submit']))
        modify (0);
    if(isset($_POST['a_submit']))
        modify (1);
    if(isset($_POST['g_submit']))
        addGame ();
    if(isset($_GET['inv']))
        {
            if($_GET['inv']=='invite-refuse')
                refuseInvite($_GET['id']);
            if($_GET['inv']=='invite-accept')
                acceptInvite($_GET['id']);
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

    function getAllUsers()
    {
        $tdbh=connect();
        return $tdbh->query('SELECT id ,username ,password,email FROM usertable');
    }

    function checkLogin($username,$password)
    {
        $allUsers=getAllUsers();

        foreach ($allUsers as $row):
            if($row['username']==$username)
            {
                if(password_verify ($password ,$row['password']))
                {
                    return $row['id'];
                }
            }
        endforeach;
        return null;
    }

    function checkResiterInfo($username,$password,$confPassword,$email)
    {
        $allUsers=getAllUsers();
        $errors='';
        foreach ($allUsers as $row):
            if($row['username']==$username)
            {
                $errors=$errors.'-Username already exists</br>';
            }
            if($row['email']==$email)
            {
                $errors=$errors.'-Email already exists</br>';
                break;
            }
        endforeach;
        
        if(strlen($password)<6)
        {
            $errors=$errors.'-Password should be at least 6 characters</br>';
        }
        if($password != $confPassword)
        {
            $errors=$errors.'-Password and confirm password did not match</br>';
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors=$errors.'-The email address is invalid</br>';
        }
        return $errors;
    }

    function addUser($username,$password,$email)
    {
        $cnx=connect();
        $sql='INSERT INTO usertable(username,password,email) values(:un,:pw,:em)';
        $sth=$cnx->prepare($sql);
        $sth->bindParam(':un', $username, PDO::PARAM_STR);
        $sth->bindParam(':pw', $password, PDO::PARAM_STR);
        $sth->bindParam(':em', $email, PDO::PARAM_STR);
        $sth->execute();
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

    function updateProfile($email,$name,$lastname,$gender,$bio,$steamid,$avatar)
    {
        $cnx=connect();
        $sql ='UPDATE usertable set email=:em ,name=:nm ,lastname =:ln ,gender =:gn ,bio =:bi ,steamid =:si,avatar=:av WHERE id ='.$_SESSION['loggedinUser'];
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':em', $email, PDO::PARAM_STR);
        $stm->bindParam(':nm', $name, PDO::PARAM_STR);
        $stm->bindParam(':ln', $lastname, PDO::PARAM_STR);
        $stm->bindParam(':gn', $gender, PDO::PARAM_STR);
        $stm->bindParam(':bi', $bio, PDO::PARAM_STR);
        $stm->bindParam(':si', $steamid, PDO::PARAM_STR);
        $stm->bindParam(':av', $avatar, PDO::PARAM_STR);
        $stm->execute();
    }

    function updateAccount($username,$newpassword,$confpassword,$oldpassword)
    {
        $allUsers=getAllUsers();
        $userOldData=getUserInfoById($_SESSION['loggedinUser']);
        $errors="";
        foreach ($allUsers as $row):
            if($row['username']==$username && $_SESSION['loggedinUser']!=$row['id'])
            {
                $errors=$errors.'-Username already exists</br>';
                break;
            }
            if($_SESSION['loggedinUser']==$row['id'])
            {
                if(!password_verify($oldpassword ,$row['password']))
                {
                    $errors=$errors."-Old password is wrong </br>";
                }
                if(password_verify($newpassword ,$row['password']))
                {
                    $errors=$errors."-New password cant be the old password </br>";
                }
            }
        endforeach;
        
        if($newpassword!=$confpassword)
        {
            $errors=$errors."-Password and confirm password did not match </br>";
        }
        if(strlen($newpassword)<6)
        {
            $errors=$errors."-Password should be at least 6 characters </br>";
        }
        if($errors=="")
        {
            $cnx=connect();
            $sql ='UPDATE usertable set username=:un ,password=:pw WHERE id ='.$_SESSION['loggedinUser'];
            $stm=$cnx->prepare($sql);
            $stm->bindParam(':un', $username, PDO::PARAM_STR);
            $options = ['cost' => 12];
            $encryptedpw=password_hash($newpassword, PASSWORD_DEFAULT, $options);
            $stm->bindParam(':pw', $encryptedpw, PDO::PARAM_STR);
            $stm->execute();
            $_SESSION['loggedinUsername']=$username;
            header('Location: ../profile.php?id='.$_SESSION['loggedinUser'].'&success=suc');
        }
        else
        {
            $_SESSION['accountError']=$errors;
            header('Location: ../profile.php?id='.$_SESSION['loggedinUser'].'&error=aerror');
        }
    }
    function fileStatus($imageFileType,$size)
    {
        $errors="";

        if ($size > 5000000) 
        {
            $errors= "Sorry, your file is too large.</br>";
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
        {
            $errors=$errors. "Sorry, only JPG, JPEG, PNG & GIF files are allowed.</br>";
        }
        return $errors;
    }

    function uploadAvatar()
    {
        $file=$_FILES["p_avatar"];
        $target_dir = __DIR__.'/../uploads/avatars/';
        $temp = explode(".", $file["name"]);
        $newfilename = $_SESSION['loggedinUser'] . '.' . end($temp);
        $target_file = $target_dir . $newfilename;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $errors=fileStatus($imageFileType,$file["size"]);
        if ($errors != "") 
        {
            $_SESSION['avatarError']=$errors;
            header('Location: ../profile.php?id='.$_SESSION['loggedinUser'].'&error=avatar');
        }
        else 
        {
            if (move_uploaded_file($file["tmp_name"], $target_file)) 
            {
                return $newfilename;
            } 
            else 
            {
                $errors=$errors. "Sorry, there was an error uploading your file.";
                $_SESSION['avatarError']=$errors;
                header('Location: ../profile.php?id='.$_SESSION['loggedinUser'].'&error=avatar');
            }
        }
    }
    function modify ($operation)
    {
        if($operation==0)
        {
            $email=$_POST['p_email'];
            $name=$_POST['p_name'];
            $lastname=$_POST['p_lastname'];
            $gender="";
            if(isset($_POST['p_gender']))
                $gender=$_POST['p_gender'];
            $bio=$_POST['p_bio'];
            $steamid=$_POST['p_steamid'];
            $avatar=uploadAvatar();
            updateProfile($email,$name,$lastname,$gender,$bio,$steamid,$avatar);
            
            header('Location: ../profile.php?id='.$_SESSION['loggedinUser']);
        }
        if($operation==1)
        {
            $username=$_POST['a_username'];
            $newpassword=$_POST['a_newpassword'];
            $confpassword=$_POST['a_confpassword'];
            $oldpassword=$_POST['a_oldpassword'];
            updateAccount($username,$newpassword,$confpassword,$oldpassword);
        }
    }
    function clean($string) {
        $string = str_replace(' ', '', $string); 
     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
     }
    function uploadCover($title)
    {
        $file=$_FILES["g_cover"];
        $target_dir = __DIR__.'/../uploads/covers/';
        $temp = explode(".", $file["name"]);
        $title=clean($title);
        $newfilename = $title . '.' . end($temp);
        $target_file = $target_dir . $newfilename;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $errors=fileStatus($imageFileType,$file["size"]);
        if ($errors != "") 
        {
            $_SESSION['coverError']=$errors;
            header('Location: ../addgame.php?id='.$_SESSION['loggedinUser'].'&error=avatar');
        }
        else 
        {
            if (move_uploaded_file($file["tmp_name"], $target_file)) 
            {
                return $newfilename;
            } 
            else 
            {
                $errors=$errors. "Sorry, there was an error uploading your file.";
                $_SESSION['avatarError']=$errors;
                header('Location: ../addgame.php?id='.$_SESSION['loggedinUser'].'&error=avatar');
            }
        }
    }
    function login($username,$password)
    {
        $loginId = checkLogin($username,$password);
        if($loginId != null)
        {
            $_SESSION['loggedinUser']=$loginId;
            $_SESSION['loggedinUsername']=$username;
            header('Location: ../index.php');
        }
        else
            header('Location: ../register.php?error=logEr');
    }

    function register()
    {
        $username=$_POST['r_username'];
        $password=$_POST['r_password'];
        $confPassword=$_POST['r_confpassword'];
        $email=$_POST['r_email'];

        $registerInfoState=checkResiterInfo($username,$password,$confPassword,$email);

        if($registerInfoState=='')
        {
            $options = ['cost' => 12];
            $encryptedPW=password_hash($password, PASSWORD_DEFAULT, $options);
            addUser($username,$encryptedPW,$email);
            login($username,$password);
        }
        else
        {
            $_SESSION['registerError']=$registerInfoState;
            header('Location: ../register.php?error=regEr');
        }
            
    }
    
    function addGame()
    {
        $title=$_POST['g_title'];
        $description=$_POST['g_description'];
        $tags=$_POST['g_tags'];
        $developper=$_POST['g_developper'];
        $releaseDate=$_POST['g_release'];
        $cover=uploadCover($title);
        $cnx=connect();
        $sql ='INSERT INTO game(title,description,tags,cover,author,releaseDate,developper) VALUES(:ti,:ds,:tg,:co,:au,:rd,:de)';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':ti', $title, PDO::PARAM_STR);
        $stm->bindParam(':ds', $description, PDO::PARAM_STR);
        $stm->bindParam(':tg', $tags, PDO::PARAM_STR);
        $stm->bindParam(':co', $cover, PDO::PARAM_STR);
        $stm->bindParam(':au', $_SESSION['loggedinUser'], PDO::PARAM_INT);
        $stm->bindParam(':rd', $releaseDate, PDO::PARAM_STR);
        $stm->bindParam(':de', $developper, PDO::PARAM_STR);
        $stm->execute();
        header('Location: ../blog.php');
    }

    function getInvites()
    {
        $cnx=connect();
        $sql="SELECT i.id as 'id',g.name as 'groupname',u.username as 'username' FROM invite i,groupe g,usertable u WHERE i.invfrom=u.id AND i.groupeid=g.id AND userid=:id";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$_SESSION['loggedinUser'],PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }

    function acceptInvite($id)
    {
        $cnx=connect();
        $sql="SELECT userid,groupeid FROM invite WHERE id=:id";
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        $sql2='INSERT INTO member(userid,groupeid) VALUES(:us,:gr)';
        $stm2=$cnx->prepare($sql2);
        $stm2->bindParam(':us',$data[0]['userid'],PDO::PARAM_INT);
        $stm2->bindParam(':gr',$data[0]['groupeid'],PDO::PARAM_INT);
        $stm2->execute();

        refuseInvite($id);
        //header('Location:../profile.php?id='.$_SESSION['loggedinUser']);
    }
    function refuseInvite($id)
    {
        $cnx=connect();
        $sql='DELETE FROM invite where id= :id';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':id',$id,PDO::PARAM_INT);
        $stm->execute();
        header('Location:..///profile.php?id='.$_SESSION['loggedinUser']);
    }
    function getFollowedGames($id)
    {
        $cnx=connect();
        $sql = 'SELECT fg.id, gameid,title,timeplayed,state,fg.gameid FROM gamefollow fg,game g WHERE fg.gameid=g.id AND userid=:us';
        $stm=$cnx->prepare($sql);
        $stm->bindParam(':us',$id,PDO::PARAM_INT);
        $stm->execute();
        $data=$stm->fetchAll();
        return $data;
    }
    function subContact()
    {
        $email=$_POST['c_email'];
        $cnx=connect();
        $sql='INSERT into contactmessages(nickname,email,message) values(:nk,:em,:ms)';
        $stm=$cnx->prepare($sql);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            header('Location:../contact.php?error=eml');
        }
        else
        {
            $stm->bindParam(':nk',$_POST['c_name'],PDO::PARAM_STR);
            $stm->bindParam(':em',$email,PDO::PARAM_STR);
            $stm->bindParam(':ms',$_POST['c_message'],PDO::PARAM_STR);
            $stm->execute();
            header('Location:../contact.php?suc=1');
        }
    }
?>