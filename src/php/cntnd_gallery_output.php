<?php
// cntnd_html_output

// assert framework initialization
defined('CON_FRAMEWORK') || die('Illegal call: Missing framework initialization - request aborted.');

// editmode
$editmode = cRegistry::isBackendEditMode();

// input/vars
$truncate = (bool) "CMS_VALUE[1]";
$lines = (int) "CMS_VALUE[2]";
if (empty($lines)){
  $lines = 5;
}
$own_js = (bool) "CMS_VALUE[3]";

$text = "CMS_HTML[1]";

// includes
if (!$editmode && $truncate){
	cInclude('module', 'includes/script.cntnd_gallery_output-or-input.php');
}

// module
if ($editmode){
	echo '<div class="content_box"><label class="content_type_label">'.mi18n("MODULE").'</label>';
}

$tpl = cSmartyFrontend::getInstance();
$tpl->assign('truncate', $truncate);
$tpl->assign('uuid', 'idart'.$idart);
$tpl->assign('text', $text);
$tpl->display('default.html');

if ($editmode){
  echo '</div>';
}
if (!$editmode && $truncate){
?>
<script>
$(document).ready(function() {
  $('.truncate').trunk8({
     lines: <?= $lines ?>,
     parseHTML: true,
     tooltip: false,
     fill: '&hellip;'
  });
  <?php if(!$own_js){ ?>
  $('.read-more').click(function(){
    $('#truncate-'+$(this).attr('target')).trunk8('revert');
    $(this).hide();
    $('.read-less[target='+$(this).attr('target')+']').show();
  });

  $('.read-less').click(function(){
      $('#truncate-'+$(this).attr('target')).trunk8();
      $(this).hide();
      $('.read-more[target='+$(this).attr('target')+']').show();
  });
  <?php } ?>
});
</script>
<?php } ?>
