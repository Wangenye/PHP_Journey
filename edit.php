<?php
include('./config/db_connect.php');

$title = $email =$ingridients = '';



$errors = array('email'=>'', 'title'=>'', 'ingridients'=>'');


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

if(isset($_POST['submit-update'])){
    // echo htmlspecialchars($_POST['email']);
    // echo htmlspecialchars($_POST['title']);
    // echo htmlspecialchars($_POST['ingridients']);
    
    //Check email address
    if(empty($_POST['email'])){
        $errors['email']="Email is required <br/>";
    }else{
        $email = $_POST['email'];
        

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email']= "Please Enter a valid email address";
        }
    }

     //Check title
     if(empty($_POST['title'])){
        $errors['title']= "Title is required <br/>";
    }else{
        $title = $_POST['title'];

        if(!preg_match('/^[a-zA-Z\s]+$/',$title)){
            $errors['title']="Title must be letters and spaces only <br/>";
        }
    }

     //Check email address
     if(empty($_POST['ingridients'])){
        $errors['ingridients']= "ingridients is required <br/>";
    }else{
        $ingridients = $_POST['ingridients'];

        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/',$ingridients)){
            $errors['ingridients']="ingridients must be comma separated list<br/>";
        }
    }

    if(array_filter($errors)){
        echo 'There are Errors in the form';
    } else {
        $email = mysqli_real_escape_string($conn,$_POST['email']);

        $title = mysqli_real_escape_string($conn,$_POST['title']);

        $ingridients = mysqli_real_escape_string($conn,$_POST['ingridients']);
        //Create sql variable for add
        $sql = "UPDATE  $pizza SET $pizza[title]='$title',email='$email',ingridients='$ingridients' WHERE id=$id" ;
        //Save to db and check  
        if(mysqli_query($conn,$sql)){
            header('Location: index.php');
        }else{
            echo 'Query error ' * mysqli_error($conn);
        };
       
    }
}

?>

<!DOCTYPE html>
<html>
<?php
    include('./templates/header.php');


    ?>

    <h4>Edit Page</h4>

    <form action="edit.php?id=<?php echo $pizza['id']?>"  class="white" method="POST">
        
            <label for="">Your Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($pizza['email']); ?>">
            <div class="red-text"><?php echo $errors['email'] ?></div>

            <label for="">Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($pizza['title']) ?>">
            <div class="red-text"><?php echo $errors['title'] ?></div>

          
            <label for="">Ingridients (comma separated):</label>
            <input type="text" name="ingridients" value="<?php echo htmlspecialchars($pizza['ingridients']) ?>">
            <div class="red-text"><?php echo $errors['ingridients'] ?></div>
            

            <div class="center">
                <input type="submit" name="submit-update" value="submit" class="btn brand z-depth-0">
            </div>
        </form>


<?php
    include('./templates/footer.php');


    ?>
    
</html>