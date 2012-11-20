Hi, <?php echo $problem['User']['username']; ?>.

You have recieved a new question of "<?php echo sprintf('Problem #%d: %s', $problem['Problem']['id'], $problem['Problem']['name']); ?>".

Question:

<?php echo $question; ?>


To answer to the question, please copy this link into your browser's address bar and open it:

<?php echo $url."\n"; ?>

