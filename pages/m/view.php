<?php
/**
 * View resource page
 * 
 * @package ResourceSpace
 * @subpackage Pages
 */ 
include "../../include/db.php";
include "../../include/general.php";
# External access support (authenticate only if no key provided, or if invalid access key provided)
$k=getvalescaped("k","");if (($k=="") || (!check_access_key(getvalescaped("ref",""),$k))) {include "../../include/authenticate.php";}
include "../../include/search_functions.php";
include "../../include/resource_functions.php";
include "../../include/collections_functions.php";
# Show the header/sidebar
include "header.php";


?>

<body>

 <div id="container" data-role="page">
    <header>
      <div id="header" data-role="header" data-id="header" data-position="fixed">
        <a href="http://resourcespace.org"  class="homeButton" data-role="button" data-direction="reverse"></a>
        <a href="#" data-role="button" data-role="button" class="menuButton"></a>
         
    <div style="width:200px; position: relative; margin: 0px auto;">
     <form method="post"  data-enhanced="false" action="search.php">
			<input id="ssearchbox" name="search" type="search" placeholder="Search" value=""/>
			<input type="hidden" name="resource1" value="yes" checked="true"/>
			<input type="hidden" name="resource2" value="yes" checked="true"/>
			<input type="hidden" name="resource3" value="yes" checked="true"/>
			<input type="hidden" name="resource4" value="yes" checked="true"/>
			<input type="hidden" name="resource5" value="yes" checked="true"/>
			<input type="hidden" name="resource6" value="yes" checked="true"/>
			<input type="hidden" name="resource7" value="yes" checked="true"/>
    </form>
  </div>

  
        <!--<a href="index.php" class="backButton">&laquo;</a>-->
        <!--<a href="services.php" class="nextButton">&raquo;</a>-->


			<div class="upperMenu">
        <div class="pagesMenu flexslider">
    
    <ul class="slides">
    	
        <li>
            <a href="themes.php" id="linkAbout" class="pageLink pageLink-1-1">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/home/icon-about.jpg" alt="About" />
              </div>
              <div class="titleBox">
                Free Stuff
              </div>
            </a>
        </li>
        <li>
            <a href="search.php?search=%21last1000" id="linkServices" class="pageLink pageLink-1-1">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/home/icon-services.jpg" alt="Services" />
              </div>
              <div class="titleBox">
                Recent
              </div>
            </a>
        </li>
        <li>            
            <a href="search.php?search=%21last1000&order_by=popularity&archive=0&k=" id="linkPortfolio" class="pageLink pageLink-1-1 ">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/home/icon-portfolio.jpg" alt="Portfolio" />
              </div>
              <div class="titleBox">
                Popular
              </div>
            </a>
        </li>
        <li>
            <a href="search.php?restypes=1&search=" id="linkBlog" class="pageLink pageLink-1-1">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/home/icon-blog2.jpg" alt="Blog Page" />
              </div>
              <div class="titleBox">
                Photo
              </div>
            </a>
        </li>
        <li>            
            <a href="search.php?restypes=3&search=" id="linkContact" class="pageLink pageLink-1-1 ">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/home/icon-contact.jpg" alt="Contact" />
              </div>
              <div class="titleBox">
                Video
              </div>
            </a>
        </li>
        <li>            
            <a href="search.php?restypes=2&search=" id="linkExtra1" class="pageLink pageLink-1-1">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/icon-yellow.png" alt="Sample Page 1" />
              </div>
              <div class="titleBox">
                Books
              </div>
            </a>
        </li>
                <li>            
            <a href="search.php?restypes=4&search=" id="linkExtra1" class="pageLink pageLink-1-1">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/icon-yellow.png" alt="Sample Page 1" />
              </div>
              <div class="titleBox">
                Audio
              </div>
            </a>
        </li>
                <li>            
            <a href="search.php?restypes=5&search=" id="linkExtra1" class="pageLink pageLink-1-1">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/icon-yellow.png" alt="Sample Page 1" />
              </div>
              <div class="titleBox">
                Apps
              </div>
            </a>
        </li>
                <li>            
            <a href="search.php?restypes=6&search=" id="linkExtra1" class="pageLink pageLink-1-1">
              <div class="iconBox">
                <img src="<?php echo $directory;?>/img/icon-yellow.png" alt="Sample Page 1" />
              </div>
              <div class="titleBox">
                Templates
              </div>
            </a>
        </li>
    </ul>
</div>      </div>
      </div>
    </header>
    
   <div data-role="content">

<?php

$ref=getvalescaped("ref","",true);

# fetch the current search (for finding simlar matches)
$search=getvalescaped("search","");
$order_by=getvalescaped("order_by","relevance");
$offset=getvalescaped("offset",0,true);
$restypes=getvalescaped("restypes","");
if (strpos($search,"!")!==false) {$restypes="";}
$archive=getvalescaped("archive",0,true);

$default_sort="DESC";
if (substr($order_by,0,5)=="field"){$default_sort="ASC";}
$sort=getval("sort",$default_sort);

# next / previous resource browsing
$go=getval("go","");
if ($go!="")
	{
	$origref=$ref; # Store the reference of the resource before we move, in case we need to revert this.
	
	# Re-run the search and locate the next and previous records.
	$result=do_search($search,$restypes,$order_by,$archive,240+$offset+1,$sort);
	if (is_array($result))
		{
		# Locate this resource
		$pos=-1;
		for ($n=0;$n<count($result);$n++)
			{
			if ($result[$n]["ref"]==$ref) {$pos=$n;}
			}
		if ($pos!=-1)
			{
			if (($go=="previous") && ($pos>0)) {$ref=$result[$pos-1]["ref"];}
			if (($go=="next") && ($pos<($n-1))) {$ref=$result[$pos+1]["ref"];if (($pos+1)>=($offset+72)) {$offset=$pos+1;}} # move to next page if we've advanced far enough
			}
		else
			{
			?>
			<script type="text/javascript">
			alert("<?php echo $lang["resourcenotinresults"] ?>");
			</script>
			<?php
			}
		}
	# Check access permissions for this new resource, if an external user.
	if ($k!="" && !check_access_key($ref,$k)) {$ref=$origref;} # cancel the move.
	}


# Load resource data
$resource=get_resource_data($ref);
if ($resource===false) {exit("Resource not found.");}

# Load access level
$access=get_resource_access($ref);

# contributed by field
$udata=get_user($resource["created_by"]);


# load custom access level so that we can verify if individual size restrictions
# should be overridden
# but... don't do this if user is not set - presume their access is controlled another way.
if (isset($userref))
	{
		// GIVE USER ACCESS IF THEY CREATED THIS RESOURCE
		if($resource["created_by"] == $userref)
		$access = 0;
		
	$usercustomaccess = get_custom_access_user($ref,$userref);
	} else {
	$usercustomaccess = false;
	}


# check permissions (error message is not pretty but they shouldn't ever arrive at this page unless entering a URL manually)
if ($access==2) 
		{
		exit("This is a confidential resource.");
		}
		
hook("afterpermissionscheck");
		
# Establish if this is a metadata template resource, so we can switch off certain unnecessary features
$is_template=(isset($metadata_template_resource_type) && $resource["resource_type"]==$metadata_template_resource_type);

$title_field=$view_title_field; 
# If this is a metadata template and we're using field data, change title_field to the metadata template title field
if (!$use_resource_column_data && isset($metadata_template_resource_type) && ($resource["resource_type"]==$metadata_template_resource_type))
	{
	if (isset($metadata_template_title_field)){
		$title_field=$metadata_template_title_field;
		}
	else {$default_to_standard_title=true;}	
	}

if ($pending_review_visible_to_all && isset($userref) && $resource["created_by"]!=$userref && $resource["archive"]==-1 && !checkperm("e0"))
	{
	# When users can view resources in the 'User Contributed - Pending Review' state in the main search
	# via the $pending_review_visible_to_all option, set access to restricted.
	$access=1;
	}

# If requested, refresh the collection frame (for redirects from saves)
if (getval("refreshcollectionframe","")!="")
	{
	refresh_collection_frame();
	}

# Update the hitcounts for the search keywords (if search specified)
# (important we fetch directly from $_GET and not from a cookie
$usearch=@$_GET["search"];
if ((strpos($usearch,"!")===false) && ($usearch!="")) {update_resource_keyword_hitcount($ref,$usearch);}

# Log this activity
daily_stat("Resource view",$ref);
if ($log_resource_views) {resource_log($ref,'v',0);}

if ($metadata_report && isset($exiftool_path)){
	# Include the metadata report function
	//$headerinsert.="	<script src=\"../lib/js/metadata_report.js\" type=\"text/javascript\"></script>	";
	}
	


# Load resource field data
$fields=get_resource_field_data($ref);

# Load edit access level (checking edit permissions - e0,e-1 etc. and also the group 'edit filter')
$edit_access=get_edit_access($ref,$resource["archive"],$fields);

?>



<?php if (isset($resource['is_transcoding']) && $resource['is_transcoding']==1) { ?><h3><?php echo $lang['resourceistranscoding']?></h3><?php } ?>
<?php hook("renderbeforeresourceview"); ?>

<div class="RecordResource">
<?php if (!hook("renderinnerresourceview")) { ?>
<?php if (!hook("renderinnerresourcepreview")) { ?>
<?php

$download_multisize=true;
$flvfile=get_resource_path($ref,true,"pre",false,$ffmpeg_preview_extension);
// CHANGE THESE NEWXT TWO LINES TO REFLECT YOUR CORRECT WEBSITE PATHS!!!
$weblink = "http://resourcespace.org/library/filestore/";
$toremove = '/home/resourcespace.org/public_html/library/include/../filestore/';
$noplay = 0;
if (!file_exists($flvfile)) {$noplay = 1; $flvfile=get_resource_path($ref,true,"",false,$ffmpeg_preview_extension);
	}
if (file_exists("../players/type" . $resource["resource_type"] . ".php"))
	{
	include "../../players/type" . $resource["resource_type"] . ".php";
	}
elseif (!(isset($resource['is_transcoding']) && $resource['is_transcoding']==1) && file_exists($flvfile) && (strpos(strtolower($flvfile),".".$ffmpeg_preview_extension)!==false))
	{
	# Include the Flash player if an FLV file exists for this resource.
	$download_multisize=false;
	
	
	# If configured, and if the resource itself is not an FLV file (in which case the FLV can already be downloaded), then allow the FLV file to be downloaded.
	if ($flv_preview_downloadable && $resource["file_extension"]!="flv") {$flv_download=true;}
	}
elseif ($resource["has_image"]==1)
	{
	$use_watermark=check_use_watermark();
	$imagepath=get_resource_path($ref,true,"pre",false,$resource["preview_extension"],-1,1,$use_watermark);
	if (!file_exists($imagepath))
		{
		$imageurl=get_resource_path($ref,false,"thm",false,$resource["preview_extension"],-1,1,$use_watermark);
		}
	else
		{
		$imageurl=get_resource_path($ref,false,"pre",false,$resource["preview_extension"],-1,1,$use_watermark);
		}
	
	?>
		<?php
			// HACKS MODIFICATION - HTML5 AUDIO
		if($mp3_player)
			$mp3realpath=get_resource_path($ref,true,"",false,"mp3");
		
		if(file_exists($mp3realpath))
		{ ?>
			
					<script>
					function EvalSound(soundobj) {
					  var thissound=document.getElementById(soundobj);
					   if (thissound.paused == false) {
      			this.pause();
						  } else {
						      thissound.play();
						  }
					 
					}
					</script>
			
			
			<?php
	
		if (file_exists($imagepath))
		{ 
		?><img src="<?php echo $imageurl?>" alt="<?php echo $lang["fullscreenpreview"]?>" onClick="EvalSound('audio1')" class="Picture" GALLERYIMG="no" id="previewimage" /><?php 
		}
		}
	else
		{ ?>
	<a href="preview.php?ref=<?php echo $ref?>&ext=<?php echo $resource["preview_extension"]?>&k=<?php echo $k?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>" title="<?php echo $lang["fullscreenpreview"]?>">
	
	<?php
	
		if (file_exists($imagepath))
		{ 
		?><img src="<?php echo $imageurl?>" alt="<?php echo $lang["fullscreenpreview"]?>" class="Picture" GALLERYIMG="no" width=100% id="previewimage" /><?php 
		}
	
	?></a><?php
	}
}
else
	{
	?>
	<img src="../gfx/<?php echo get_nopreview_icon($resource["resource_type"],$resource["file_extension"],false)?>" alt="" class="Picture" style="border:none;" id="previewimage" />
	<?php
	}

?>
<?php } /* End of renderinnerresourcepreview hook */ ?>

<center>
<?php hook("renderbeforerecorddownload");


if($noplay == 0) {
	
	include "flv_play.php"; 
	}

if ($mp3_player){
	//check for mp3 file and allow optional player
	$mp3path=get_resource_path($ref,false,"",false,"mp3");
	$mp3realpath=get_resource_path($ref,true,"",false,"mp3");
	
	if (file_exists($mp3realpath)){
		include "mp3_play.php";
	}
}

 } ?>
</center>

<br />
<center>

<?php if (!isset($username)){ // LOGGED OUT
	
	$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'http' : 'https';
	$host     = $_SERVER['HTTP_HOST'];
	$script   = $_SERVER['SCRIPT_NAME'];
	$params   = $_SERVER['QUERY_STRING'];
	 
	$currentUrl = $protocol . '://' . $host . $script . '?' . $params;
	$currentUrl;


	?>
	<div data-role="collapsible" data-mini="true" data-theme="b" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d">
	<h3>Login for Access</h3>
	<form id="form1" method="post" action="<?php echo $baseurl?>/login.php" target="_top">
  <input type="text" name="username" id="name" placeholder="Username"/>
  <input type="password" name="password" id="name" placeholder="Username"/>
  <input name="Submit" type="submit" value="&nbsp;&nbsp;<?php echo $lang["login"]?>&nbsp;&nbsp;" />
  </form>
	</div>
	<div data-role="controlgroup" data-type="horizontal" data-mini="true">
	<?php }else{ ?>
	
<div data-role="controlgroup" data-type="horizontal" data-mini="true">
<?php 

///////////////////  BUY NOW //////////////////////////////////
	 
	if($access == 0){ // NEEDS TO PURCHASE OR NO ACCESS 
	?>
	
	<a data-role="button" data-inline="true" data-theme="a" href="#">No Access</a>
	
	<?php	} elseif($access == 1) { // OWNS RESOURCE  
	?>
			<style>	
		.movnav .ui-btn .ui-btn-inner { padding-top: 30px !important; }
		.movnav .ui-btn .ui-icon { width: 30px!important; height: 30px!important; margin-left: -15px !important; box-shadow: none!important; -moz-box-shadow: none!important; -webkit-box-shadow: none!important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
		#share .ui-icon { background:  url(//resourcespace.org/images/icons/share.png) 50% 50% no-repeat; background-size: 20px 20px;  }
		#save .ui-icon { background:  url(//resourcespace.org/images/icons/save.png) 50% 50% no-repeat; background-size: 20px 20px;}
		#plus2 .ui-icon { background:  url(//resourcespace.org/images/icons/plus.png) 50% 50% no-repeat; background-size: 20px 20px;}
	</style>
	
	<a data-role="button" data-inline="true" data-theme="b" <?php if (!hook("downloadlink","",array("ref=" . $ref . "&k=" . $k . "&size=" . $sizes[$n]["id"] . "&ext=" . $sizes[$n]["extension"]))) { ?>href="terms.php?ref=<?php echo $ref?>&k=<?php echo $k?>&url=<?php echo urlencode("pages/download_progress.php?ref=" . $ref . "&size=" . $sizes[$n]["id"] . "&ext=" . $sizes[$n]["extension"] . "&k=" . $k . "&search=" . urlencode($search) . "&offset=" . $offset . "&archive=" . $archive . "&sort=".$sort."&order_by=" . urlencode($order_by))?>"<?php } ?> id="save" data-icon='star'>Save</a>

	<?php } }  

# ----------------------------- Resource Actions -------------------------------------
hook ("resourceactions") ?>
<?php if ($k=="") { ?>

<?php if (!hook("replaceresourceactions")) {?>
	<?php if (!checkperm("b")) { ?><span data-role="button" data-theme="b" data-inline="true"  id="plus2" data-icon="star"><?php echo add_to_collection_link($ref,$search)?><font color="FFFFFF">Add to List</font></a></span><?php } ?>
	<?php //if ($allow_share && ($access==0 || ($access==1 && $restricted_share))) { ?>
		<a data-role="button" data-inline="true" href="resource_email.php?ref=<?php echo $ref?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>" target="main" id="share" data-theme="b" data-icon="star">Share</a>
	<?php if ($edit_access) { ?>
		<a data-role="button" data-inline="true" data-theme="b" data-icon="info" href="edit.php?ref=<?php echo $ref?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>"> 
			<?php echo $lang["editresource"]?></a>
	<?php if (!checkperm("D") and !(isset($allow_resource_deletion) && !$allow_resource_deletion)){?><a data-role="button" data-theme="b" data-inline="true" href="delete.php?ref=<?php echo $ref?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>"><?php echo $lang["deleteresource"]?></a><?php } ?><?php } ?>
	<?php if (checkperm("e" . $resource["archive"])) { ?><a data-theme="b" data-role="button" data-inline="true" href="log.php?ref=<?php echo $ref?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>"><?php echo $lang["log"]?></a><?php } ?>
<?php } /* End replaceresourceactions */ 

?>
<?php } /* End if ($k!="")*/ ?>

</div>
</center>


<?php /*
if (!hook("replaceuserratingsbox")){
# Include user rating box, if enabled and the user is not external.
if (($user_rating && $k=="") && ($resource["created_by"] != $userref)) { include "user_rating.php"; }
} /* end hook replaceuserratingsbox */


if($resource["created_by"] == $userref) {?>
    <div class="DownloadDBlend">
       <p style="padding: 5px"> Thank You for contributing this resource!  To learn more about how you can profit from your contributions, please read our <a href="http://resourcespace.org/contribute">Contributions Page</a></p></div><?php } 

?>


<center>
<div data-role="controlgroup" data-type="horizontal">
<a href="view.php?ref=<?php echo $ref?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>&k=<?php echo $k?>&go=previous" data-role="button" data-icon="arrow-l" data-inline="true" data-iconpos="notext"><?php echo $lang["previousresult"]?></a>
<?php if ($k=="") { ?>

<a href="search.php?search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button" data-inline="true">View Results</a>
<?php } ?>

<a href="view.php?ref=<?php echo $ref?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>&k=<?php echo $k?>&go=next" data-role="button" data-icon="arrow-r" data-inline="true" data-iconpos="notext"><?php echo $lang["nextresult"]?></a>
</div>
</center>

<?php hook("renderbeforeresourcedetails"); ?>

<div class="content-primary">



<?php
$extra="";
/*
#  -----------------------------  Draw tabs ---------------------------
$tabname="";
$tabcount=0;
if (count($fields)>0 && $fields[0]["tab_name"]!="")
	{ ?>
	<div class="TabBar"  data-type="horizontal" data-mini="true">
	<?php
	$extra="";
	$tabname="";
	$tabcount=0;
	$tabtheme = 'a';
	for ($n=0;$n<count($fields);$n++)
		{	
		$value=$fields[$n]["value"];

		# draw new tab?
		if (($tabname!=$fields[$n]["tab_name"]) && ($value!="") && ($value!=",") && ($fields[$n]["display_field"]==1))
			{
			?><div data-role="button" data-inline="true" id="tabswitch<?php echo $tabcount?>" data-theme="c" class="Tab<?php if ($tabcount==0) { ?> TabSelected<?php } ?>"><a href="#" onclick="SelectTab(<?php echo $tabcount?>);return false;"><?php echo i18n_get_translated($fields[$n]["tab_name"])?></a></div><?php
			$tabcount++;
			$tabname=$fields[$n]["tab_name"];
			}
		}
	?>
	</div>
	<script type="text/javascript">
	function SelectTab(tab)
		{
		// Deselect all tabs
		<?php for ($n=0;$n<$tabcount;$n++) { ?>
		document.getElementById("tab<?php echo $n?>").style.display="none";
		document.getElementById("tabswitch<?php echo $n?>").className="Tab";
		<?php } ?>
		document.getElementById("tab" + tab).style.display="block;";
		document.getElementById("tabswitch" + tab).className="Tab TabSelected";
		}
	</script>
	<?php
	}
	
	
	
?>

<div id="tab0"  class="TabbedPanel<?php if ($tabcount>0) { ?> StyledTabbedPanel<?php } ?>">

<div>
<?php 
#  ----------------------------- Draw standard fields ------------------------
?>
<?php if ($show_resourceid) { ?><div class="itemNarrow"><h3><?php echo $lang["resourceid"]?></h3><p><?php echo $ref?></p></div><?php } ?>
<?php if ($show_access_field) { ?><div class="itemNarrow"><h3><?php echo $lang["access"]?></h3><p><?php echo @$lang["access" . $resource["access"]]?></p></div><?php } ?>
<?php if ($show_resource_type) { ?><div class="itemNarrow"><h3><?php echo $lang["resourcetype"]?></h3><p><?php echo  get_resource_type_name($resource["resource_type"])?></p></div><?php } ?>
<?php if ($show_hitcount){ ?><div class="itemNarrow"><h3><?php echo $resource_hit_count_on_downloads?$lang["downloads"]:$lang["hitcount"]?></h3><p><?php echo $resource["hit_count"]+$resource["new_hit_count"]?></p></div><?php } ?>
<?php hook("extrafields");?>
<?php

if ($udata!==false)
	{
	?>
<?php if ($show_contributed_by){?> <div class="itemNarrow"><h3><?php echo $lang["contributedby"]?></h3><p>
	<a href="http://resourcespace.org/profile.php?user=<?php echo highlightkeywords($udata["username"],$search)?>"><?php echo highlightkeywords($udata["fullname"],$search)?></a> 
	<?php if (checkperm("u")) { ?><a href="team/team_user_edit.php?ref=<?php echo $udata["ref"]?>"> --Edit</a><?php } ?></p></div><?php } ?>
	<?php
	}


# Show field data
$tabname="";
$tabcount=0;
$fieldcount=0;
$extra="";
for ($n=0;$n<count($fields);$n++)
	{
	$value=$fields[$n]["value"];
	
	# Handle expiry fields
	if ($fields[$n]["type"]==6 && $value!="" && $value<=date("Y-m-d") && $show_expiry_warning) 
		{
		$extra.="<div class=\"RecordStory\"> <h1>" . $lang["warningexpired"] . "</h1><p>" . $lang["warningexpiredtext"] . "</p><p id=\"WarningOK\"><a href=\"#\" onClick=\"document.getElementById('RecordDownload').style.display='block';document.getElementById('WarningOK').style.display='none';\">" . $lang["warningexpiredok"] . "</a></p></div><style>#RecordDownload {display:none;}</style>";
		}
	
	
	if (($value!="") && ($value!=",") && ($fields[$n]["display_field"]==1))
		{
		$title=htmlspecialchars(str_replace("Keywords - ","",i18n_get_translated($fields[$n]["title"])));
		if ($fields[$n]["type"]==4 || $fields[$n]["type"]==6) {$value=NiceDate($value,false,true);}

		# Value formatting
		$value=i18n_get_translated($value);
		if (($fields[$n]["type"]==2) || ($fields[$n]["type"]==3) || ($fields[$n]["type"]==7)) {$value=TidyList($value);}
		$value_unformatted=$value; # store unformatted value for replacement also
		$value=nl2br(htmlspecialchars($value));
		
		# draw new tab panel?
		if (($tabname!=$fields[$n]["tab_name"]) && ($fieldcount>0))
			{
			$tabcount++;
			# Also display the custom formatted data $extra at the bottom of this tab panel.
			?><div class="clearerleft"> </div><?php echo $extra?></div></div><div class="TabbedPanel StyledTabbedPanel" style="display:none;" data-role="button" data-inline="true" data-theme="c" id="tab<?php echo $tabcount?>"><div><?php	
			$extra="";
			}
		$tabname=$fields[$n]["tab_name"];
		$fieldcount++;		

		if (trim($fields[$n]["display_template"])!="")
			{
			# Process the value using a plugin
			$plugin="../plugins/value_filter_" . $fields[$n]["name"] . ".php";
			if (file_exists($plugin)) {include $plugin;}
			
			# Highlight keywords
			$value=highlightkeywords($value,$search,$fields[$n]["partial_index"],$fields[$n]["name"],$fields[$n]["keywords_index"]);

			# Use a display template to render this field
			$template=$fields[$n]["display_template"];
			$template=str_replace("[title]",$title,$template);
			$template=str_replace("[value]",$value,$template);
			$template=str_replace("[value_unformatted]",$value_unformatted,$template);
			$template=str_replace("[ref]",$ref,$template);
			$extra.=$template;
			}
		else
			{
			#There is a value in this field, but we also need to check again for a current-language value after the i18n_get_translated() function was called, to avoid drawing empty fields
			if ($value!=""){
				# Draw this field normally.
				
				if ($fields[$n]["type"]!=4) { // nicedate is already applied here
					# value filter plugin should be used regardless of whether a display template is used.
					$plugin="../plugins/value_filter_" . $fields[$n]["name"] . ".php";
					if (file_exists($plugin)) {include $plugin;}
				}
				# Extra word wrapping to break really large words (e.g. URLs)
				$value=wordwrap($value,20,"<br />",true);
				
				# Highlight keywords
				$value=highlightkeywords($value,$search,$fields[$n]["partial_index"],$fields[$n]["name"],$fields[$n]["keywords_index"]);
				?><div class="itemNarrow"><h3><?php echo $title?></h3><p><?php echo $value?></p></div><?php
				}
			}
		}
	}
?><?php hook("extrafields2");?>
<?php echo $extra?>
</div>
</div>
<!-- end of tabbed panel-->

<?php 

<?php hook("w2pspawn");?>

<?php 
// include collections listing
if ($view_resource_collections){ 
	include("resource_collection_list.php"); 
	}

// include optional ajax metadata report
if ($metadata_report && isset($exiftool_path) && $k==""){?>
        <div class="RecordBox">
        <div class="RecordPanel">  
        <div class="Title"><?php echo $lang['metadata-report']?></div>
        <div id="metadata_report"><a onclick="metadataReport(<?php echo $ref?>);return false;" class="itemNarrow" href="#"><?php echo $lang['viewreport'];?></a><br></div>
        </div>
        <div class="PanelShadow"></div>
        </div>

<?php } ?>
<?php 
$gps_field = sql_value('SELECT ref as value from resource_type_field '. 
                       'where name="geolocation" AND (resource_type="'.$resource['resource_type'].'" OR resource_type="0")','');
if (!$disable_geocoding && isset($gmaps_apikey) && $gps_field!=''){ ?>
    <!-- Begin Geolocation Section -->
    <div class="RecordBox">
    <div class="RecordPanel">
    <div class="Title"><?php echo $lang['location-title']; ?></div>
    <?php 
    
        $ll_field = get_data_by_field($ref, $gps_field);
        if ($ll_field!=''){
            $lat_long = explode(',', get_data_by_field($ref,$gps_field));
        ?>
            <?php if ($edit_access) { ?>
            <ul class="HorizontalNav"><li><a href="geo_edit.php?ref=<?php echo $ref; ?>"><?php echo $lang['location-edit']; ?></a></li></ul><?php } ?>
            <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $gmaps_apikey; ?>&sensor=false"
                    type="text/javascript"></script>
            <script type="text/javascript">
                function geo_loc_initialize() {
                  if (GBrowserIsCompatible()) {
                    var map = new GMap2(document.getElementById("map_canvas"));
                    latlng = new GLatLng(<?php echo $lat_long[0]; ?>, <?php echo $lat_long[1];?>);
                    marker = new GMarker(latlng)
                    map.setCenter(marker.getLatLng(), 13);
                    map.setUIToDefault();
                    map.addOverlay(marker);
                    geocoder = new GClientGeocoder;
                    geocoder.getLocations(latlng, function(response){
                        if (!response || response.Status.code != 200){
                            alert("Status Code:" + response.Status.code);
                            }
                        else {
                            place = response.Placemark[0];
                            marker.bindInfoWindowHtml(
                                    '<b>Latitude:</b> '+place.Point.coordinates[1]+'<br />' +
                                    '<b>Longitude:</b> '+place.Point.coordinates[0]+'<br />' +
                                    '<b>Address:</b> '+place.address+'<br />'+
                                    '<b>Country Code:</b> '+place.AddressDetails.Country.CountryNameCode);
                        }
                    });
                            
                       
                  }
                }
               
                Event.observe(window, 'load', geo_loc_initialize);
                Event.observe(window, 'unload', GUnload);
            </script>
            <div id="map_canvas" style="width: *; height: 300px; display:block; float:none;" class="Picture" ></div>
    <?php } else {?>
        <a href="geo_edit.php?ref=<?php echo $ref; ?>">&gt; <?php echo $lang['location-add'];?></a>
    <?php }?>
    </div>
    <div class="PanelShadow"></div>
    </div>
    <!-- End Geolocation Section -->
<?php } 
*/
?>

<?php hook("customrelations"); //For future template/spawned relations in Web to Print plugin ?>

<?php
# -------- Related Resources (must be able to search for this to work)
if (checkperm("s") && ($k=="")) {
$result=do_search("!related" . $ref);
if (count($result)>0) 
	{
	# -------- Related Resources by File Extension
	if($sort_relations_by_filetype){	
		#build array of related resources' file extensions
		for ($n=0;$n<count($result);$n++){
			$related_file_extension=$result[$n]["file_extension"];
			$related_file_extensions[]=$related_file_extension;
			}
		#reduce extensions array to unique values
		$related_file_extensions=array_unique($related_file_extensions);
		$count_extensions=0;
		foreach($related_file_extensions as $rext){
		?><!--Panel for related resources-->

		<div class="Title"><?php echo $lang["relatedresources"]?> - <?php echo strtoupper($rext);?></div>
		<div class="content-primary">	
		<ul data-role="listview">
		<?php
		# loop and display the results by file extension
		for ($n=0;$n<count($result);$n++)			
			{
				$rref=$result[$n]["ref"];	
		$height_diff = round(abs(80 / $result[$n]["thumb_height"]) * 100);
			
			if($result[$n]["thumb_width"] > 80) {
			$thumb_diff = round(abs($result[$n]["thumb_width"]) - 80);
			$img_style = "margin: 0px ". $thumb_diff/2 . " 0px " . $thumb_diff/2 .";";
			$thumb_width = '80px';
			}
			else{
			$img_style = '';
			$thumb_width = $result[$n]["thumb_width"].'px';
			}
			
			
		?>
			<li><a href="view.php?ref=<?php echo $rref; ?>">
				<?php if ($result[$n]["has_image"]==1) { ?>
				<img src="
				<?php echo get_resource_path($rref,false,"thm",false,$result[$n]["preview_extension"],-1,1,$use_watermark,$result[$n]["file_modified"])?>" style="overflow: hidden; <?php echo $img_style; ?>" height=80px width="<?php echo $thumb_width ?>">
			<?php } else { ?>  <img src="
				<?php echo get_nopreview_icon($result[$n]["resource_type"],$result[$n]["file_extension"],false) ?>" style="<?php echo $img_style; ?>" height=80px width="<?php echo $thumb_width ?>" > <?php } ?>
				<he><?php echo str_replace(array("\"","'"),"",htmlspecialchars(i18n_get_translated($result[$n]["field".$view_title_field])))?></h3>
				<p>Created by:
				<?php if($result[$n]["created_by"] == -1) 
				echo 'Matt';
				else
				echo $result[$n]["created_by"];
				 ?></p>
				<p><img src="http://normscarpetcleaning.com/wp-content/uploads/2011/02/5stars.gif"></p>
			</a>
			</li> 
			<?php
			}
		?>
		</ul>
		</div>
		<?php $count_extensions++; if ($count_extensions==count($related_file_extensions)){?><a href="search.php?search=<?php echo urlencode("!related" . $ref) ?>"><?php echo $lang["clicktoviewasresultset"]?></a><?php }?>
		
		<?php
		} #end of display loop by resource extension
	} #end of IF sorted relations
	
	
	# -------- Related Resources (Default)
	else { 
		 ?><!--Panel for related resources-->
		<div>	
		<div class="Title"><?php echo $lang["relatedresources"]?></div>
		<ul data-role="listview">
		<?php
    	# loop and display the results
    	for ($n=0;$n<count($result);$n++)            
        	{	
        		$rref=$result[$n]["ref"];
		$height_diff = round(abs(80 / $result[$n]["thumb_height"]) * 100);
			
			if($result[$n]["thumb_width"] > 80) {
			$thumb_diff = round(abs($result[$n]["thumb_width"]) - 80);
			$img_style = "margin: 0px ". $thumb_diff/2 . " 0px " . $thumb_diff/2 .";";
			$thumb_width = '80px';
			}
			else{
			$img_style = '';
			$thumb_width = $result[$n]["thumb_width"].'px';
			}
			
			
		?>
			<li><a href="view.php?ref=<?php echo $rref; ?>">
				<?php if ($result[$n]["has_image"]==1) { ?>
				<img src="<?php echo get_resource_path($rref,false,"thm",false,$result[$n]["preview_extension"],-1,1,$use_watermark,$result[$n]["file_modified"])?>" style="overflow: hidden; <?php echo $img_style; ?>" height=80px width="<?php echo $thumb_width ?>">
			<?php } else { ?>  <img src="
				<?php echo get_nopreview_icon($result[$n]["resource_type"],$result[$n]["file_extension"],false) ?>" style="<?php echo $img_style; ?>" height=80px width="<?php echo $thumb_width ?>" > <?php } ?>
				<he><?php echo str_replace(array("\"","'"),"",htmlspecialchars(i18n_get_translated($result[$n]["field".$view_title_field])))?></h3>
				<p>Created by:
				<?php if($result[$n]["created_by"] == -1) 
				echo 'Matt';
				else
				echo $result[$n]["created_by"];
				 ?></p>
				<p><img src="http://normscarpetcleaning.com/wp-content/uploads/2011/02/5stars.gif"></p>
			</a>
			</li> 
			<?php
			}
    ?>
    </ul>
		
        <a href="search.php?search=<?php echo urlencode("!related" . $ref) ?>"><?php echo $lang["clicktoviewasresultset"]?></a>

    </div>
		<?php
		}# end related resources display
	} 
	# -------- End Related Resources
	
	

if ($show_related_themes==true ){
# -------- Public Collections / Themes
$result=get_themes_by_resource($ref);
if (count($result)>0) 
	{
	?><!--Panel for related themes / collections -->

	<div class="Title"><?php echo $lang["collectionsthemes"]?></div>
	
	<ul data-role="listview">
	<?php
		# loop and display the results
		for ($n=0;$n<count($result);$n++)			
			{
			?>
			<li><a href="search.php?search=!collection<?php echo $result[$n]["ref"]?>"><?php echo (strlen($result[$n]["theme"])>0)?htmlspecialchars(str_replace("*","",$result[$n]["theme"]) . " / "):$lang["public"] . " : " . htmlspecialchars($result[$n]["fullname"] . " / ")?><?php echo htmlspecialchars($result[$n]["name"])?></a></li>
			<?php		
			}
		?>
	</ul>
	<?php
	}} 
?>

<br><br><br>

<?php if ($enable_find_similar) { ?>
<!--Panel for search for similar resources-->
<div class="Title"><?php echo $lang["searchforsimilarresources"]?></div>
<?php if ($resource["has_image"]==1) { ?>
<p>Find resources with a <a href="search.php?search=<?php echo urlencode("!rgb:" . $resource["image_red"] . "," . $resource["image_green"] . "," . $resource["image_blue"])?>">similar colour theme</a>.</p>
<p>Find resources with a <a href="search.php?search=<?php echo urlencode("!colourkey" . $resource["colour_key"]) ?>">similar colour theme (2)</a>.</p>
<?php } ?>


<form data-enhance="false" method="post" action="find_similar.php" id="findsimilar">
<input type="hidden" name="resource_type" value="<?php echo $resource["resource_type"]?>">
<input type="hidden" name="countonly" id="countonly" value="">
<?php
$keywords=get_resource_top_keywords($ref,30);
$searchwords=split_keywords($search);
for ($n=0;$n<count($keywords);$n++)
	{
	?>
	<input type="checkbox" name="keyword_<?php echo urlencode($keywords[$n])?>" value="yes" data-mini="true"
	<?php if (in_array($keywords[$n],$searchwords)) {?>checked<?php } ?>>
	<label for="keyword_<?php echo urlencode($keywords[$n])?>"><?php echo $keywords[$n]?></label>
	<?php
	}
?>

<br />
<input name="search" type="submit" value="&nbsp;&nbsp;<?php echo $lang["deleteresource"]?>&nbsp;&nbsp;" id="dosearch"/>
<iframe src="blank.html" frameborder=0 scrolling=no width=1 height=1 style="visibility:hidden;" name="resultcount" id="resultcount"></iframe>
</form>
</div>
<?php } ?>



<?php } # end of block that requires search permissions?>

<?php
include "footer.php";
?>
