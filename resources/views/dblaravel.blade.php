<!DOCTYPE html>
<html>
<head>
    <title> laravel & database connection </title>
</head>
<body>
    <div>
        <?php 
        if(DB::connection()->getPdo()){
           echo "succifully connected to DB :".DB::connection()->getDatabaseName();
        }
        ?>
    </div>
</body>
</html>