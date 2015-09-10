<?
define("__host__","localhost");
define("__userbdd__","root");
define("__passbdd__","mwcnewpass1");
define("__bdd__","fleet");

define("__racinebd__","phantom_");
define("__bddtype__","mysql");
define("__maxsizecarac__",80);
define("__maxelempagin__",5);
define("__racine__","/fleet/");
define("__uploaddir__",__racine__."/upload/");
define("__racineadmin__",__racine__."/admin/");
define("__libext__","/libexterne");
define("__racineadminlib__",__racineadmin__.__libext__);
define("__racineadmin2__",__racineadmin__."/home/index.php");
define("__repcustom__","/custom");
define("__repcore__","/core");
define("__arbre__","arbre2/");
define("__reparbre__",__racineadmin__."/".__arbre__);
define("__repflux__","/flux");
define("__racineadminmenu__",__racineadmin__.__repcustom__);
define("__racineadminmenucore__",__racineadmin__.__repcore__);
define("__fckdir__",__racineadminlib__."/fckeditor/");
define("__cssdir__",__racineadminmenu__."/css/");
define("__defaultlangueid__","1");
define("__parser__","index.php");
//define("__parser__","");
define("__user__","admin");
define("__pwd__","admin");
define("__showlang__",false);
define("__gabidsite__",1);
define("__cachefolder__",__racine__."/cache/");
define("__cachefolderimg__",__racine__."/cacheimg/");
define("__debugmode__",true);
//restriction ip séparé par des svirgule, vide = pas de restriction
define("__limitip__","");
define("__langueadmin__","fr");
define("__test__",false);
define("__widthlightbox__",208);
define("__showtime__",false);
define("__insertlangue__",false);

define("__light__",false);

define("PHANTOM_FULLTEXT","false");
define("PHANTOM_PARSE_MSWORD","/usr/bin/catdoc");
define("PHANTOM_OPTION_MSWORD","-s 8859-1");
define("PHANTOM_PARSE_PDF","/usr/bin/pdftotext");
define("PHANTOM_OPTION_PDF","");
define("PHANTOM_PARSE_MSEXCEL","/usr/bin/xls2csv");
define("PHANTOM_OPTION_MSEXCEL","");
define("PHANTOM_PARSE_MSPPT","/usr/bin/catdoc");
define("PHANTOM_OPTION_MSPPT","-s 8859-1");

define("__smtpmailer__",false);                //enable smtp
define("__smtpauth__",true);                  // enable SMTP authentication
define("__smtpsecure__","ssl");               // sets the prefix to the servier
define("__smtphost__","smtp.gmail.com");          // sets GMAIL as the SMTP server
define("__smtpport__",465);                       // set the SMTP port for the GMAIL server
define("__smtpusername__","intranetbyagency@gmail.com");  // User username
define("__smtppassword__","ByagencyIntranet2");          // User password
?>