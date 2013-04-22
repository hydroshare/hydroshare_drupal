<?php
   global $user;
?>
<div class="console">
<ul>
 <?php if ($user->uid == 0) { ?>
       <li><a href="/?q=user/login">SIGN IN</a></li>
<?php } else { ?>
       <li><a href="/?q=user/logout">SIGN OUT</a></li>
<?php } ?>
	<li><a href="/?q=user/<?php echo $user->uid ?>/edit">SETTINGS</a></li>
	<li><a href="/?q=user">NOTIFICATIONS</a></li>
	<li class="first"><a href="">HELP</a></li>
</ul>
</div>