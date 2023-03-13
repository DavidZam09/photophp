<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/ico/favicon.ico">
    <link rel="stylesheet" href="../css/app.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <title>Subir archivos</title>
    <style>
        .formulario {
            padding: 150px;
        }

        form {
            justify-content: center;
            text-align: center;
            align-items: center;
            padding: 20px;
            margin-top: 10rem;
            width: 80%;
            height: 80%;
            border: 1px solid #4e4d4d;
            border-radius: 4px;
            box-shadow: 0 0 10px #000;
        }

        form input {

            width: 300px;
            height: 40px;
            padding: 0px;
            color: #6d6d6d;
            text-align: center;
            margin: auto;

        }

        form button {
            width: 135px;
            height: 50px;
            background: green !important;
            border: 1px solid #232323;
            color: white !important;
            box-shadow: 0px 2px 1px #000;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <?php include('top_menu.php') ?>

    <div class="container">
        <div class="formulario">

            <form action="" enctype="multipart/form-data" id="formulario">
                <input type="text" name="cliente" placeholder="Cliente" required class="form-control">

                <input type="text" name="precinto" placeholder="Precinto" class="form-control" required>

                <input type="date" name="date" required class="form-control">

                <input type="file" name="img" required class="form-control" />

                <button type="submit" name="button" class="form-control">Guardar</button>
            </form>
        </div>
        <div id="result"></div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="../js/insert.js"></script>
    <?php include('footer.php') ?>

</body>

</html>
