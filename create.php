<?php
// config file
require_once "config.php";

$name = $description = "";
$validation_error = "";

// Обработка данных при отправке формы
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
    if(empty($validation_error)){
        // Добавление данных в бд
        $sql = "INSERT INTO news (name, description) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Привязка переменных к параметрам подготавливаемого запроса
            mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_description);

            // Set parameters
            $param_name = $name;
            $param_description = $description;

            if(mysqli_stmt_execute($stmt)){
                // Данные созданы, редиректим в главное меню.
                header("location: index.php");
                exit();
            } else{
                echo "Что то пошло не так.";
            }
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Создать новость</title>
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
                    <h2>Создать новость</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                    </div>
                    <? if ($validation_error === ""): ?>
                        <div class="errors">
                            <span class="help-block"><?php echo $validation_error; ?></span>
                        </div>
                    <? endif ?>
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>