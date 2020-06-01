<?php
require_once "config.php";

$name = $description = "";
$validation_error = "";

if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

    // Валидация
    $input_name = trim($_POST["name"]);
    $input_description = trim($_POST["description"]);
    if(empty($input_name) || empty($input_description)){
        $validation_error = "Поля не могут быть пустыми";
    } else{
        $name = $input_name;
        $description = $input_description;
    }

    // Проверка на наличие ошибок!
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Редактирование данных в бд
        $sql = "UPDATE news SET name=?, description=? WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Привязка переменных к параметрам подготавливаемого запроса
            mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_description, $param_id);

            // Set parameters
            $param_name = $name;
            $param_description = $description;
            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else{
                echo "Что то пошло не так.";
            }
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
} else{
    // Проверка на наличие данных по ID
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Подготовка запроса
        $sql = "SELECT * FROM news WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Привязка переменных к параметрам подготавливаемого запроса
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $name = $row["name"];
                    $description = $row["description"];
                } else{
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Что то пошло не так.";
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Редактирование</h2>
                </div>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>