<?php

include 'base.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    global $conn;
    $data=$_POST['lvl'];
    if (isset($_SESSION['id'])) {
        $sql=$conn->prepare("UPDATE logUsers SET user_data = ? WHERE id = ?");
        if ($sql) {
            $sql->bind_param("ss",$data,$_SESSION['id']);
            if ($sql->execute()) {
            }
        }
    } else if (isset($_SESSION['session_name'])) {
        $data=$_POST['lvl'];
        $table_name=$_SESSION['session_name'];
        $sql="UPDATE `$table_name` SET user_data = ? WHERE user_pseudo = ?";
        $sql=$conn->prepare($sql);
        $sql->bind_param("ss",$data,$_SESSION['pseudo']);
        if ($sql->execute()) {
        }
    }
}
    

?>