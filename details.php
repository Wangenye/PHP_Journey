<?php
include('./config/db_connect.php');

if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn,$_POST['id_to_delete']); 

    $sql = "DELETE FROM pizzas WHERE id = '$id_to_delete'";

    if(mysqli_query($conn,$sql)){
        //Success
        header ("Location: index.php");
    }else{
        echo 'query error' * mysqli_error($conn);
    }
}

//check get request
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn,$_GET['id']);

    $sql = "SELECT * FROM pizzas WHERE id = $id";

    // query results 
    $result = mysqli_query($conn,$sql);
    //fetch result in array format

    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);

    // print_r($pizza);
}

?>

<!DOCTYPE html>
<html>
<?php 
    include('./templates/header.php')?>

    <div class="container center grey-text">
        <?php if($pizza):?>
            <h4><?php echo htmlspecialchars($pizza['title'])?></h4>

            <p>Created By : <?php echo htmlspecialchars($pizza['email'])?></p>
            <p><?php echo date($pizza['created_at'])?></p>
            <p><?php echo htmlspecialchars($pizza['ingridients'])?></p>

            <!-- Delete Form  -->
            <form action="details.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'];?>" />
                <input type="Submit" name="delete" value="Delete" class="btn brand z-depth-0" />
            </form>

            <a href="edit.php?id=<?php echo $pizza['id']; ?>" class="btn brand z-depth-0">Edit</a>

        <?php else:?>
            <h5 class="text-red">No Such Pizza Exists !! </h5>
        <?php endif;?>
    </div>


<?php 
    include('./templates/footer.php')?>

</html>