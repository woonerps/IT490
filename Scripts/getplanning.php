
<!DOCTYPE html>
<html>
<head>
</head>
<body>

    <?php
        $houres=array();
        $groupe=$_GET['groupe'];
        $date=$_GET['date'];
        require_once('Controllers/groupe_controller.php');
        $data=getPlanning($groupe,$date);
        echo json_encode($data);
    ?>
</body>
</html> 