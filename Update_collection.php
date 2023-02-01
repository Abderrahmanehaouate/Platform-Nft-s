<?php require_once 'include/database.php'; 

    session_start();
    if(isset($_SESSION['admin'])){ 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .Admin-title
        {
            color: white;
        }

        .input-form{
            color:white;
        }

    </style>
</head>
<body>
    <div class="hero">
        <div class="form-box">

           <?php
                
                // select
                $idC = $_GET['id'];
                $sqlState = $db->prepare("SELECT * FROM collection WHERE idC = ?");
                $sqlState->execute([$idC]);
                $categorie = $sqlState->fetch(PDO::FETCH_ASSOC);

                // update 
                if(isset($_POST['UpdateCollection'])){
                    $nameC = $_POST['nameC'];
                    $nameA = $_POST['nameA'];

                    // echo $categorie['imgartist'] ;

                    $imgA = "";
                    if(empty($_FILES['imageA']['name'])){
                        $filenameA = $categorie['imgartist'];
                    }
                    else{
                        $imgA = $_FILES['imageA']['name'];
                        $filenameA = uniqid().$imgA;
                        move_uploaded_file($_FILES['imageA']['tmp_name'], 'upload/collectionimg/' .$filenameA);
                    
                    }
                    // if(empty($_FILES['imageA'])){
                    //     $filenameA = $categorie['imgartist'];
                        
                    // }

                    $imgC = "";
                    if(empty($_FILES['imageC']['name'])){
                        $filenameC = $categorie['imgCollection'];
                    }
                    else{
                        
                        $imgC = $_FILES['imageC']['name'];
                        $filenameC = uniqid().$imgC;
                        move_uploaded_file($_FILES['imageC']['tmp_name'], 'upload/collectionimg/' .$filenameC);
                    
                    }
                    // if(empty($_FILES['imageC'])){
                    //     $filenameC = $categorie['imgCollection'];
                    // }

                    if(!empty($nameC) && !empty($nameA)){
                        // if(!empty($filenameA) && !empty($filenameC)){

                            $sqlState = $db->prepare("UPDATE collection SET nomC=?, nomartiste=?, imgartist=?, imgCollection=? WHERE  idC=?");
                            $inserted = $sqlState->execute([$nameC,$nameA, $filenameA,$filenameC,$idC]);
    
                        // }else{
                        

                        //     $sqlState = $db->prepare("UPDATE collection SET nomC=?, nomartiste=?, imgartist=?, imgCollection=? WHERE  idC=?");
                        //     $inserted = $sqlState->execute([$nameC,$nameA,$categorie['imgartist'] ,$categorie['imgCollection'],$idC]);
                        // }
                    
                    }
                    

                }

                
           ?>

            <!-- login -->
            <form method="post" id="login" class="input-groupe" enctype="multipart/form-data">
                <h2 class="Admin-title">Update Collection</h2>
                <input type="text" class="input-form" placeholder="name collection" name="nameC" value="<?php echo $categorie['nomC'] ?>">
                <img src="upload/collectionImg/<?php echo $categorie['imgCollection'] ?>" alt=""  width="50px" height="50px">
                <input type="file" class="file-form" name="imageC" value="">

                <input type="text" class="input-form" placeholder="name artist" name="nameA" value="<?php echo $categorie['nomartiste'] ?>">
                <img src="upload/collectionImg/<?php echo $categorie['imgartist'] ?>" alt="" width="50px" height="50px">
                <input type="file" class="file-form" name="imageA" value="">
                <br><br><br>
                <button type="submit" class="submit-btnn" name="UpdateCollection">Update</button>
            </form>
        </div>
    </div>
    <!--=============== MAIN JS ===============-->
    <script src="js/main.js"></script>
</body>
</html>

<?php } else{
    header('location: login.php');
}

?>