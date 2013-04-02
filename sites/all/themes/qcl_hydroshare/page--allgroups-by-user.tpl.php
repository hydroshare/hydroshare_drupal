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
					<div class="collaborate">

					<?php if($page['subheader']): print render($page['subheader']); endif; ?>
					<div style="width:300px;float:left"><?php if($page['left']): print render($page['left']); endif; ?></div>
					<div style="float:left;width:600px"><?php if($page['content']): print render($page['content']); endif; ?></div>
					<?php if($page['contentbottom']): print render($page['contentbottom']); endif;?>
					<?php if($page['right']): print render($page['right']); endif; ?>
					</div>
			</div>
		</div>
		<!-- footer -->
		<footer>
			<?php if($page['footer']): print render($page['footer']); endif; ?>
		</footer>