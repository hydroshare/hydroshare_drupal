<?php
global $user;
$uid_filter = " and n.uid <> :uid";
$sql = "SELECT n.nid, n.title, n.created, u.name FROM {node} n, {users} u where n.uid = u.uid and n.type = 'hydroshare_time_series'  ".$uid_filter." order by n.created desc ";
$result = db_query($sql, array(':uid' => $user -> uid));
?>

<div class="resourceWrapper">
	<h3>resources you may like</h3>
	<?php foreach ($result as $record) { ?>   
	    <a href="<?php echo base_path().'?q=node/'.$record->nid  ?>" class="resourceItem gradientUp">
	    	<img src="/sites/all/themes/qcl_hydroshare/images/profile_logo.png" alt="default picture" class="png">
			<p class="title">
				<?php echo $record->title; ?>
			</p>
			<p>
				Shared by: <?php echo $record->name ?>
			</p>
		</a>
    <?php } ?>
</div>