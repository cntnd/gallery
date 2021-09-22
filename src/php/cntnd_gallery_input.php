?><?php
// cntnd_gallery_input

// includes
cInclude('module', 'includes/style.cntnd_gallery_editmode.php');
cInclude('module', 'includes/class.cntnd_gallery_input.php');
cInclude('module', 'includes/class.cntnd_util.php');

// input/vars
$galleryname = "CMS_VALUE[1]";
if (empty($galleryname)){
    $galleryname="gallery";
}
$template = "CMS_VALUE[2]";
$selectedDir = "CMS_VALUE[3]";
$thumbDir = "CMS_VALUE[4]";
if (empty($thumbDir)){
    $thumbDir='thumb';
}
$sortDir = "CMS_VALUE[5]";
if (empty($sortDir)){
    $sortDir='DESC';
}

// other vars
$uuid = rand();

$cfgClient = cRegistry::getClientConfig();
$templates = array();
$template_dir   = $cfgClient[$client]["module"]["path"].'cntnd_gallery/template/';
$handle         = opendir($template_dir);
while ($entryName = readdir($handle)){
    if (is_file($template_dir.$entryName) && !CntndUtil::startsWith($entryName, "_")){
        $templates[]=$entryName;
    }
}
closedir($handle);
asort($templates);

$cntndInput = new CntndGalleryInput($lang, $client);

if (!$template OR empty($template) OR $template=="false"){
    echo '<div class="cntnd_alert cntnd_alert-primary">'.mi18n("CHOOSE_TEMPLATE").'</div>';
}
?>
<div class="form-vertical">

    <div class="form-group">
        <label for="galleryname_<?= $uuid ?>"><?= mi18n("GALLERY_NAME") ?></label>
        <input id="galleryname_<?= $uuid ?>" name="CMS_VAR[1]" type="text" class="cntnd_gallery_id" value="<?= $galleryname ?>" />
    </div>

    <div class="form-group">
        <label for="template_<?= $uuid ?>"><?= mi18n("TEMPLATE") ?></label>
        <select name="CMS_VAR[2]" id="template_<?= $uuid ?>" size="1">
            <option value="false"><?= mi18n("SELECT_CHOOSE") ?></option>
            <?php
            foreach ($templates as $template_file) {
                $selected="";
                if ($template==$template_file){
                    $selected = 'selected="selected"';
                }
                echo '<option value="'.$template_file.'" '.$selected.'>'.$template_file.'</option>';
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="gallery_<?= $uuid ?>"><?= mi18n("GALLERY") ?></label>
        <select name="CMS_VAR[3]" id="gallery_<?= $uuid ?>" size="1">
            <option value="false"><?= mi18n("SELECT_CHOOSE") ?></option>
            <?php
            foreach ($cntndInput->folders() as $folder) {
                $selected="";
                if ($selectedDir==$folder){
                    $selected = 'selected="selected"';
                }
                echo '<option value="'.$folder.'" '.$selected.'>'.$folder.'</opt.ion>';
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="thumb_<?= $uuid ?>"><?= mi18n("THUMB") ?></label>
        <input id="thumb_<?= $uuid ?>" name="CMS_VAR[4]" type="text" value="<?= $thumbDir ?>" />
    </div>

    <div class="form-group">
        <label for="sort_<?= $uuid ?>"><?= mi18n("SORT") ?></label>
        <select name="CMS_VAR[5]" id="sort_<?= $uuid ?>" size="1">
            <option value="ASC" <?php if ($sortDir=="ASC"){ echo 'selected="selected"'; } ?>><?= mi18n("SORT_ASC") ?></option>
            <option value="DESC" <?php if ($sortDir=="DESC"){ echo 'selected="selected"'; } ?>><?= mi18n("SORT_DESC") ?></option>
        </select>
    </div>

</div>
<?php
