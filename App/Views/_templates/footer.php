<footer>
  
</footer>

<script src="<?php echo URL; ?>js/app.js"></script>

<!-- app module specific js script -->
<?php
foreach ($js as $file) {
    ?>
<script src="<?php echo $file; ?>"></script>
<?php

}
?>
<!-- end specific js script -->
    
</body>
</html>
