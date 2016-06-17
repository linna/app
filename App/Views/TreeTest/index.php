<main>
    <h1>Struttura ad ALBERO</h1>
    <p>
    <?php 

    foreach ($data->tree as $treeNode) {
        echo str_repeat('--', $treeNode->nestingLevel).' '.$treeNode->nodeName.'<br/>';
    }

    ?>
    </p>
    <p><a href="<?php echo URL ?>">Return to Home</a> please.</p>
</main>
