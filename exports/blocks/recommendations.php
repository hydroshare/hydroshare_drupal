<?php
global $user;
$uid_filter=" and n.uid <> :uid";
$sql="SELECT n.nid, n.title, n.created, u.name FROM {node} n, {users} u where n.uid = u.uid and n.type = 'hydroshare_time_series'  ".$uid_filter." order by n.created desc limit 3 ";
$result=db_query($sql,array(':uid'=>$user->uid));
$sql="SELECT n.uid, n.name, n.mail, f.filename FROM {users} n LEFT OUTER JOIN {file_managed} f ON n.picture = f.fid where n.uid <> 0 ".$uid_filter." order by n.created desc limit 100 ";
$users_result=db_query($sql,array(':uid'=>$user->uid));
$sql="SELECT n.nid, n.title, n.created, u.name FROM {node} n, {users} u where n.uid = u.uid and n.type = 'hydroshare'  ".$uid_filter." order by n.created desc limit 3 ";
$groups_result=db_query($sql,array(':uid'=>$user->uid));
$test_type='user_content';
$subs=notifications_get_subscriptions(array('type'=>$test_type));
$user_count = 0;
?>

<div class="resourceWrapper">
	<h3>resources you might like</h3>
	<?php foreach ($result as $record) {
	?>
	<a href="<?php echo base_path().'?q=node/'.$record->nid  ?>" class="resourceItem gradientUp"> <img src="/sites/all/themes/qcl_hydroshare/images/profile_logo.png" alt="default picture" class="png">
	<p class="title">
		<?php echo $record->title; ?>
	</p>
	<p>
		Shared by: <?php echo $record->name
		?>
	</p> </a>
	<?php } ?>
	<br/>
	<a href="/?q=resources" class="moreButton greyButton" style="width:70px">MORE...</a>
	<h4>You May Follow</h4>
	<ul>
		<a href="#" onclick="document.getElementById('users_div').style.display='block';document.getElementById('groups_div').style.display='none';" >
		<li>
			People
		</li></a>
		<a href="#" onclick="document.getElementById('groups_div').style.display='block';document.getElementById('users_div').style.display='none';">
		<li>
			Groups
		</li></a>
	</ul>
	<div id="users_div" class="followSugg">
		<?php foreach ($users_result as $record) {
			$isSubscribed = false;
			foreach ($subs as $sub) {
				foreach ($sub->get_objects() as $obj) {
					if ($obj->value == $record->uid) {
						$isSubscribed = true;
					}
				}
			}
			if ($isSubscribed == false) {
				if ($user_count < 5) {
				$user_count = $user_count + 1;
		?>
			<div class="followItem">
	
				<a href="/?q=notifications/subscribe/user_content&0=<?php echo $record->uid ?>&destination=user/<?php echo $record->uid ?>" class="followButton gradientUp">Follow</a>
				   <?php if ($record->filename == null) { ?>
				    No Picture
				   <?php } else { ?>
				    <img src="/sites/default/files/styles/thumbnail/public/pictures/<?php echo $record->filename ?>" alt="<?php echo $record->name ?>">
				   <?php } ?>
				<p>
					<?php echo $record->name
					?>
				</p>
			</div>
		<?php   }
			} 
		} 
		?>
	</div>
	<div id="groups_div" class="followSugg" style="display:none">
		<?php foreach ($groups_result as $record) {
		?>
		<div class="followItem">

			<a href="/?q=group/node/<?php echo $record->nid ?>/subscribe/og_user_node" class="followButton gradientUp">Follow</a>
			<p>
				<?php echo $record->title
				?>
			</p>
			<p>
				Created by: <?php echo $record->name
				?>
			</p>
		</div>
		<?php } ?>
	</div>
</div>
