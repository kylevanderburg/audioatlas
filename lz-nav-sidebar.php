<!-- Liszt Sidebar Container -->

<?php
if(empty($hammer->location[0])){$hammer->location[0]="";}
?>
<!-- Liszt Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary">
	<!-- Liszt Logo -->
	<a href="/" class="brand-link"><img src="//audioatlas.org/assets/AudioAtlas-2020-Web.png" alt="Liszt Logo" class="brand-image" style="margin-left:0px;width:65px;padding-top:5px;"><div class="brand-text"><img src="//audioatlas.org/assets/AudioAtlas-2020-Text.png" alt="Liszt Logo" style="height:30px;padding-top:6px;margin-bottom:7px;"></div></a>

	<!-- Navigation Sidebar -->
	<div class="sidebar">
		<?php /*
		<!-- Liszt User Panel -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				
			</div>
			<div class="info">
				<strong><?php echo $hammer->visitor['firstname']." ".$hammer->visitor['lastname'];?></strong>
			</div>
			
		</div>
		 */ ?>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<!--Site Menu-->
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-header"></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon fas fa-location-arrow"></i> <p>Locate me</p></a></li>
                    <li class="nav-item"><a class="nav-link" id="globe" href="#"><i class="nav-icon fas fa-globe" title="Full Map"></i> <p>Full Map</p></a></li>
                   <li class="nav-header"></li>
				   <li class="nav-item"><a class="nav-link" href="https://noteforge.com/legal/liszt-terms-of-service/"><i class="nav-icon fas fa-balance-scale" title="Full Map"></i> <p>License</p></a></li>
                    <li class="nav-item"><a class="nav-link" href="http://noteforge.com/contact/"><i class="nav-icon fas fa-envelope" title="Full Map"></i> <p>Contact</p></a></li>
               </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>