?><?php
// cntnd_gallery_input

// includes
cInclude('module', 'includes/style.cntnd_gallery_editmode.php');
cInclude('module', 'includes/class.cntnd_gallery_input.php');

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
$langIndependent = (bool) "CMS_VALUE[6]";
$hasThumbs = (bool) "CMS_VALUE[7]";
$hasComments = (bool) "CMS_VALUE[8]";

// other vars
$uuid = rand();
$templates = Cntnd\Gallery\CntndGalleryInput::templates('cntnd_gallery', $client);
$cntndInput = new Cntnd\Gallery\CntndGalleryInput($lang, $client);

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

    <fieldset>
        <legend><?= mi18n("GALLERY") ?></legend>

        <div class="form-group">
            <label for="gallery_<?= $uuid ?>"><?= mi18n("GALLERY_FOLDER") ?></label>
            <select name="CMS_VAR[3]" id="gallery_<?= $uuid ?>" size="1">
                <option value="false"><?= mi18n("SELECT_CHOOSE") ?></option>
                <?php
                foreach ($cntndInput->folders() as $folder) {
                    $selected="";
                    if ($selectedDir==$folder){
                        $selected = 'selected="selected"';
                    }
                    echo '<option value="'.$folder.'" '.$selected.'>'.$folder.'</option>';
                }
                ?>
            </select>
        </div>

        <div class="d-flex">

            <div class="w-auto" style="align-self: center;">
                <div class="form-check form-check-inline">
                    <input id="has_thumbs_<?= $uuid ?>" class="form-check-input" type="checkbox" name="CMS_VAR[7]" value="true" <?php if($hasThumbs){ echo 'checked="checked"'; } ?> />
                    <label for="has_thumbs_<?= $uuid ?>"><?= mi18n("HAS_THUMB") ?></label>
                </div>
            </div>

            <div class="w-auto">
                <div class="form-group">
                    <label for="thumb_<?= $uuid ?>"><?= mi18n("THUMB") ?></label>
                    <input id="thumb_<?= $uuid ?>" name="CMS_VAR[4]" type="text" value="<?= $thumbDir ?>" />
                </div>
            </div>

        </div>

        <div class="form-group">
            <label for="sort_<?= $uuid ?>"><?= mi18n("SORT") ?></label>
            <select name="CMS_VAR[5]" id="sort_<?= $uuid ?>" size="1">
                <option value="ASC" <?php if ($sortDir=="ASC"){ echo 'selected="selected"'; } ?>><?= mi18n("SORT_ASC") ?></option>
                <option value="DESC" <?php if ($sortDir=="DESC"){ echo 'selected="selected"'; } ?>><?= mi18n("SORT_DESC") ?></option>
            </select>
        </div>

    </fieldset>

    <fieldset>
        <legend><?= mi18n("COMMENTS") ?></legend>

        <div class="form-check form-check-inline">
            <input id="has_comments_<?= $uuid ?>" class="form-check-input" type="checkbox" name="CMS_VAR[8]" value="true" <?php if($hasComments){ echo 'checked="checked"'; } ?> />
            <label for="has_comments_<?= $uuid ?>"><?= mi18n("HAS_COMMENTS") ?></label>
        </div>

        <div class="form-check form-check-inline">
            <input id="comments_lang_<?= $uuid ?>" class="form-check-input" type="checkbox" name="CMS_VAR[6]" value="true" <?php if($langIndependent){ echo 'checked="checked"'; } ?> />
            <label for="comments_lang_<?= $uuid ?>"><?= mi18n("COMMENT") ?></label>
            <p><small><?= mi18n("COMMENT_DESCRIPTION") ?></small></p>
        </div>
    </fieldset>

</div>
<?php
