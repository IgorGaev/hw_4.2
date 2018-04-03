<?php
include_once 'database.php';
if (!empty($_POST)) {
    $description = strip_tags($_POST['description']);
    $date_added = $_POST['date'];

    $pdo->exec("INSERT INTO tasks(description,date_added) "
            . "VALUES ('$description', '$date_added')");
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $pdo->exec("DELETE FROM tasks WHERE id='$id'");
}
?>
<h1>Список дел на сегодня</h1>

<form method="POST" >
    <input type="text" name="description" placeholder="Описание задачи">
    <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>">
    <input type="submit" value="Добавить">
</form>

<div style="clear: both"></div>
<style>
    table { 
        border-spacing: 0;
        border-collapse: collapse;
    }

    table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
    }

    table th {
        background: #eee;
    }
</style>
<table border="1">
    <thead>
        <tr>
            <th>Описание задачи</th>
            <th>Дата добавления</th>
            <th>Статус</th>
            <th>Действие</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pdo->query("SELECT * FROM tasks") as $row) : ?>
            <tr>
                <td><?= $row['description'] ?></td>
                <td><?= $row['date_added'] ?></td>
                <td><?= ($row['is_done'] == 0) ? 'Выполнено' : 'В процессе'; ?></td>
                <td>
                    <a>Выполнить</a>
                    <a href='index.php?id=<?= $row['id'] ?>'>Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>        
    </tbody>
</table>


