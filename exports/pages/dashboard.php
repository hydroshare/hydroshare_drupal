<?php
  global $user;
  $uid_filter = "";
  if (isset($_GET["op"]) ) {
  	if ($_GET["op"] == "my") {
  		$uid_filter = " and uid = :uid ";
  	}
  }
  $limit = "4";
  $more = "";
  if (isset($_GET["more"]) ) {
	$limit = "100";
	$more = "&more=Y";
  } 
  $nid = 0;
  if (isset($_GET["nid"])) {
  	$nid = $_GET["nid"];
  }   
  $selected = "";
?>
<div class="recentActivity gradientDown">
	<h1>RECENT ACTIVITY</h1>

	<ul class="activityNav">
		<li>
			<a href="<?php echo base_path(); ?>?q=dashboard&op=my">ONLY MY ACTIVITY</a>
		</li>
		<li>
			<a href="<?php echo base_path(); ?>?q=dashboard&op=all">ALL ACTIVITY &nbsp; | &nbsp;&nbsp;</a>
		</li>
	</ul>
	<div class="activityStream">
		<?php
		  $sql = "SELECT nid, title, created FROM {node} where type <> 'page' ".$uid_filter." order by created desc limit ".$limit;
		  $result = db_query($sql, array(':uid' => $user->uid));
          foreach ($result as $record) {
          	    if ($nid == 0	 ) {
          	    	$nid = $record->nid;
					$selected = " greyButtonSelected ";
          	    }  else {
          	    	if ($nid == $record->nid) {
          	    		$selected = " greyButtonSelected ";
          	    	}
          	    }
				$formatted_date = format_date($record->created, 'custom', 'M j Y');
				
				echo '<a href="'.base_path().'?q=dashboard'.$more.'&op='.$_GET["op"].'&nid='.$record->nid.'" class="activityEvent greyButton '.$selected.'">';
				$selected = "";
				echo '<p class="title">';
				echo $record->title;
				echo '</p>';
				echo '<p class="dateInfo">';
				echo 'created '.$formatted_date;
				echo '</p></a>';
			 }		
		?>
		<?php   if (!isset($_GET["more"]) ) { ?>
		<a href="<?php echo base_path(); ?>?q=dashboard&more=y&op=<?php echo $_GET["op"] ?>&nid=<?php print $nid ?>" class="moreButton greyButton">MORE...</a>
		<?php } ?>
	</div>
	<div class="activityDetails">
		<?php if ($nid != 0) {
                          $rendered_teaser = render(node_view(node_load($nid), 'teaser'));


		?>
		<p class="title">
			ABSTRACT
		</p>
		<p>
		<?php   print $rendered_teaser;  ?>
		</p>
		<p class="title">
		KEYWORDS
		</p>
		<p>
		Coming Soon!
		</p>
		<?php } ?>
	</div>
</div>