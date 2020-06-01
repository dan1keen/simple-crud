<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="float-left">Новости</h2>
                    <a href="create.php" class="btn btn-success float-right mb-1">Добавить новость</a>
                </div>
                <?php
                // Config file
                require_once "config.php";

                // Запрос
                $sql = "SELECT * FROM news";
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Название</th>";
                        echo "<th>Описание</th>";
                        echo "<th>Действие</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>";
                            echo "<a href='update.php?id=". $row['id'] ."' title='Update'>Редактировать</a>";
                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete' class='ml-1'>Удалить</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Освобождаем память
                        mysqli_free_result($result);
                    } else{
                        echo "<p class='lead'><em>Новости не найдены.</em></p>";
                    }
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }

                // Закрываем соединение.
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>