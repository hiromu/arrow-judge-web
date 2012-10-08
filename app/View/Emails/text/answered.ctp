Hi, <?php echo $question['User']['username']."\n"; ?>.

You have recieved a answer to your question of "<?php echo sprintf('Problem #%d: %s', $question['Problem']['id'], $question['Problem']['name']); ?>".

Question:

<?php echo $question['Question']['question']; ?>


Answer:

<?php echo $answer; ?>


To see the answer in web browsers, please copy this link into your browser's address bar and open it:

<?php echo $url."\n"; ?>

--
<?php echo $title."\n"; ?>
<?php echo $this->Html->url('/', true); ?>

