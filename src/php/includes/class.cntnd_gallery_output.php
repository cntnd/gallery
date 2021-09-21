<?php

include_once("class.cntnd_util.php");

/**
 * cntnd_gallery Output Class
 */
class CntndGalleryOutput {

  private $lang;
  private $client;
  private $db;
  private $images=array();
  private $imagetypes=array('jpeg','jpg','gif','png');

  private $uploadDir;
  private $uploadPath;

  function __construct($lang, $client, $folder, $thumb, $sort) {
    $this->lang = $lang;
    $this->client = $client;
    $this->db = new cDb;

    $cfgClient = cRegistry::getClientConfig();
    $this->uploadDir = $cfgClient[$client]["upl"]["htmlpath"];
    $this->uploadPath = $cfgClient[$client]["upl"]["path"];

    // thumb
    if (!CntndUtil::endsWith($thumb, "/")){
        $thumb = $thumb."/";
    }

    // images
    $cfg = cRegistry::getConfig();

    $sql = "SELECT * FROM :table WHERE idclient=:idclient AND dirname=':dirname' AND filetype != '' ORDER BY filename :sort";
    $values = array(
        'table' => $cfg['tab']['upl'],
        'idclient' => cSecurity::toInteger($client),
        'dirname' => cSecurity::toString($folder),
        'sort' => cSecurity::toString($sort)
    );
    $this->db->query($sql, $values);
    while ($this->db->nextRecord()) {
      // Bilder
      if (in_array($this->db->f('filetype'),$this->imagetypes)){
        $image = $this->uploadDir.$this->db->f('dirname').$this->db->f('filename');
        $thumb_image = $this->uploadDir.$this->db->f('dirname').$thumb.$this->db->f('filename');
        $this->images[$this->db->f('idupl')] = array ('image' => $image, 'thumb' => $thumb_image);
      }
    }
  }

  public function images(){
    return $this->images;
  }
}

?>
