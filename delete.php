<?php
// Удаление
if(isset($_GET["id"]) && !empty($_GET["id"])){
    require_once "config.php";

    $sql = "DELETE FROM news WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Привязка переменных к параметрам подготавливаемого запроса
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        if(mysqli_stmt_execute($stmt)){
            header("location: index.php");
            exit();
        } else{
            echo "Что то пошло не так.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}


