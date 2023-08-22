<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todoList";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




// Add task
if (isset($_POST['title']) && isset($_POST['description'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "INSERT INTO taskdata (title, description, status) VALUES ('$title', '$description', 0)";
    $conn->query($sql);
}

// Update task status
if (isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];
    $sql = "UPDATE taskdata SET status = $status WHERE id = $task_id";
    $conn->query($sql);
}

// Fetch tasks
$sql = "SELECT * FROM taskdata";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Todo List</h1>
        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Task Description</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
        <ul class="list-group mt-3">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li class="list-group-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" <?php if ($row['status']) echo 'checked'; ?>>
                        <label class="form-check-label">
                            <?php echo $row['title']; ?>
                        </label>
                    </div>
                    <p><?php echo $row['description']; ?></p>
                    <form method="POST" action="index.php">
                        <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="status" value="<?php echo $row['status'] ? 0 : 1; ?>">
                        <button type="submit" class="btn btn-secondary btn-sm">Done</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
