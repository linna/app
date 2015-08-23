<footer>
  
</footer>

<script src="http://192.168.0.10/app/js/app.js"></script>

<!-- app module specific js script -->
<?php
foreach ($js as $file) {
    ?>
<script src="<?php echo $file;
    ?>"></script>
<?php

}
?>
<!-- end specific js script -->
    
</body>
</html>
