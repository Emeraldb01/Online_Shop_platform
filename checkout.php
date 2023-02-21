<?php
    include_once 'header.php';
?>
<section>
    <h2 class="cart">Cart</h2>
    <?php
        require_once 'includes/function.inc.php';
        itemInCart($conn);
    ?>
</section>
</body>
</html>