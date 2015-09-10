<?
require("../../require/function.php");
print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!--
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2009 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * This is the sample style definitions file. It makes the styles combo
 * completely customizable.
 *
 * See FCKConfig.StylesXmlPath in the configuration file.
-->
<Styles>
	<Style name="Image lightbox" element="img">
		<Attribute name="style" value="width:<?=__widthlightbox__?>px;height:auto;margin-top:10px;margin-bottom:10px" />
		<Attribute name="align" value="left" />
		<Attribute name="class" value="imgcontent" />
	</Style>
</Styles>
