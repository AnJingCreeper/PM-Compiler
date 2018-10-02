#PocketMine-PM服务器插件打包工具
#作者：Dream Block Resource Team 安静
#说明：该工具基于PocketMine团队的DevTools制作，用于打包PocketMine 服务器插件
#DBRT交流群：542391871
**********************************
**********************************
<?php
$pluginfolder=array();
$tocompilepath=realpath("tocompile");
$compiledpath=realpath("compiled");
echo "检测文件中...\n";
if (is_dir($tocompilepath)){
  if ($dh = opendir($tocompilepath)){
	  $i=0;
    while (($pluginfolder[$i]= readdir($dh))!==false){
			echo "[".($i+1)."]".$pluginfolder[$i]."\n";
			$i++;
    }
    closedir($dh);
  }
}
$pluginpath=$tocompilepath."\\".$pluginfolder[2];
$pharname=$pluginfolder[2].".phar";
echo "正在创建".$pharname."...\n";
$phar=new \Phar("compiled/".$pharname);
$phar->setStub('<?php echo "Plugin Compile Tool Created by DBRT An_Jing";__HALT_COMPILER();');
$phar->setSignatureAlgorithm(\Phar::SHA1);
$phar->startBuffering();
$count=0;
$maxlen=0;
echo "正在添加文件...\n";
foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($pluginpath)) as $file)
{
	
	$path=rtrim(str_replace(array("\\",$pluginpath), array("/", ""), $file), "/");
	$path=strstr($path,"tocompile");
	$path=strstr($path,"/");
	$path=substr($path,1);
	$path=strstr($path,"/");
	$path=substr($path,1);
	if($path{0} === "." or strpos($path, "/.") !== false){
		continue;
	}
	if(strpos($path, "bin") !== false){
		continue;
	}
	if(strpos($path, ".md") !== false){
		continue;
	}
	if(strpos($path, ".cmd") !== false){
		continue;
	}
	if(strpos($path, ".lnk") !== false){
		continue;
	}
	$phar->addFile($file, $path);
	if(strlen($path) > $maxlen){
		$maxlen = strlen($path);
	}
	echo "\r[".(++$count)."]".str_pad($path,$maxlen," ");
}
echo "\n压缩中...\n";
$phar->compressFiles(\Phar::GZ);
$phar->stopBuffering();
$pharpath = realpath("compiled/".$pharname);
echo $pharname."打包成功 ! Phar文件创建在".$pharpath."\n";
exec("pause");


?>