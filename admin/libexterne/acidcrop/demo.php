<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ajax Crop v0.5</title>
<link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" /> 
<link rel="stylesheet" type="text/css" href="css/styles.css" /> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
</head>

<body>

	<div id="title">
    	<h1>Ajax Crop <span class="small">v0.5 by keithics</span></h1>
    </div>

<div id="wrap">
    
    <div id="uploader">
    	
        <div id="big_uploader">
            <form name="upload_big" id="upload_big"  method="post" enctype="multipart/form-data" action="upload.php?act=upload" target="upload_target">
              <label for="photo">1. Upload An Image : <input name="photo" id="file" size="27" type="file" /></label>
               Height: <input type="text" name="height" value="450" size="5"/>
               Width: <input type="text" name="width" value="450" size="5" />              
              <input type="submit" name="action" value="Upload" />
            </form>
    	</div><!-- big_uploader -->
        <div id="notice">Digesting..</div>
        <div id="content">
        <img src="images/top.jpg" width="798" height="38" alt="_" />
			<div id="uploaded">
	   	      <h3>2. Uploaded Image - click and set the thumbnail dimension</h3>
                	<div id="div_upload_big"></div>
                	
                    <form name="upload_thumb" id="upload_thumb" method="post" action="upload.php?act=thumb" target="upload_target">

                        <input type="hidden" name="img_src" id="img_src" class="img_src" /> 
                        <input type="hidden" name="height" value="0" id="height" class="height" />
                        <input type="hidden" name="width" value="0" id="width" class="width" />
                            
                         <input type="hidden" id="y1" class="y1" name="y" />
                         <input type="hidden" id="x1" class="x1" name="x" />
                         <input type="hidden" id="y2" class="y2" name="y1" />
                         <input type="hidden" id="x2" class="x2" name="x1" />                         
                          <input type="submit" value="create thumbnail" />
                    </form>

                    
          </div><!-- uploaded-->

		  <div id="thumbnail">
                     <h3>Preview</h3>
                     <div id="preview"></div>       
                            
                	<h3>Thumbnail</h3>
                    <div id="div_upload_thumb"></div>
                    
                    <div id="details">
                    	<table width="200">
                        	<tr>
                            	<td colspan="2">Image Source<br /><input type="text" name="img_src" class="img_src" size="35" /></td>
                            </tr>
                            <tr>
                            	<td>Height<br /><input type="text" name="height" class="height" size="5" /></td>
                                <td>Width<br /><input type="text" name="width" class="width" size="5"/></td>
                           </tr>
                           <tr>
                           		<td>Y1<br /><input type="text" class="y1"  size="5"/></td>
                                <td>X1<br /><input type="text" class="x1" size="5" /></td>
                           </tr>
                           <tr>
                           		<td>Y2<br /><input type="text" class="y2" size="5" /></td>
                                <td>X2<br /><input type="text" class="x2" size="5" /></td>
                           </tr>
                       </table>

                    </div>
                    
          </div><!-- thumbnail -->
      		<img src="images/btm.jpg" width="798" height="19" alt="_" />
      </div><!-- content -->
        <iframe id="upload_target" name="upload_target" src="" style="width:100%;height:400px;border:1px solid #ccc; display:none"></iframe>
        <!-- this is the secret iframe :) -->
        
    </div><!-- uploader -->


</div><!-- wrap -->

</body>
</html>