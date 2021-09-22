<?php

include_once("class.cntnd_util.php");

/**
 * cntnd_gallery Output Class
 */
class CntndGalleryOutput {

  private $idart;
  private $lang;
  private $client;
  private $galleryname;
  private $db;
  private $comments=array();
  private $commentFile;
  private $images=array();
  private $thumb;
  private $imagetypes=array('jpeg','jpg','gif','png');
  private $sort;
  private $uploadDir;
  private $uploadPath;
  private $folder;

  function __construct($idart, $lang, $client, $galleryname, $folder, $thumb, $sort, $commentFile = null) {
    $this->idart = $idart;
    $this->lang = $lang;
    $this->client = $client;
    $this->galleryname = $galleryname;
    $this->db = new cDb;

    $cfgClient = cRegistry::getClientConfig();
    $this->uploadDir = $cfgClient[$client]["upl"]["htmlpath"];
    $this->uploadPath = $cfgClient[$client]["upl"]["path"];
    $this->folder = $folder;

    $this->thumb = $thumb;
    if (!CntndUtil::endsWith($thumb, "/")){
      $this->thumb = $thumb."/";
    }
    $this->sort = $sort;
    $this->commentFile=$commentFile;
  }

  public function images(){
    return $this->images;
  }

  private function createComments($filename = null){
    $comments=array();
    if (!empty($filename)) {
      $commentFile = $this->uploadPath . $this->folder . $filename;
      if (file_exists($commentFile)) {
        foreach(file($commentFile, FILE_IGNORE_NEW_LINES) as $line){
            $values = explode("=", $line);
            $comments[$values[0]]=$values[1];
        }
      }
    }
    else {
      $comments = $this->loadComments();
    }
    return $comments;
  }

  private function loadComments(){
    $data=array();

    $sql = "SELECT serializeddata FROM cntnd_gallery WHERE galleryname=':galleryname' AND idart=:idart AND idlang=:idlang";
    $values = array(
        'galleryname' => cSecurity::toString($this->galleryname),
        'idart' => cSecurity::toInteger($this->idart),
        'idlang' => cSecurity::toInteger($this->lang)
    );
    $this->db->query($sql, $values);
    while ($this->db->nextRecord()) {
      if (is_string($this->db->f('serializeddata'))){
        $data = CntndUtil::unescapeData($this->db->f('serializeddata'));
      }
    }
    return $data;
  }

  public function store($data){
    $values = array(
        'galleryname' => cSecurity::toString($this->galleryname),
        'idart' => cSecurity::toInteger($this->idart),
        'idlang' => cSecurity::toInteger($this->lang),
        'data' => CntndUtil::escapeData($data)
    );
    $this->db->query("SELECT idgallery FROM cntnd_gallery WHERE galleryname=':galleryname' AND idart=:idart AND idlang=:idlang", $values);
    if (!$this->db->nextRecord()){
      $sql = "INSERT INTO cntnd_gallery (galleryname, idart, idlang, serializeddata) VALUES (':galleryname',:idart,:idlang,':data')";
    }
    else {
      $sql = "UPDATE cntnd_gallery SET serializeddata=':data' WHERE galleryname=':galleryname' AND idart=:idart AND idlang=:idlang";
    }
    $this->db->query($sql, $values);
  }

  public function load(){
    // comments
    $comments = $this->createComments($this->commentFile);

    // images
    $cfg = cRegistry::getConfig();

    $sql = "SELECT * FROM :table WHERE idclient=:idclient AND dirname=':dirname' ORDER BY filename :sort";
    $values = array(
        'table' => $cfg['tab']['upl'],
        'idclient' => cSecurity::toInteger($this->client),
        'dirname' => cSecurity::toString($this->folder),
        'sort' => cSecurity::toString($this->sort)
    );
    $this->db->query($sql, $values);
    while ($this->db->nextRecord()) {
      // Bilder
      if (in_array($this->db->f('filetype'),$this->imagetypes)){
        $image = $this->uploadDir.$this->db->f('dirname').$this->db->f('filename');
        $thumb_image = $this->uploadDir.$this->db->f('dirname').$this->thumb.$this->db->f('filename');
        $this->images[$this->db->f('idupl')] = array (
            'image' => $image,
            'thumb' => $thumb_image,
            'filename' => $this->db->f('filename'),
            'description' => $comments[$this->db->f('filename')]);
      }
    }
  }
}

?>
