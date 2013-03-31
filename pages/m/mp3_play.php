<?php 

	$altfiles=get_alternative_files($ref);
	for ($n=0;$n<count($altfiles);$n++)
		{

		if($altfiles[$n]["file_extension"] == "ogg"){
				$oggmlink=get_resource_path($ref,true,'',false,"ogg",-1,1,false,$altfiles[$n]["creation_date"],$altfiles[$n]["ref"]);
				$oggmlink = str_replace($toremove, $weblink, $oggmlink);
		}
	}
		
		
  	?>


<audio id="audio1" controls preload="auto" autobuffer>
	<?php if(isset($oggmlink)) {?>
	<source src="<?php echo $oggmlink?>" type="audio/ogg" />
	<?php } ?>
  <source src="<?php echo $mp3path?>" type="audio/mpeg" />
 Your browser does not support the audio element.
 </audio>

