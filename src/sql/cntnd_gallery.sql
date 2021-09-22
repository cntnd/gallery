CREATE TABLE IF NOT EXISTS cntnd_gallery (
  idgallery int(11) NOT NULL AUTO_INCREMENT,
  galleryname varchar(200) NOT NULL,
  idart int(11) NOT NULL,
  idlang int(11) NOT NULL,
  serializeddata longtext,
  PRIMARY KEY (idgallery)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;
