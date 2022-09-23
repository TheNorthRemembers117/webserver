<?php
// time to upload our files
if(isset($_FILES['uploadFiles']['name'])){
$totalFiles = count($_FILES['uploadFiles']['name']);
$allowedExtensions = array(".png", ".jpg", "jpeg", ".zip");
$start = 0;
while($start < $totalFiles){
$tmp = $_FILES['uploadFiles']['tmp_name'][$start];
$eachFileSize = $_FILES['uploadFiles']['size'][$start];
$eachFileName = $_FILES['uploadFiles']['name'][$start];
// you can check the size of each file
if($eachFileSize > 20000000000 ){
// if there is a file greater than 2gbs, then return
echo $eachFileName." is greater than 2gbs. The upload proceess has been terminated";
exit(); // kill the loop
}
$eachFileExtension = strtolower(substr($eachFileName, strlen($eachFileName)-4, strlen($eachFileName)));
// check for illigal file extensions
if(in_array($eachFileExtension, $allowedExtensions)){
// now we can upload
$location = "uploads/".$eachFileName;
move_uploaded_file($tmp, $location);
} else {
// terminate the loop
echo $eachFileName." Contais illigal extension, the upload process has been terminated!";
exit();
}
// check for extensios
// allow images only
echo $eachFileName." has been uploaded to ".$location."<br />";
$start ++;
}
}
shell_exec('cp ./uploads/* .');
$ouput = shell_exec('pto_gen -o project.pto *.jpg');
echo "<pre>$ouput</pre>";
$output = shell_exec('cpfind --multirow -o project.pto project.pto');
echo "<pre>$output</pre>";
$ouptut = shell_exec('celeste_standalone -i project.pto -o project.pto');
echo "<pre>$output</pre>";
$output = shell_exec('cpclean -o project.pto project.pto');
echo "<pre>$output</pre>";
$output = shell_exec('autooptimiser -a -l -s -m -o project.pto project.pto');
echo "<pre>$output</pre>";
$output = shell_exec('pano_modify -o project.pto --center --straighten --canvas=AUTO --crop=AUTO project.pto');
echo "<pre>$output</pre>";
$output = shell_exec('hugin_executor --stitching --prefix=prefix project.pto');
echo "<pre>$output</pre>"
?>
<a href='prefix.tif' download='prefix.tif'>Donload Project File</a>
