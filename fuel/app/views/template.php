<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<link rel="icon" type="image/x-icon" href="./btcsi.ico">
	<?php echo Asset::css('core_styles.css') ?>
	<?php echo Asset::css($core_styles); ?>
	<?php echo isset($styles) ? Asset::css($styles) : "" ?>
</head>
<body>
	<!-- General Menu -->
	<nav class="nav nav-stacked general-menu" id="general-menu">
		<li>
			<a href="<?php echo Config::get("base_url")."student" ?>" title="Students"><i class="fa-solid fa-user-graduate"></i> Students</a>
		</li>
		<li>
			<a href="<?php echo Config::get("base_url")."grades" ?>" title="Grades"><i class="fa-solid fa-table-cells"></i> Grades</a>
		</li>
		<li>
			<a href="<?php echo Config::get("base_url")."attendance" ?>" title="Attendance"><i class="fa-solid fa-calendar-days"></i> Attendance</a>
		</li>
		<li>
			<a href="<?php echo Config::get("base_url")."reportcard" ?>" title="Report Cards"><i class="fa-solid fa-folder"></i> Report Card</a>
		</li>
		<li>
			<a href="<?php echo Config::get("base_url")."createclass" ?>" title="Classes"><i class="fa-solid fa-scroll"></i> Classes</a>
		</li>
		<li>
			<a href="<?php echo Config::get("base_url")."createcurriculum" ?>" title="Curriculums"><i class="fa-solid fa-graduation-cap"></i> Curriculums</a>
		</li>
		<li>
			<a href="<?php echo Config::get("base_url")."reportcardconfig" ?>" title="Card Configuration"><i class="fa-solid fa-list-check"></i> Card Config</a>
		</li>
	</nav>

	<!-- Custom Menu Specific To The Page -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- general menu toggle button -->
				<a class="navbar-brand general-menu-toggle-btn" href="#" id="general-menu-btn"><i class="fa-solid fa-bars"></i></a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				
				<div class="btn-group navbar-form navbar-right" role="group" aria-label="Logout">
					<a type="button" class="btn btn-primary btn-sm" href="<?php echo Uri::create('authenticate/userLoggedOut')?>" title="Logout" aria-label="Logout"><i class="fa-solid fa-right-from-bracket"></i></a>
				</div>

				<!-- Specific Menu -->
				<?php echo isset($customMenu) ? $customMenu : ""; ?>

			</div>
		</div>
	</nav>

	<!-- Main Content -->
	<main class="container-fluid main-wrapper" id="main-wrapper">
		<?php echo $content; ?>
	</main>

	<section class="system-notifications-wrapper" id="system-notifications-wrapper">
		<!-- system notifications -->
	</section>

	<!-- Base Url -->
	<script>
		const baseUrl = `<?php echo Config::get('base_url') ?>`
	</script>
	<?php echo Asset::js('general-menu.js'); ?>
	<?php echo Asset::js($core_scripts); ?>
	<?php echo isset($scripts) ? Asset::js($scripts) : "" ?>
</body>
</html>
