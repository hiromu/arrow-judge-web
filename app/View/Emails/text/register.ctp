Hi, <?php echo $username."\n"; ?>/

You have recently registered with <?php echo $title; ?>.
To confirm your registration, please copy this link into your browser's address bar and open it:

<?php echo $url."\n"; ?>

If you did not actually register with <?php echo $title; ?>, please ignore this message.

--
<?php echo $title."\n"; ?>
<?php echo $this->Html->url('/', true); ?>

