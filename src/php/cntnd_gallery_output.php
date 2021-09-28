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
$sortDir 	 = "CMS_VALUE[5]";
$langIndependent = (bool) "CMS_VALUE[6]";

// other vars
$cntndOutput = new Cntnd\Gallery\CntndGalleryOutput($idart, $lang, $client, $galleryname, $selectedDir, $thumbDir, $sortDir, $langIndependent);

// module
$formId = "GALLERY_".$galleryname;
$entryFormId = "ENTRY_".$galleryname;

if ($editmode){
    cInclude('module', 'includes/style.cntnd_gallery_editmode.php');
    cInclude('module', 'includes/script.cntnd_gallery_output.php');

    if ($_POST){
        if (array_key_exists($entryFormId.'_description',$_POST)){
            // INSERT
            $values = $_POST[$entryFormId.'_description'];
            $serializeddata = json_encode($values);
            $cntndOutput->store($serializeddata);
        }
    }

    echo '<div class="content_box"><label class="content_type_label">'.mi18n("MODULE").'</label>';
}

// load data
$cntndOutput->load();

$tpl = cSmartyFrontend::getInstance();
$tpl->assign('formId', $formId);
$tpl->assign('entryFormId', $entryFormId);
$tpl->assign('galleryname', $galleryname);
$tpl->assign('pictures', $cntndOutput->images());

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