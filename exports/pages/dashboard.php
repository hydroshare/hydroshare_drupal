<?php
  global $user;
  $uid_filter = " and uid = :uid ";
  $title = "MY ACTIVITY";
  if (isset($_GET["op"]) ) {
  	if ($_GET["op"] == "all") {
  		$uid_filter = "";
                $title = "ALL ACTIVITY";
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
	<h1><?php echo $title ?></h1>

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
		  $sql = "SELECT nid, title, created FROM {node} where (type = 'hydroshare_geoanalytics' or type = 'hydroshare_time_series' or type = 'hydroshare_other_content') ".$uid_filter." order by created desc limit ".$limit;
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
		<?php } ?>
	</div>
</div>