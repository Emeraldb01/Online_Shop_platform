<?php
    include_once 'header.php';
?>
<section>
    <h2 class="cart">Orders</h2>
    <?php
        require_once 'includes/function.inc.php';
        itemInOrder($conn);
    ?>
</section>