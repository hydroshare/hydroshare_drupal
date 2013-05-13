<div class="recentActivity gradientDown">
	<h1>RECENT ACTIVITY</h1>

	<ul class="activityNav">
		<li>
			<a href="">ONLY MY ACTIVITY</a>
		</li>
		<li>
			<a href="">ALL ACTIVITY &nbsp; | &nbsp;&nbsp;</a>
		</li>
	</ul>
	<div class="activityStream">
		<?php if($page['left']): print render($page['left']); endif; ?>
		<a href="/" class="moreButton greyButton">MORE...</a>
	</div>
	<div class="activityMap">
		<!--- embed google map here width: 372px height: 218px ---><img src="<?php print base_path() . path_to_theme(); ?>/images/map.jpg" alt="google map">
	</div>
	<div class="activityDetails">
		<p class="title">
			ABSTRACT
		</p>
		<p>
			Time series of water quality snsor date in the Little Bear River, Utah, USA.
		</p>
		<p class="title">
			KEYWORDS
		</p>
		<p>
			Temperature, Disolved Oxygen, pH, Specific Conditions, Turbidity
		</p>
	</div>
</div>