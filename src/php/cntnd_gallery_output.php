<?php
// cntnd_gallery_output

// includes
cInclude('module', 'includes/class.cntnd_gallery_output.php');

// assert framework initialization
defined('CON_FRAMEWORK') || die('Illegal call: Missing framework initialization - request aborted.');

// editmode
$editmode = cRegistry::isBackendEditMode();

// input/vars
$galleryname = "CMS_VALUE[1]";
$template 	 = "CMS_VALUE[2]";
$selectedDir = "CMS_VALUE[3]";
$thumbDir    = "CMS_VALUE[4]";
$maxImgPerRow= "CMS_VALUE[5]";
$mobileMaxImgPerRow = "CMS_VALUE[6]";
$sortDir 	 = "CMS_VALUE[7]";

// other vars
$cntndOutput = new CntndGalleryOutput($lang, $client, $selectedDir, $thumbDir, $sortDir);

// module
if ($editmode){
    cInclude('module', 'includes/style.cntnd_gallery_output-or-input.php');

    echo '<div class="content_box"><label class="content_type_label">'.mi18n("MODULE").'</label>';
}

$tpl = cSmartyFrontend::getInstance();
$tpl->assign('galleryname', $galleryname);
$tpl->assign('pictures', $cntndOutput->images());
$tpl->assign('maxImgPerRow', $maxImgPerRow);
$tpl->assign('mobileMaxImgPerRow', $mobileMaxImgPerRow);
//$tpl->assign('description', $description);


if (cRegistry::isBackendEditMode()) {
    $tpl->display('_editor.html');
}
else {
    $tpl->display($template);
}

if ($editmode){
  echo '</div>';
}
?>