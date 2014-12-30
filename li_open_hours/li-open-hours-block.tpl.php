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
<div id="loh-open-hours-block" class="loh-block">
  <div class="loh-header">
    <span class="loh-header-week"><?php echo $header_week ?></span>
    <span class="loh-header-date"><?php echo $header_date ?></span>
  </div>
  <?php foreach ($rows as $day) { ?>
  <div class="loh-row">
      <span class="loh-label"><?php echo $day['day'] ?></span>
      <span class="loh-times">
        <span class="loh-times"><?php echo $day['start_time'] ?></span>
        <?php if (!empty($day['end_time'])) { echo ' - '; } ?>
        <span class="loh-times"><?php echo $day['end_time'] ?></span>
      </span>
  </div>
  <?php } ?>
  <div class="loh-link-line">
    <span class="loh-prev"><a href="<?php echo $prev_link_url; ?>" class="<?php echo $prev_link_class; ?>"><?php echo t('Previous'); ?></a></span>
    <span class="loh-next"><a href="<?php echo $next_link_url; ?>" class="<?php echo $next_link_class ?>"><?php echo t('Next'); ?></a></span>
  </div>
</div>
