<!DOCTYPE html>

<?php include 'models/db.php';

$sql = "select * from task";

$rows = $db->query($sql);

?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management</title>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
<body>
  <div class="container">
    <div class="column">
      <h1>Tasks</h1>

      <div class="row" style="margin-top: 70px;">
        <div class="col-md-10 col-md-offset-1">
          <table class="table">
            <button type="button" data-target="#addTask" data-toggle="modal" class="btn btn-success">Add Task</button>
            <button type="button" class="btn btn-default">Print</button>
            <hr>
            <p>filteri</p>

            <div id="addTask" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <?php include 'views/tasks/add.php'; ?>
              </div>
            </div>

            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Title</th>
                  <th scope="col">Description</th>
                  <th scope="col">Status</th>
                  <th scope="col">Priority</th>
                  <th scope="col">Due date</th>
                  <th scope="col">Project</th>
                  <th scope="col">Created by</th>
                  <th scope="col">Assigned to</th>
                  <th scope="col">Created at</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php while($row = $rows->fetch_assoc()): ?>
                  <tr>
                    <td scope="row"><?php echo $row['id'] ?></td>
                    <td class="col-md-10"><?php echo $row['title'] ?></td>
                    <td class="col-md-10"><?php echo $row['description'] ?></td>
                    <td scope="row"><?php echo $row['status'] ?></td>
                    <td scope="row"><?php echo $row['priority'] ?></td>
                    <td scope="row"><?php echo $row['due_date'] ?></td>
                    <td scope="row"><?php echo $row['project_id'] ?></td>
                    <td scope="row"><?php echo $row['created_by'] ?></td>
                    <td scope="row"><?php echo $row['assigned_to'] ?></td>
                    <td scope="row"><?php echo $row['created_at'] ?></td>
                    <td><a href="" class="btn btn-success">Edit</a></td>
                    <td><a href="" class="btn btn-danger">Delete</a></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
