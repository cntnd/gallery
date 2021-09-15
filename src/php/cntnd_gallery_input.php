?><?php
// cntnd_html_input

// input/vars
$uuid = rand();
$truncate = (bool) "CMS_VALUE[1]";
$lines = (int) "CMS_VALUE[2]";
$own_js = (bool) "CMS_VALUE[3]";

// includes
cInclude('module', 'includes/style.cntnd_gallery_output-or-input.php');

?>
<div class="form-vertical">
  <div class="form-check form-check-inline">
    <input id="truncate_<?= $uuid ?>" class="form-check-input" type="checkbox" name="CMS_VAR[1]" value="true" <?php if($truncate){ echo 'checked'; } ?> />
    <label for="truncate_<?= $uuid ?>"><?= mi18n("TRUNCATE") ?></label>
  </div>

  <div class="form-group">
    <label for="lines_<?= $uuid ?>"><?= mi18n("TRUNCATE_LINES") ?></label>
    <input id="lines_<?= $uuid ?>" name="CMS_VAR[2]" type="number" value="<?= $lines ?>" />
  </div>

  <div class="form-check form-check-inline">
    <input id="ownjs_<?= $uuid ?>" class="form-check-input" type="checkbox" name="CMS_VAR[3]" value="true" <?php if($own_js){ echo 'checked'; } ?> />
    <label for="ownjs_<?= $uuid ?>"><?= mi18n("TRUNCATE_OWNJS") ?></label>
  </div>
</div>
<?php
