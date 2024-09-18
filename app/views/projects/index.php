<?php 
include '../../models/db.php';
include '../../models/project.php';

$sql = "select * from project";

$rows = $db->query($sql);

?>

<?php include '../header.php'; ?>

<div class="container">
  <div class="column">
    <div class="row" style="margin-top: 70px;">
      <div class="col-md-10 col-md-offset-1">
        <table class="table">
          <button type="button" data-target="#addProject" data-toggle="modal" class="btn btn-success">Add Project</button>
          <hr>
          <p>filteri</p>

          <div id="addProject" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <?php include 'add.php'; ?>
            </div>
          </div>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Assigned tasks</th>
                <th scope="col">Created by</th>
                <th scope="col">Created at</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $rows->fetch_assoc()): ?>
                <tr>
                  <td scope="row"><?php echo $row['id'] ?></td>
                  <td class="col-md-10"><?php echo $row['name'] ?></td>
                  <td class="col-md-10"><?php echo $row['description'] ?></td>
                  <td>
                    <?php 
                      $tasks = get_tasks_by_project($row['id']);
                      if (!empty($tasks)) { ?>
                        <?php foreach($tasks as $task): ?>
                          <p><?php echo $task['title'] ?></p>
                        <?php endforeach; ?>
                    <?php } else { ?>
                      <p>No tasks found for this project.</p>
                    <?php } ?>
                  </td>
                  <td scope="row"><?php echo $row['created_by'] ?></td>
                  <td scope="row"><?php echo $row['created_at'] ?></td>
                  <td><a href="" class="btn btn-success">Edit</a></td>
                  <td>
                    <form action="../../controllers/projectController.php" method="POST">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                      <input type="submit" class="btn btn-danger" value="Delete">
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include '../footer.php'; ?>