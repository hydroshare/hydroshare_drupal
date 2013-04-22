<?php
global $user;
?>

<div class="profile" style="position:relative;top:-40px;left:4px;">
         <?php
              if ($user->picture) 
              {
                  print  theme('user_picture', array('account' => $user));
              } else {
                  print ("No photo");
              }
         ?>
	<p class="title">
		<?php print $user->name ?>
	</p>
       <a href="mailto:<?php print $user->mail ?>"><?php print $user->mail ?></a>
</div>