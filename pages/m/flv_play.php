
<?php 

if (file_exists(get_resource_path($ref,true,"pre",false,
$ffmpeg_preview_extension)))
        {
        $flashpath=get_resource_path($ref,false,"pre",false,
$ffmpeg_preview_extension,-1,1,false,"",-1,false);
	
$oggpre=get_resource_path($ref,false,"pre",false,
'ogg',-1,1,false,"",-1,false);
$mobilepre=get_resource_path($ref,false,"pre",false,
'mp4',-1,1,false,"",-1,false);
        }
else
        {
        $flashpath=get_resource_path($ref,false,"",false,
$ffmpeg_preview_extension,-1,1,false,"",-1,false);
        }
//$flashpath=urlencode($flashpath);
$flashpath=urldecode($flashpath);


$thumb=get_resource_path($ref,false,"pre",false,"jpg");
//$thumb=urlencode($thumb);
$thumb=urldecode($thumb);


	?>
	

<script src="http://vjs.zencdn.net/c/video.js"></script>
	

  <script type="text/javascript">VideoJS.setupAllWhenReady();
  	</script>
  	 
<link rel="stylesheet" href="http://vjs.zencdn.net/c/video-js.css" type="text/css" media="screen" title="Video JS">

<?php if($access==0)  {
	
 	if(isset($_GET['quality'])){
 	$mp4path = $mobilelink;
	}
	
	//echo $mp4path;
 		 ?>
 	<div class="video-js-box">
    <!-- Using the Video for Everybody Embed Code http://camendesign.com/code/video_for_everybody -->
    <video id="example_video_1" class="video-js"  controls="controls" width=100% preload="none" poster="<?php echo $thumb?>">
     <?php if($ismobile || strpos($mp4path,'.mp4') === false) { ?>
      <source src="<?php echo $mobilelink ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' /> 
      <?php } else { if(isset($mp4path)){ ?>
      <source src="<?php echo $mp4path ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' /> 
      	<?php }} ?>
      <!-- <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm; codecs="vp8, vorbis"' /> -->
      <source src="<?php echo $ogglink ?>" type='video/ogg; codecs="theora, vorbis"' />
      <!-- Flash Fallback. Use any flash video player here. Make sure to keep the vjs-flash-fallback class. -->
      <object id="flash_fallback_1" class="vjs-flash-fallback" width="<?php echo $ffmpeg_preview_max_width?>" height="<?php echo $ffmpeg_preview_max_height?>" type="application/x-shockwave-flash"
        data="../../lib/flashplayer/player_flv_maxi.swf">
        <param name="movie" value="../../lib/flashplayer/player_flv_maxi.swf" />
        <param name="allowfullscreen" value="true" />
        <param name="flashvars" value='config={"playlist":["<?php echo $thumb?>", {"url": "<?php echo $fullflashlink ?>","autoPlay":false,"autoBuffering":true}]}' />
        <!-- Image Fallback. Typically the same as the poster image. -->
        <img src="<?php echo $thumb?>" width="<?php echo $ffmpeg_preview_max_width?>" height="<?php echo $ffmpeg_preview_max_height?>" alt="Poster Image"
          title="No video playback capabilities." />
      </object>
    </video>

 	</div>	
 	<br>
 	
 	<?php if ($edit_access) { ?>
 	<div data-role="controlgroup" data-type="horizontal" data-mini="true">
 <a href="<?php echo $flashpath ?>" data-role="button" data-inline="true" <?php if(isset($flashpath)) { ?>  data-icon="check" data-theme="b" <?php } else { ?> data-icon="delete" data-theme="e" <?php } ?>  >Pre-Flash </a>
 <a href="<?php echo $oggpre ?>" data-role="button" data-inline="true" <?php if(isset($oggpre)) { ?>  data-icon="check" data-theme="b" <?php } else { ?> data-icon="delete" data-theme="e" <?php } ?>  >Pre-Ogg </a>
 <a href="<?php echo $mobilepre ?>" data-role="button" data-inline="true" <?php if(isset($mobilepre)) { ?>  data-icon="check" data-theme="b" <?php } else { ?> data-icon="delete" data-theme="e" <?php } ?>>Pre-MP4</a>
 <a href="<?php echo $fullflashlink ?>" data-role="button" data-inline="true" <?php if(isset($fullflashlink)) { ?>  data-icon="check"data-theme="b" <?php } else { ?> data-icon="delete" data-theme="e" <?php } ?>  >Flash </a>
 <a href="<?php echo $mobilelink ?>" data-role="button" data-inline="true" <?php if(isset($mobilelink)) { ?>  data-icon="check" data-theme="b" <?php } else { ?> data-icon="delete" data-theme="e" <?php } ?>  >MP4 </a>
 <a href="<?php echo $ogglink ?>" data-role="button" data-inline="true" <?php if(isset($ogglink)) { ?>  data-icon="check" data-theme="b" <?php } else { ?> data-icon="delete" data-theme="e" <?php } ?>  >Ogg </a>
	</div>
<?php } ?> 
 	 <?php  }
  else
  {  ?>
  	 	<div class="video-js-box">
    <!-- Using the Video for Everybody Embed Code http://camendesign.com/code/video_for_everybody -->
    <video id="example_video_2" class="video-js" width=100% controls="controls" preload="none" poster="<?php echo $thumb?>">
     <?php if($ismobile) { ?>
      <source src="<?php echo $mobilepre ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' /> 
      <?php } ?>
      <source src="<?php echo $oggpre ?>" type='video/ogg; codecs="theora, vorbis"' />
      <source src="<?php echo $mobilepre ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
      <!-- <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm; codecs="vp8, vorbis"' /> -->
      <!-- Flash Fallback. Use any flash video player here. Make sure to keep the vjs-flash-fallback class. -->
      <object id="flash_fallback_2" class="vjs-flash-fallback" width="<?php echo $ffmpeg_preview_max_width?>" height="<?php echo $ffmpeg_preview_max_height?>" type="application/x-shockwave-flash"
        data="../../lib/flashplayer/player_flv_maxi.swf">
        <param name="movie" value="../../lib/flashplayer/player_flv_maxi.swf" />
        <param name="allowfullscreen" value="true" />
        <param name="flashvars" value='config={"playlist":["<?php echo $thumb?>", {"url": "<?php echo $flashpath ?>","autoPlay":false,"autoBuffering":true}]}' />
        <!-- Image Fallback. Typically the same as the poster image. -->
        <img src="<?php echo $thumb?>" width="<?php echo $ffmpeg_preview_max_width?>" height="<?php echo $ffmpeg_preview_max_height?>" alt="Poster Image"
          title="No video playback capabilities." />
      </object>
    </video>
    <div style="padding: 5px">*Preview Mode Only*</div>
 	</div>	

<?php  }

echo '<h2>'. highlightkeywords(htmlspecialchars(i18n_get_translated($resource["field".$view_title_field])),$search). '</h2>';

 ?>
  
  