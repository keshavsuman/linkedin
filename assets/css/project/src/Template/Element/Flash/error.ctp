<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<p onclick="this.classList.add('hidden')"><span class="label-lg label-warning label-white middle"><?php echo $message ?></span></p>