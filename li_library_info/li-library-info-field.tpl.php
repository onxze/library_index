<?php
/*
 * @file
 * Libary information field template.
 * 
 * $header_week   Week for period
 * $header_date   Date for period
 * $rows          Array for day and open hours two elements day and times.
 */
?>
<div class="lli-field">
	<h2><?php echo $library_name; ?></h2>

	<h3><?php echo $library_telephones; ?></h3>
	<table><tr>
	<?php for ($i = 0; $i < count($library_tels); $i++) { ?>
		<td><?php echo $library_tels[$i]; ?></div>
		<?php if (($i + 1) % 3 == 0) { echo '</tr><tr>'; } ?>
	<?php } ?>
	</tr></table>

	<div class="lli-visit-address">
	<h3><?php echo $library_visit_address; ?></h3>
  <div><?php echo $library_vaddress_street; ?></div>
  <div><?php echo $library_vaddress_area; ?></div>
  <div><?php echo $library_vaddress_zipcode; ?></div>
  <div><?php echo $library_vaddress_city; ?></div>
  <!--<div><?php echo $library_coord_lat . ', ' . $library_coord_lon; ?></div>-->
  </div>
  
  <div class="lli-mail-address">
  <h3><?php echo $library_visit_postal; ?></h3>
  <div><?php echo $library_paddress_post_box; ?></div>
  <div><?php echo $library_paddress_post_address; ?></div>
  <div><?php echo $library_paddress_post_office; ?></div>
  <div><?php echo $library_paddress_zipcode; ?></div>
	</div>
</div>
