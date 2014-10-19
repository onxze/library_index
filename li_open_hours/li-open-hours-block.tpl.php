<?php
/*
 * @file
 * Libary open hours block template.
 * 
 * $header_week   Week for period
 * $header_date   Date for period
 * $rows          Array for day and open hours two elements day and times.
 */
?>
<div class="loh_block">
  <div class="loh_header">
    <span class="loh-header-week"><?php echo $header_week ?></span>
    <span class="loh-header-date"><?php echo $header_date ?></span>
  </div>
  <?php foreach ($rows as $day) { ?>
  <div class="loh_row">
      <span class="loh-label"><?php echo $day['day'] ?></span>
      <span class="loh-times">
        <span class="loh-times"><?php echo $day['start_time'] ?></span>
        <?php if (!empty($day['end_time'])) { echo ' - '; } ?>
        <span class="loh-times"><?php echo $day['end_time'] ?></span>
      </span>
  </div>
  <?php } ?>
</div>
