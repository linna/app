<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script>
            var url = "<?php echo URL; ?>";
        </script>

        <link href="<?php echo URL; ?>css/app.css" rel="stylesheet" />
        
        <!-- app module specific css file -->
        <?php
        foreach ($css as $file) {
            ?>
        <link href="<?php echo $file;
            ?>" rel="stylesheet" />
        <?php

        }
        ?>
        <!-- end specific css file -->
        
    </head>
    <body>
        <header>
            
            <a class="menu icon home" href="#"></a>
            <a class="menu" href="<?php echo URL; ?>">home</a>
            <?php if ($data->isLogged === false) {
    ?>
            <a class="menu" href="<?php echo URL;
    ?>login">login</a>
            <?php 
}?>
            
            <?php if ($data->isLogged === true) {
    ?>
            <a class="menu" href="<?php echo URL;
    ?>logout">logout</a>
            <?php 
}?>
            
            <a class="menu" href="<?php echo URL; ?>protectedPage">protected page test</a>
            <a class="menu" href="<?php echo URL; ?>user">users</a>
            
        </header>

        <nav>
            <div>

            </div>
            <div>
                <ul>
                    <li><h3>Welcome</h3></li>
                    <li><a href="<?php echo URL; ?>">home</a></li>
                    
                    <?php if ($data->isLogged === false) {
    ?>
                    <li><a href="<?php echo URL;
    ?>login">login</a></li>
                    <?php 
}?>
                    
                    <?php if ($data->isLogged === true) {
    ?>
                    <li><a href="<?php echo URL;
    ?>login">logout</a></li>
                    <?php 
}?>
                    
                    <li><a href="<?php echo URL; ?>protectedPage">protected page test</a></li>
                    <li><a href="<?php echo URL; ?>user">users</a></li>
                </ul>
               
            </div>
            <div>
                <a class="closeNav" href="#">close</a>
            </div>
        </nav>


