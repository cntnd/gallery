<style>
<?php
$mod = new cApiModule($cCurrentModule);
echo file_get_contents($cfgClient[$client]["module"]["path"].'/'.$mod->get("alias").'/css/'.$mod->get("alias").'.css')
?>
</style>
