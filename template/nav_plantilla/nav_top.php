<?php


?>
<div class="brand">
				<!-- <a href="index.html"><img src="assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a> -->
                <p><?php echo $nombre_negocio; ?></p>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>

				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<!-- <img src="assets/img/user.png" class="img-circle" alt="Avatar"> -->
								<span><?php echo @$_SESSION['nombre_usuario']; ?></span>
								 <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<!-- <li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile - En construccion</span></a></li>
								<li><a href="#"><i class="lnr lnr-cog"></i> <span>Config - En construccion</span></a></li> -->
								<li><a href="#"><i class="lnr lnr-cog"></i> <span><?php echo $_SESSION['token_temp_entrada']; ?></span></a></li>
								<li><a href="../src_php/salir.php"><i class="lnr lnr-exit"></i> <span>Cerrar Sesión</span></a></li>
							</ul>
						</li>
						<!-- <li>
							<a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
						</li> -->
					</ul>
				</div>
			</div>