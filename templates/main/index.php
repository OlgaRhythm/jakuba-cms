<?php
// main template
// View

/** Use object $page. */

include "header.php";
?>

<pre>
    <?//print_r($page);?>
</pre>

<?$page->getPageBlocks();?>

<?php
include "footer.php";
