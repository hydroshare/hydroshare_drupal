	<section id="console">
			<?php if($page['header']): print render($page['header']); endif;?>
	</section>
		<div id="container">
			<!-- header -->
			<header class="ep-outline" role="banner">
				<div class="mainNav">
					<a href="<?php print base_path(); ?>" class="logo"><img src="<?php print base_path().path_to_theme();?>/images/hydroshare_logo.png" alt="HydroShare. Share and Collaborate"></a>
					
					<?php if($page['menu']): print render($page['menu']); endif; ?>
				</div>
			</header>
			<div class="pageWrapper">
				<!-- content -->
				<section id="banner">
					<?php if($page['banner']): print render($page['banner']); endif; ?>
				<!-- Content Bottom -->
					
					<?php if($page['contentbottom']): print render($page['contentbottom']); endif; ?>
				</section>
			</div>
		</div>
		<!-- footer -->
		<footer>
			<?php if($page['footer']): print render($page['footer']); endif; ?>
		</footer>		
<!--- 	<cfdump var="#ep#"> --->