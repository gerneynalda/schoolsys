<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo Asset::css("all.min.css") ?>
	<?php echo Asset::css("bootstrap.css") ?>
	<title>Login</title>
</head>
<body>
	<main class="container-fluid">
		<section class="row">
			<div class="col-md-4 col-md-offset-4">
				
				<div class="panel panel-primary">
					<div class="panel-heading">Login</div>
					<div class="panel-body">
						<?php if(isset($error_message)) :?>

							<div class="alert alert-danger">
								<p><i class="fa-solid fa-warning"></i> <?php echo $error_message; ?></p>
							</div>
							
						<?php endif; ?>

						<?php if(Session::get_flash("logout_message")) :?>

							<div class="alert alert-success">
								<p><i class="fa-solid fa-check"></i> <?php echo Session::get_flash("logout_message") ?></p>
							</div>

						<?php endif;?>
						
						<!-- Login Form -->
						<?php echo Form::open("authenticate/userLoggedIn") ?>

							<div class="form-group">
								<label for="usernameInput">Username</label>
								<input class="form-control" type="text" id="usernameInput" name="username" autocomplete="off" autofocus value="" placeholder="Username"/>
							</div>
							<div class="form-group">
								<label for="passwordInput">Password</label>
								<input class="form-control" type="password" id="passwordInput" name="password" autocomplete="off" value="" placeholder="Password" />
							</div>
							<button type="submit" class="btn btn-primary">Login</button>

						<?php echo Form::close() ?>

					</div>
				</div>

			</div>
		</section>		
	</main>
<?php echo Asset::js("jquery-v.3.7.1.min.js") ?>
<?php echo Asset::js("bootstrap.min.js") ?>
<?php echo Asset::js("all.min.js") ?>
<style>
	html, body {
		box-sizing: border-box;
		padding: 0;
		margin: 0;
		height: 100%;
		width: 100%;
	}
	body{
		display: flex;
		flex-flow: column;

		align-items: center;
		justify-content: center;
	}
	main.container-fluid {
		width: 100%;
	}
</style>
</body>
</html>