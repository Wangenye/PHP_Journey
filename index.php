<?php
include('./config/db_connect.php');

//Write a query for all pizzas and
$sql = "SELECT title,ingridients,id FROM pizzas";

//Make query and get results
$result = mysqli_query($conn, $sql);

//Fetch the resulting rows as an array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

mysqli_close($conn);

// print_r($pizzas)

// explode(',',$pizzas[0]['ingridients']);
?>



<!DOCTYPE html>
<html lang="en">

<body>
    <?php
    include('./templates/header.php');


    ?>
    <h4 class="center grey-text">Pizzas !</h4>

    <div class="container">
        <div class="row">
            <?php foreach ($pizzas as $pizza) : ?>
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <img src="img/pizza.svg" alt="Pizza" class="pizza">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>

                            <ul class="grey-text">
                                <?php foreach (explode(',', $pizza['ingridients']) as $ing) { ?>
                                    <li><?php echo htmlspecialchars($ing); ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="card-action right-align">
                            <a href="details.php?id=<?php echo $pizza['id']?>" class="brand-text">
                                More Info
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



    <?php


    include('./templates/footer.php');
    ?>

</body>

</html>