<?require("../../require/function.php")?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
top.adchildinfo('<?=($_GET["arbre_id"]==0)?"_1":$_GET["arbre_id"]?>');

function deleteimg(nodeid){
//alert(nodeid)
node=top.$("#arbre_new").dynatree("getTree").getNodeByKey(nodeid);
//alert(node)
top.copyPaste("cut", node);
top.copyPaste("paste", top.$("#arbre_new").dynatree("getTree").getNodeByKey("_2"));
window.location='listfile.php?arbre_id=<?=$_GET["arbre_id"]?>'
}
function upimg(nodeid){
  node=top.$("#arbre_new").dynatree("getTree").getNodeByKey(nodeid);
  pos = top.$.inArray(node, node.parent.childList);
  sourceNode=node.parent.childList[pos-1];
  node.setLazyNodeStatus(top.DTNodeStatus_Loading);
  top.$.ajax({
    url: '<?=__reparbre__?>/sampledrop.php',
    type: "POST",
    dataType: "json",
    data: {drop_id: node.data.key,drag_id: sourceNode.data.key,hitMode:"before"},
    success: function(data) {
      node.setLazyNodeStatus(top.DTNodeStatus_Ok);
      if(data.ok){    
        node.move(sourceNode, "before");
      }else{
        alert(data.msg)
      }
    }
  }).error(function(jqXHR, textStatus, errorThrown){
  alert(jqXHR.responseText+"erreur");
  node.setLazyNodeStatus(top.DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
  );
  window.location='listfile.php?arbre_id=<?=$_GET["arbre_id"]?>'
}
function downimg(nodeid){
  node=top.$("#arbre_new").dynatree("getTree").getNodeByKey(nodeid);
  pos = top.$.inArray(node, node.parent.childList);
  sourceNode=node.parent.childList[pos+1];
  node.setLazyNodeStatus(top.DTNodeStatus_Loading);
  top.$.ajax({
    url: '<?=__reparbre__?>/sampledrop.php',
    type: "POST",
    dataType: "json",
    data: {drag_id: node.data.key,drop_id: sourceNode.data.key,hitMode:"before"},
    success: function(data) {
      node.setLazyNodeStatus(top.DTNodeStatus_Ok);
      if(data.ok){    
        node.move(sourceNode, "after");
      }else{
        alert(data.msg)
      }
    }
  }).error(function(jqXHR, textStatus, errorThrown){
  alert(jqXHR.responseText+"erreur");
  node.setLazyNodeStatus(top.DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
  );
  window.location='listfile.php?arbre_id=<?=$_GET["arbre_id"]?>'
}
</script>
</head>
<body>
    <table>
    <?
    $_GET["version_id"]=1;
    $_GET["etat_id"]=1;
    $tbl_list=nodelist($_GET["arbre_id"]);
    for($i=0;$i<count($tbl_list);$i++){?>
    <tr><td><img src="<?=urlimg($tbl_list[$i]["content_id"],1,$tbl_list[$i]["titre1"],$tbl_list[$i]["ext"])?>" width="200"/></td>
    <td>
    <?if($i>0){?>
    <input type="button" name="Up" value="Up" onclick="upimg(<?=$tbl_list[$i]["arbre_id"]?>)"/>
    <?}?>
    </td>
    <td>
    <?if($i!=count($tbl_list)-1){?>
    <input type="button" name="Down" value="Down" onclick="downimg(<?=$tbl_list[$i]["arbre_id"]?>)"/>
    <?}?>
    </td>
    <td><input type="button" name="Delete" value="Delete" onclick="deleteimg(<?=$tbl_list[$i]["arbre_id"]?>)"/></td>    
    </tr>
    <?}?>
</body>
</html>