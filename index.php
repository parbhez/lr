<?php 
	include 'inc/header.php';
	include 'lib/User.php';
	Session::checkSession();
 ?>
 
 <?php
 $loginmag = Session::get("loginmsg");
 	if (isset($loginmag)) {
 		echo $loginmag;
 	}
Session::set("loginmsg", NULL);
 ?>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h2>User List<span class="pull-right">Wellcome!<strong>
						<?php
						$username = Session::get("username");
						if (isset($username)) {
							echo $username;
						}
						?>
					</strong></span></h2>
					</div>
				
					<div class="panel-body">
						<table class="table table-striped">
							<th width="20%">Serial</th>
							<th width="20%">Name</th>
							<th width="20%">User Name</th>
							<th width="20%">Email Address</th>
							<th width="20%">Action</th>
			<?php
				$user = new User();
				$userdata = $user->getUserData();
				if ($userdata) {
					$i = 0;
					foreach ($userdata as $sdata) {
					$i++;
			?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $sdata['name']; ?></td>
								<td><?php echo $sdata['username']; ?></td>
								<td><?php echo $sdata['email']; ?></td>
								<td>
									<a class ="btn btn-primary" href="profile.php?id=<?php echo $sdata['id']; ?>">View</a>

								</td>
							</tr>

						<?php } } else {?>	
						<tr><td colspan="5"><h2>User Data not found.....</h2></td></tr>
						<?php } ?>
						</table>
						
					</div>
					</div>
<?php 
	include 'inc/footer.php';
 ?>
