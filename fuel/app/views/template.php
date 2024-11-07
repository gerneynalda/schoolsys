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
	<nav class="general-menu-wrapper" id="general-menu">
		<!-- contains a grid of buttons that links to softwares; -->
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="<?php echo Config::get("base_url")."reportcardconfig" ?>"><i class="fa-solid fa-list-check"></i></a>
			<p class="general-menu-label">Card Config</p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="<?php echo Config::get("base_url")."createclass" ?>"><i class="fa-solid fa-scroll"></i></a>
			<p class="general-menu-label">Classes</p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="<?php echo Config::get("base_url")."createcurriculum" ?>"><i class="fa-solid fa-graduation-cap"></i></a>
			<p class="general-menu-label">Curriculums</p>
		</div>
	 	<div class="general-menu-item">
			<a class="general-menu-item-link" href="<?php echo Config::get("base_url")."student" ?>"><i class="fa-solid fa-user-graduate"></i></a>
			<p class="general-menu-label">Students</p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="<?php echo Config::get("base_url")."grades" ?>"><i class="fa-solid fa-table-cells"></i></a>
			<p class="general-menu-label">Grades</p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="<?php echo Config::get("base_url")."attendance" ?>"><i class="fa-solid fa-calendar-days"></i></a>
			<p class="general-menu-label">Attendance</p>
		</div>

		<div class="general-menu-item">
			<a class="general-menu-item-link" href="<?php echo Config::get("base_url")."reportcard" ?>"><i class="fa-solid fa-folder"></i></a></li>
			<p class="general-menu-label">Report Card</p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="#"></a></li>
			<p class="general-menu-label"></p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="#"></a></li>
			<p class="general-menu-label"></p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="#"></a></li>
			<p class="general-menu-label"></p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="#"></a></li>
			<p class="general-menu-label"></p>
		</div>
		<div class="general-menu-item">
			<a class="general-menu-item-link" href="#"></a></li>
			<p class="general-menu-label"></p>
		</div>
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
				<a class="navbar-brand general-menu-toggle-btn" href="#" id="general-menu-btn"><i class="fa-solid fa-circle-chevron-right"></i></a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				
				<div class="btn-group navbar-form navbar-right" role="group" aria-label="Logout">
					<a type="button" class="btn btn-primary btn-sm" href="<?php echo Uri::create('authenticate/userLoggedOut')?>"><i class="fa-solid fa-cog"></i></a>
				</div>

				<!-- Specific Menu -->
				<?php echo isset($customMenu) ? $customMenu : ""; ?>

			</div>
		</div>
	</nav>

	<!-- Main Content -->
	<main class="container-fluid main-wrapper">
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
