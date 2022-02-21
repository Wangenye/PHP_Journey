<?php

include('./config/db_connect.php');
// if(isset($_GET['submit'])){
//     echo $_Get['email'];
//     echo $_Get['title'];
//     echo $_Get['ingridients'];
// }

$title = $email =$ingridients = '';



$errors = array('email'=>'', 'title'=>'', 'ingridients'=>'');


if(isset($_POST['submit'])){
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
            $sql = "INSERT INTO pizzas(title,email,ingridients) VALUES ('$title','$email','$ingridients')";
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
<html lang="en">

    <?php 
    include('./templates/header.php')?>


    <section class="container grey-text">
        <h4 class="center">Add a Pizzah</h4>

        

        <form action="add.php" class="white" method="POST">
        
            <label for="">Your Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="red-text"><?php echo $errors['email'] ?></div>

            <label for="">Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
            <div class="red-text"><?php echo $errors['title'] ?></div>

          
            <label for="">Ingridients (comma separated):</label>
            <input type="text" name="ingridients" value="<?php echo htmlspecialchars($ingridients) ?>">
            <div class="red-text"><?php echo $errors['ingridients'] ?></div>
            

            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php 
    include('./templates/footer.php')?>


    
</html>