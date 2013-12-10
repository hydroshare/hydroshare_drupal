<?php
/**
 * @file
 * hydroshare_blocks.features.fe_block_boxes.inc
 */

/**
 * Implements hook_default_fe_block_boxes().
 */
function hydroshare_blocks_default_fe_block_boxes() {
  $export = array();

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Announcements';
  $fe_block_boxes->format = 'php_code';
  $fe_block_boxes->machine_name = 'qcl_announcements';
  $fe_block_boxes->body = '<div class="announcements gradientDown">
	<h2>Announcements</h2>
        <div style="margin-left:20px" >
   <?php
		$sql = "SELECT nid, title, created FROM {node} where type = \'article\'  order by created desc limit 4 ";
		$result = db_query($sql);
                $hasRows = false;
		foreach ($result as $record) {
                        $rendered_teaser = render(node_view(node_load($record -> nid), \'teaser\'));
			$formatted_date = format_date($record -> created, \'custom\', \'M j Y\');
                        echo \'<p>\'.$rendered_teaser.\'</p><br/><hr>\';
                        $hasRows = true;
		}
                if (!$hasRows) {
                       echo \'<br/><br/>No announcements...<br/><br/>\';
                }
		?>
	</div>
</div>';

  $export['qcl_announcements'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Banner Home';
  $fe_block_boxes->format = 'php_code';
  $fe_block_boxes->machine_name = 'qcl_banner';
  $fe_block_boxes->body = '<div class="banner">
	<img src="<?php print base_path().path_to_theme(); ?>/images/home_banner.jpg" alt="">
					<div class="bannerDescriptionWrapper">
						<div class="bannerDescription">
							<h2>SHARE AND COLLABORATE</h2>
							<p>Hydroshare is an online collaboration environment for sharing data, models, and code. Join the community to start sharing.
							</p>	<a href="/?q=user/register" class="button">	Get Started with <span class="hydroshare"><span class="blue">HYDRO</span>SHARE</span>
							</a>
						</div>
					</div>						
					<div class="bannerNavWrapper">
<div class="bannerNav"><a href="#" class="first"><img class="png" src="<?php print base_path().path_to_theme(); ?>/images/gallery_logo.png" alt=""/>HYDROSHARE GALLERY</a>	<a href="#"> <img class="png" src="<?php print base_path().path_to_theme(); ?>/images/about_logo.png" alt=""/>HOW HYDROSHARE WORKS</a><a href="#"><img class="png" src="<?php print base_path().path_to_theme(); ?>/images/get_started_logo.png" alt=""/>GETTING STARTED</a>
						</div>
					</div>
				</div>';

  $export['qcl_banner'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Right Side Bar for Collaborate';
  $fe_block_boxes->format = 'full_html';
  $fe_block_boxes->machine_name = 'qcl_collaborate_right';
  $fe_block_boxes->body = '<div class="column-fourth interestedFeed"><h2>GROUPS YOU MIGHT BE INTERESTED IN</h2><div class="interestedGroups"><div class="interestedItem first"><p><span class="bold">Name:</span> USU Hydrology Group</p><p><span class="bold">Created by:</span> David Tarboton</p><a href="http://hydroshare.web.usu.edu/htm/group">View Group</a></div><div class="interestedItem"><p><span class="bold">Name:</span> Little Bear River Junkies</p><p><span class="bold">Created by:</span> David Tarboton</p><a href="http://hydroshare.web.usu.edu/htm/group">View Group</a></div></div></div>';

  $export['qcl_collaborate_right'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Sub header for Collaborate Page';
  $fe_block_boxes->format = 'full_html';
  $fe_block_boxes->machine_name = 'qcl_collaborate_subheader';
  $fe_block_boxes->body = '<div class="subHeader" style="width:100%;float:left">
		<h1>COLLABORATE</h1>
		<p>Build your research network</p>
<br/>
<hr width="100%">
	</div>';

  $export['qcl_collaborate_subheader'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Right Side Bar for Dashboard';
  $fe_block_boxes->format = 'full_html';
  $fe_block_boxes->machine_name = 'qcl_dashboard_right';
  $fe_block_boxes->body = '<div class="resourceWrapper"><div class="profile"><img src="<?php print base_path().path_to_theme(); ?>/images/profile_pic_jeff.jpg" alt="Jeff Horsburgh"><p class="title">Jeff Horsburgh</p><p>Utah State University</p><a href="mailto:jeff.horsburgh@usu.edu">jeff.horsburgh@usu.edu</a> </div><h3>resources you may like</h3><a href="/" class="resourceItem gradientUp"><img src="<?php print base_path().path_to_theme(); ?>/images/profile_logo.png" alt="default picture" class="png"> <p class="title">little bear river swat model</p> <p>Shared by: David Tarboton</p></a><a href="/" class="resourceItem gradientUp"><img src="<?php print base_path().path_to_theme(); ?>/images/profile_logo.png" alt="default picture" class="png"><p class="title">little bear river dem</p><p>Shared by: David Tarboton</p></a><a href="/" class="resourceItem gradientUp"><img src="<?php print base_path().path_to_theme(); ?>/images/profile_logo.png" alt="default picture" class="png"><p class="title">little bear river dem</p><p>Shared by: David Tarboton</p></a><h4>You Should Follow</h4><ul><a href="/"><li>People</li></a><a href="/"><li>Groups</li></a></ul><div class="followSugg"><div class="followItem"><a href="" class="followButton gradientUp">Follow</a><img src="<?php print base_path().path_to_theme(); ?>/images/profile_pic_jeff.jpg" alt="Jeff Horsburgh"><p>Jeff Horsburgh</p><p>Utah State University</p></div><div class="followItem"><a href="" class="followButton gradientUp">Follow</a><img src="<?php print base_path().path_to_theme(); ?>/images/profile_pic_default.jpg" alt="default picture"><p>David Tarboton</p><p>Utah State University</p></div><div class="followItem"><a href="" class="followButton gradientUp">Follow</a><img src="<?php print base_path().path_to_theme(); ?>/images/profile_pic_default.jpg" alt="default picture"><p>David Tarboton</p><p>Utah State University</p></div></div></div>';

  $export['qcl_dashboard_right'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Filter Collaboration Groups View';
  $fe_block_boxes->format = 'php_code';
  $fe_block_boxes->machine_name = 'qcl_filter_groups';
  $fe_block_boxes->body = '<?php 
global $user;
//if no operation was set default to "All Groups"
if (isset($_GET[\'op\'])) {
  $op = $_GET[\'op\'];
} else {
  $op = \'1\';
}
?>
<select onchange="selectFilter(this)" >
<?php if ($op == \'0\') { ?>
	<option value="0" selected>Groups Created By User</option>
<?php } else { ?>
	<option value="0">Groups Created By User</option>
<?php } ?>
<?php if ($op == \'1\') { ?>
	<option value="1" selected>All Groups</option>
<?php } else { ?>
	<option value="1">All Groups</option>
<?php } ?>
<?php if ($op == \'2\') { ?>
	<option value="2" selected>Groups You Created</option>
<?php } else { ?>
	<option value="2">Groups You Created</option>
<?php } ?>
<?php if ($op == \'3\') { ?>
	<option value="3" selected>Groups You Follow</option>
<?php } else { ?>
	<option value="3">Groups You Follow</option>
<?php } ?>
</select>
<br/>
<br/>
<a href="/?q=/node/add/hydroshare"  ><span style="color:black"><h2  style="border-bottom: 0px">CREATE GROUP +</h2></span></a>
<br/>
<hr width="100%" >
<br/>

<script language="javascript">

function selectFilter(elem) {
  if (elem.selectedIndex == 3 ) {
     window.location = "/?q=allgroups-mygroups&op=3";
     return;
  }
  if (elem.selectedIndex == 2 ) {
     window.location = "/?q=allgroups/<?php print $user->uid ?>&op=2";
     return;
  }
  if (elem.selectedIndex == 1) {
     window.location = "/?q=allgroups&op=1";
     return;
  }
  if (elem.selectedIndex == 0) {
     window.location = "/?q=allgroups-by-user&op=0";
     return;
  }
  alert("Unknown collaboration operation!");
  alert("Coming soon!");
};

</script>';

  $export['qcl_filter_groups'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Footer';
  $fe_block_boxes->format = 'php_code';
  $fe_block_boxes->machine_name = 'qcl_footer';
  $fe_block_boxes->body = '<div class="footer">
				<p class="siteTitle">HYDROSHARE</p>
				 <p><a href="/?q=terms_of_use" style="float:none">Terms of use |&nbsp;</a>
                                       <a href="/?q=statement_of_privacy" style="float:none">Statement of Privacy |&nbsp;</a>
	                               Copyright &#169; 2013 
                                        <a href=\'http://www.cuahsi.org/\' target=\'_blank\'  style="float:none">CUAHSI</a>.  
                                        See also <a href="http://www.cuahsi.org/HIS.aspx" target="_blank"  style="float:none">CUAHSI HIS</a> 
                                         and <a href="http://wdc.cuahsi.org/" target="_blank"  style="float:none">CUAHSI Water Data Center</a>
                                </p>
				<p>This material is based upon work supported by the National Science Foundation (NSF) under awards 1148453 and 1148090.</p>
				<p>Any opinions, findings conclusions, or recommendations expressed in this material are those of the authors and do not necessarily reflect the views of the NSF.</p>
</div>';

  $export['qcl_footer'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'menus';
  $fe_block_boxes->format = 'full_html';
  $fe_block_boxes->machine_name = 'qcl_menu';
  $fe_block_boxes->body = '<ul>
						<li><a href="/?q=dashboard">DASHBOARD<span class="navDescription">Recent Activity</span></a></li>
						<li><a href="/?q=mycontent">MY CONTENT<span class="navDescription">View Your Resources</span></a></li>
						<li><a href="/?q=explore-resources">EXPLORE<span class="navDescription">Discover Resources</span></a></li>
						<li><a href="/?q=allgroups">COLLABORATE<span class="navDescription">Share with Colleagues</span></a></li>
						<li><a href="/?q=help">SUPPORT<span class="navDescription">Get Help</span></a></li>
					</ul>';

  $export['qcl_menu'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Resource Recommendations';
  $fe_block_boxes->format = 'php_code';
  $fe_block_boxes->machine_name = 'qcl_resource_reccommendations';
  $fe_block_boxes->body = '<?php
global $user;
$uid_filter=" and n.uid <> :uid";
$sql="SELECT n.nid, n.title, n.created, u.name FROM {node} n, {users} u where n.uid = u.uid and n.type = \'hydroshare_time_series\'  ".$uid_filter." order by n.created desc limit 3 ";
$result=db_query($sql,array(\':uid\'=>$user->uid));
$sql="SELECT n.uid, n.name, n.mail, f.filename FROM {users} n LEFT OUTER JOIN {file_managed} f ON n.picture = f.fid where n.uid <> 0 ".$uid_filter." order by n.created desc limit 100 ";
$users_result=db_query($sql,array(\':uid\'=>$user->uid));
$sql="SELECT n.nid, n.title, n.created, u.name FROM {node} n, {users} u where n.uid = u.uid and n.type = \'hydroshare\'  ".$uid_filter." order by n.created desc limit 3 ";
$groups_result=db_query($sql,array(\':uid\'=>$user->uid));
$test_type=\'user_content\';
$subs=notifications_get_subscriptions(array(\'type\'=>$test_type));
$user_count = 0;
?>

<div class="resourceWrapper">
	<h3>resources you might like</h3>
	<?php foreach ($result as $record) {
	?>
	<a href="<?php echo base_path().\'?q=node/\'.$record->nid  ?>" class="resourceItem gradientUp"> <img src="/sites/all/themes/qcl_hydroshare/images/profile_logo.png" alt="default picture" class="png">
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
		<a href="#" onclick="document.getElementById(\'users_div\').style.display=\'block\';document.getElementById(\'groups_div\').style.display=\'none\';" >
		<li>
			People
		</li></a>
		<a href="#" onclick="document.getElementById(\'groups_div\').style.display=\'block\';document.getElementById(\'users_div\').style.display=\'none\';">
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
';

  $export['qcl_resource_reccommendations'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Right Side Bar for Support';
  $fe_block_boxes->format = 'full_html';
  $fe_block_boxes->machine_name = 'qcl_support_right';
  $fe_block_boxes->body = '<div class="column-fourth interestedFeed">
			<h2>Questions</h2>
			<div class="interestedGroups">
				<div class="interestedItem first">
					<p><span class="bold">Name:</span> USU Hydrology Group</p>
					<p><span class="bold">Created by:</span> David Tarboton</p>
					<a href="http://hydroshare.web.usu.edu/htm/group">Learn More</a>
				</div>
			
				<div class="interestedItem">
					<p><span class="bold">Name:</span> Little Bear River Junkies</p>
					<p><span class="bold">Created by:</span> David Tarboton</p>
					<a href="http://hydroshare.web.usu.edu/htm/group">Learn More</a>
				</div>
			</div>
	</div>';

  $export['qcl_support_right'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'Top Links';
  $fe_block_boxes->format = 'php_code';
  $fe_block_boxes->machine_name = 'qcl_top_links';
  $fe_block_boxes->body = '<?php
   global $user;
?>
<div class="console">
<ul>
 <?php if ($user->uid == 0) { ?>
       <li style="border-right:solid 1px grey"><a href="/?q=user/login">SIGN IN</a>&nbsp;&nbsp;</li>
<?php } else { ?>
       <li style="border-right:solid 1px grey"><a href="/?q=user/logout">SIGN OUT </a>&nbsp;&nbsp;</li>
<?php } ?>
        <li><a href="/?q=hs_feeback#overlay-context=hs_feedback%3Fq%3Dhs_feedback">FEEDBACK</a></li>
	<li><a href="/?q=user/<?php echo $user->uid ?>/edit">SETTINGS</a></li>
	<li><a href="/?q=user">NOTIFICATIONS</a></li>
        <li><a href="http://www.cuahsi.org/hydroshare.aspx" target="_blank">ABOUT</a></li>
</ul>
</div>';

  $export['qcl_top_links'] = $fe_block_boxes;

  $fe_block_boxes = new stdClass();
  $fe_block_boxes->info = 'User Profile';
  $fe_block_boxes->format = 'php_code';
  $fe_block_boxes->machine_name = 'qcl_user_profile';
  $fe_block_boxes->body = '<?php
global $user;
?>

<div class="profile" style="position:relative;top:-40px;left:4px;">
       <a href="mailto:<?php print $user->mail ?>"><?php print $user->mail ?></a>
</div>';

  $export['qcl_user_profile'] = $fe_block_boxes;

  return $export;
}
