<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>View</title>
<LINK rel=stylesheet href="../../css/<?=$_GET["css"]?>" type="text/css">
</head>
<body>
<script>
content=window.top.document.getElementById("<?=$_GET["elem"]?>").value
document.write(content);
</script>
</body>
</html>
