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

	<?php
	if (isset($library_open_hours)) {
		echo '<div class="lli-open-hours">';
		echo $library_open_hours;
		echo '</div>';
	}
	?>

	<?php if (isset($library_image_file)) { ?>
	<div class="lli-library-image">
		<img src="<?php echo $library_image_file; ?>" alt="<?php echo $library_image_alt; ?>" />
	</div>
	<?php } ?>

	<h3><?php echo $library_telephones; ?></h3>
	<div class="lli-telephones">
	<?php foreach ($library_tels as $tel) { ?>
		<div class="lli-tel-row"><span class="lli-tel-title"><?php echo $tel['title']; ?></span class="lli-tel-number"<span><?php echo $tel['number']; ?></span></div>
	<?php } ?>
	</div>

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
