<main>
    <h1>Home Page</h1>
    <p>In a real application this could be the homepage.</p>
    
    <?php if ($data->isLogged === true) {
    ?>         
    
    <p>You are logged as <b><?php echo $data->userName; ?></b> -  <a href="<?php echo URL; ?>logout">logout</a> </p>
    
    <?php 
} ?>
    
</main>
