<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>libraryapp</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles.css">
    </link>
</head>


<body background="https://thumbs.dreamstime.com/b/icon-set-black-simple-silhouette-sports-equipment-flat-design-vector-illustration-info-graphic-web-banners-71303689.jpg">
    <br />
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4 container-2 align-items-center">
                <form action="./authenticate.php" method="post">

                    <h1>Login </h1>
                    </br><input type="text" placeholder="Email" name="email"><br />
                    </br><input type="password" placeholder="Password" name="password"><br /></br>
                    <button class="btn-dark text-white btn-lg" type="submit" name="submit">Login</button>
                    <a class="btn-secondary text-white btn-lg" href="./index.php">Register</a>

                </form>
            </div>
        </div>
    </div>
</body>

</html>