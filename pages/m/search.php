<?php
ob_start();
include "../../include/db.php";
include "../../include/general.php";
include "../../include/resource_functions.php"; //for checking scr access
include "../../include/search_functions.php";
include "../../include/collections_functions.php";
include "header.php"; 
?>
<body>
	<div id="splash" class="splash" data-position="fixed" data-id="splash"> 
  <img id="splashBg" src="img/splash.jpg" alt="Splash Image" />
  <img id="splashTitle" src="img/splashTitle.png" alt="Splash Title" />
</div>

 <div id="container" data-role="page">
    <header>
      <div id="header" data-role="header" data-id="header" data-position="fixed">
        <a href="http://ResourceSpace.org"  class="homeButton" data-role="button" data-direction="reverse"></a>
        <a href="#" data-role="button" data-role="button" class="menuButton"></a>
         
    <div style="width:200px; position: relative; margin: 0px auto;">
     <form id="ssearch2" method="post" data-enhanced="false" action="search.php">
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

    
                
		
<?php
# External access support (authenticate only if no key provided, or if invalid access key provided)
$k=getvalescaped("k","");if (($k=="") || (!check_access_key_collection(str_replace("!collection","",getvalescaped("search","")),$k))) {include "../../include/authenticate.php";}

 # Disable info box for external users.
if ($k!="") {$infobox=false;}
else {
       #note current user collection for add/remove links
       $user=get_user($userref);$usercollection=$user['current_collection'];
}
# Disable checkboxes for external users.
if ($k!="") {$use_checkboxes_for_selection=false;}

$search=getvalescaped("search","");

# create a display_fields array with information needed for detailed field highlighting
$df=array();

if (isset($metadata_template_resource_type) && isset($metadata_template_title_field)){
	$thumbs_display_fields[]=$metadata_template_title_field;
	}
$all_field_info=get_fields_for_search_display(array_unique(array_merge($thumbs_display_fields,$list_display_fields,$xl_thumbs_display_fields,$small_thumbs_display_fields)));

# get display and normalize display specific variables
$display=getvalescaped("display",$default_display);setcookie("display",$display);

if ($display=="thumbs"){ 
	$display_fields	= $thumbs_display_fields;  
	if (isset($search_result_title_height)) { $result_title_height = $search_result_title_height; }
	$results_title_trim = $search_results_title_trim;
	$results_title_wordwrap	= $search_results_title_wordwrap;
	}
	
if ($display=="list"){ 
	$display_fields	= $list_display_fields; 
	$results_title_trim = $search_results_title_trim;
	}
	
if ($display=="smallthumbs"){ 
	$display_fields	= $small_thumbs_display_fields; 
	if (isset($small_search_result_title_height)) { $result_title_height = $small_search_result_title_height; }
	$results_title_trim = $small_search_results_title_trim;
	$results_title_wordwrap = $small_search_results_title_wordwrap;
	}
if ($display=="xlthumbs"){ 
	$display_fields = $xl_thumbs_display_fields;
	if (isset($xl_search_result_title_height)) { $result_title_height = $xl_search_result_title_height; }
	$results_title_trim = $xl_search_results_title_trim;
	$results_title_wordwrap = $xl_search_results_title_wordwrap;
	}

$n=0;
foreach ($display_fields as $display_field)
	{
	# Find field in selected list
	for ($m=0;$m<count($all_field_info);$m++)
		{
		if ($all_field_info[$m]["ref"]==$display_field)
			{
			$field_info=$all_field_info[$m];
			$df[$n]['ref']=$display_field;
			$df[$n]['indexed']=$field_info['keywords_index'];
			$df[$n]['partial_index']=$field_info['partial_index'];
			$df[$n]['name']=$field_info['name'];
			$df[$n]['title']=$field_info['title'];
			$n++;
			}
		}
	}
$n=0;	


# create a sort_fields array with information for sort fields
$n=0;
$sf=array();
foreach ($sort_fields as $sort_field)
	{
	# Find field in selected list
	for ($m=0;$m<count($all_field_info);$m++)
		{
		if ($all_field_info[$m]["ref"]==$sort_field)
			{
			$field_info=$all_field_info[$m];
			$sf[$n]['ref']=$sort_field;
			$sf[$n]['title']=$field_info['title'];
			$n++;
			}
		}
	}
$n=0;	

# Append extra search parameters from the quick search.
if (!is_numeric($search)) # Don't do this when the search query is numeric, as users typically expect numeric searches to return the resource with that ID and ignore country/date filters.
	{
	// For the simple search fields, collect from the GET request and assemble into the search string.
	reset ($_GET);

	foreach ($_GET as $key=>$value)
		{
		$value=trim($value);
		if ($value!="" && substr($key,0,6)=="field_")
			{
			if (strpos($key,"_year")!==false)
				{
				# Date field
				
				# Construct the date from the supplied dropdown values
				$key_month=str_replace("_year","_month",$key);
				if (getval($key_month,"")!="") {$value.="-" . getval($key_month,"");}

				$key_day=str_replace("_year","_day",$key);
				if (getval($key_day,"")!="") {$value.="-" . getval($key_day,"");}
				
				$search=(($search=="")?"":join(", ",split_keywords($search)) . ", ") . str_replace("_year","",substr($key,6)) . ":" . $value;
				}
			elseif (strpos($key,"_drop_")!==false)
				{
				# Dropdown field
				# Add keyword exactly as it is as the full value is indexed as a single keyword for dropdown boxes.
				$search=(($search=="")?"":join(", ",split_keywords($search)) . ", ") . substr($key,11) . ":" . $value;
				}		
			elseif (strpos($key,"_month")===false && strpos($key,"_day")===false)
				{
				# Standard field
				$values=explode(" ",$value);
				foreach ($values as $value)
					{
					# Standard field
					$search=(($search=="")?"":join(", ",split_keywords($search)) . ", ") . substr($key,6) . ":" . $value;
					}
				}
			}
		}

	$year=getvalescaped("year","");
	if ($year!="") {$search=(($search=="")?"":join(", ",split_keywords($search)) . ", ") . "year:" . $year;}
	$month=getvalescaped("month","");
	if ($month!="") {$search=(($search=="")?"":join(", ",split_keywords($search)) . ", ") . "month:" . $month;}
	$day=getvalescaped("day","");
	if ($day!="") {$search=(($search=="")?"":join(", ",split_keywords($search)) . ", ") . "day:" . $day;}
	}

$searchresourceid = "";
if (is_numeric(getval("searchresourceid",""))){
	$searchresourceid = getval("searchresourceid","");
	$search = "!resource$searchresourceid";
}
	
hook("searchstringprocessing");


# Fetch and set the values
if (strpos($search,"!")===false) {setcookie("search",$search);} # store the search in a cookie if not a special search
$offset=getvalescaped("offset",0);if (strpos($search,"!")===false) {setcookie("saved_offset",$offset);}
if ((!is_numeric($offset)) || ($offset<0)) {$offset=0;}
$order_by=getvalescaped("order_by",$default_sort);if (strpos($search,"!")===false) {setcookie("saved_order_by",$order_by);}
if ($order_by=="") {$order_by=$default_sort;}
$per_page=getvalescaped("per_page",$default_perpage);setcookie("per_page",$per_page);
$archive=getvalescaped("archive",0);if (strpos($search,"!")===false) {setcookie("saved_archive",$archive);}
$jumpcount=0;

# Most sorts such as popularity, date, and ID should be descending by default,
# but it seems custom display fields like title or country should be the opposite.
$default_sort="DESC";
if (substr($order_by,0,5)=="field"){$default_sort="ASC";}
$sort=getval("sort",$default_sort);setcookie("saved_sort",$sort);
$revsort = ($sort=="ASC") ? "DESC" : "ASC";

## If displaying a collection
# Enable/disable the reordering feature. Just for collections for now.
$allow_reorder=false;
# display collection title if option set.
$collection_title = "";

if (substr($search,0,11)=="!collection")
	{
	$collection=substr($search,11);
	$collectiondata=get_collection($collection);
	if ($collection_reorder_caption)
		{
	# Check to see if this user can edit (and therefore reorder) this resource
		if (($userref==$collectiondata["user"]) || ($collectiondata["allow_changes"]==1) || (checkperm("h")))
			{
			$allow_reorder=true;
			}
		}

	if ($display_collection_title)
		{
		if (!isset($collectiondata['savedsearch'])||(isset($collectiondata['savedsearch'])&&$collectiondata['savedsearch']==null)){ $collection_tag='';} else {$collection_tag=$lang['smartcollection'].": ";}
		
		$collection_title = '<div align="left"><h1>'.$collection_tag.$collectiondata ["name"].'</h1> ';
		if ($k==""){$collection_title.='<a href="collections.php?collection='.$collectiondata["ref"].'" target="collections">&gt;&nbsp;'.$lang['action-select'].' '.$lang['collection'].'</a>';}
		if ($k==""&&$preview_all){$collection_title.='&nbsp;&nbsp;<a href="preview_all.php?ref='.$collectiondata["ref"].'">&gt;&nbsp;'.$lang['preview_all'].'</a>';}
		$collection_title.='</div>';
		if ($display!="list"){$collection_title.= '<br>';}
		}
	}


if ($search_titles){
	if (substr($search,0,5)=="!last"){
		$collection_title = '<h1>'.$lang["recent"].' '.substr($search,5,strlen($search)).'</h1> ';
	}
	if (substr($search,0,8)=="!related") {
		$resource=explode(" ",$search);$resource=str_replace("!related","",$resource[0]);
		$collection_title = '<h1>'.$lang["relatedresources"].' - '.$lang['id'].$resource.'</h1> ';
	}
	if ($archive==-2){
	$collection_title = '<h1>'.$lang["status-2"].'</h1> ';
	}
	if ($archive==-1){
	$collection_title = '<h1>'.$lang["status-1"].'</h1> ';
	}
	if ($archive==2){
	$collection_title = '<h1>'.$lang["status2"].'</h1> ';
	}
	if ($archive==3){
	$collection_title = '<h1>'.$lang["status3"].'</h1> ';
	}
	if (substr($search,0,15)=="!archivepending") {
		$collection_title = '<h1>'.$lang["status1"].'</h1> ';
	}
	if (substr($search,0,14)=="!contributions") {
		$cuser=explode(" ",$search);$cuser=str_replace("!contributions","",$cuser[0]);
		if ($cuser==$userref && $archive==-2){$collection_title = '<h1>'.$lang["viewcontributedps"].'</h1> ';}
	}
	if (substr($search,0,7)=="!unused") {
		$collection_title = '<h1>'.$lang["uncollectedresources"].'</h1> ';
	}
}
	
	

# get current collection resources to pre-fill checkboxes
if ($use_checkboxes_for_selection){
$collectionresources=get_collection_resources($usercollection);
}

# fetch resource types from query string and generate a resource types cookie
if (getval("resetrestypes","")=="")
	{
	$restypes=getvalescaped("restypes","");
	}
else
	{
	$restypes="";
	reset($_GET);foreach ($_GET as $key=>$value)
		{
		if (substr($key,0,8)=="resource") {if ($restypes!="") {$restypes.=",";} $restypes.=substr($key,8);}
		}
	setcookie("restypes",$restypes);
	
	# This is a new search, log this activity
	if ($archive==2) {daily_stat("Archive search",0);} else {daily_stat("Search",0);}
	}
	
# If returning to an old search, restore the page/order by
if (!array_key_exists("search",$_GET))
	{
	$offset=getvalescaped("saved_offset",0);setcookie("saved_offset",$offset);
	$order_by=getvalescaped("saved_order_by","relevance");setcookie("saved_order_by",$order_by);
	$sort=getvalescaped("saved_sort","");setcookie("saved_sort",$sort);
	$archive=getvalescaped("saved_archive",0);setcookie("saved_archive",$archive);
	}
	
# If requested, refresh the collection frame (for redirects from saves)
if (getval("refreshcollectionframe","")!="")
	{
	refresh_collection_frame();
	}

ob_end_flush();

# Include function for reordering
if ($allow_reorder && $display!="list")
	{
	$url="search.php?search=" . urlencode($search) . "&order_by=" . urlencode($order_by) . "&sort=".$sort."&archive=" . $archive . "&offset=" . $offset;
	?>
	<script type="text/javascript">
	function ReorderResources(id1,id2)
		{
		document.location='<?php echo $url?>&reorder=' + id1 + '-' + id2;
		}
	</script>
	<?php
	
	# Also check for the parameter and reorder as necessary.
	$reorder=getvalescaped("reorder","");
	if ($reorder!="")
		{
		$r=explode("-",$reorder);
		swap_collection_order(substr($r[0],13),$r[1],substr($search,11));
		refresh_collection_frame();
		}
	}

# Initialise the results references array (used later for search suggestions)
$refs=array();

# Special query? Ignore restypes
if (strpos($search,"!")!==false) {$restypes="";}

# Do the search!
$result=do_search($search,$restypes,$order_by,$archive,$per_page+$offset,$sort);

# Do the public collection search if configured.

if (($search_includes_themes || $search_includes_public_collections) && $search!="" && substr($search,0,1)!="!" && $offset==0)
{
    $collections=search_public_collections($search,"theme","ASC",!$search_includes_themes,!$search_includes_public_collections,true);
}
# Special case: numeric searches (resource ID) and one result: redirect immediately to the resource view.
if ((($config_search_for_number && is_numeric($search)) || $searchresourceid > 0) && is_array($result) && count($result)==1)
	{
	redirect("pages/m/view.php?ref=" . $result[0]["ref"] . "&search=" . urlencode($search) . "&order_by=" . urlencode($order_by) . "&sort=".$sort."&offset=" . urlencode($offset) . "&archive=" . $archive . "&k=" . $k);
	}
	



if (is_array($result)||(isset($collections)&&(count($collections)>0)))
	{
	$url="search.php?search=" . urlencode($search) . "&order_by=" . $order_by . "&sort=".$sort."&offset=" . $offset . "&archive=" . $archive."&sort=".$sort;
	?>
	
	<div id="pageAbout" class="page" data-role="content">
	<div class="content">
	
	<div data-role="collapsible" data-theme="a" data-content-theme="a" data-mini="true" style="margin:0 auto; margin-left:auto; margin-right:auto; align:center; text-align:center;">
	<h3><?php echo number_format(is_array($result)?count($result):0)?>
			<?php echo (count($result)==$max_results)?"+":""?>
			<?php if (count($result)==1){echo $lang["youfoundresource"];} 
			else {echo $lang["youfoundresources"];}?>
	</h3>
	<div data-role="controlgroup" data-type="horizontal" data-mini="true">
	
	<?php if ($display=="xlthumbs") { ?>
	<span class="Selected" data-role="button" data-theme="a">Large</span>
	<?php } else { ?><a href="<?php echo $url?>&display=xlthumbs&k=<?php echo $k?>" data-role="button">Large</a><?php } ?>
	
	<?php if ($display=="thumbs") { ?> 
	<span class="Selected" data-role="button" data-theme="a">Medium</span>
	<?php } else { ?><a href="<?php echo $url?>&display=thumbs&k=<?php echo $k?>" data-role="button">Medium</a><?php } ?> 
		
	<?php if ($smallthumbs==true) { ?>
	<?php if ($display=="smallthumbs") { ?><span class="Selected" data-role="button" data-theme="a"><?php echo $lang["smallthumbs"]?></span>
	<?php } else { ?><a href="<?php echo $url?>&display=smallthumbs&k=<?php echo $k?>" data-role="button"><?php echo $lang["smallthumbs"]?></a><?php } ?><?php } ?>
		
	<?php if ($display=="list") { ?> <span class="Selected" data-role="button" data-theme="a"><?php echo $lang["list"]?></span>
	<?php } else { ?><a href="<?php echo $url?>&display=list&k=<?php echo $k?>" data-role="button"><?php echo $lang["list"]?></a><?php } ?> <?php hook("adddisplaymode"); ?> </div><hr>
	<?php
	
	# order by
	#if (strpos($search,"!")===false)
	if (true) # Ordering enabled for collections/themes too now at the request of N Ward / Oxfam
		{
		$rel=$lang["relevance"];
		?>
		<div data-role="controlgroup" data-type="horizontal" data-mini="true">
		<?php
		if (strpos($search,"!")!==false) {$rel=$lang["asadded"];}
		?>
		<?php if ($order_by=="relevance") {?><span class="Selected" data-role="button" data-theme="a">Weight</span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=relevance&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button">Weight</a><?php } ?>
		
		<?php if ($title_sort && $use_resource_column_data) { ?>
		&nbsp;|&nbsp;
		<?php if ($order_by=="title") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=title&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["resourcetitle"]?></a><div class="<?php echo $sort?>"></div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=title&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["resourcetitle"]?></a><?php } ?>
		<?php } ?>
		
		<?php if ($original_filename_sort && $use_resource_column_data) { ?>
		<?php if ($order_by=="file_path") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=file_path&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["filename"]?></a><div class="<?php echo $sort?>">&nbsp;</div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=file_path&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["filename"]?></a><?php } ?>
		<?php } ?>
		
		<?php if ($random_sort){?>

		<?php if ($order_by=="random") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=random&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["random"]?></a></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=random&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["random"]?></a><?php } ?>
		<?php } ?>
		

		<?php if ($order_by=="popularity") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=popularity&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["popularity"]?></a><div class="<?php echo $sort?>">&nbsp;</div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=popularity&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["popularity"]?></a><?php } ?>
		
		<?php if ($orderbyrating) { ?>

		<?php if ($order_by=="rating") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=rating&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["rating"]?></a><div class="<?php echo $sort?>">&nbsp;</div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=rating&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["rating"]?></a><?php } ?>
		<?php } ?>
		
		<?php if ($date_column){?>

		<?php if ($order_by=="date") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=date&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["date"]?></a><div class="<?php echo $sort?>">&nbsp;</div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=date&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["date"]?></a><?php } ?>
		<?php } ?>
		
		<?php if ($colour_sort) { ?>

		<?php if ($order_by=="colour") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=colour&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["colour"]?></a><div class="<?php echo $sort?>">&nbsp;</div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=colour&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["colour"]?></a><?php } ?>
		<?php } ?>
		
		<?php if ($country_sort && $use_resource_column_data) { ?>

		<?php if ($order_by=="country") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=country&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["country"]?></a><div class="<?php echo $sort?>">&nbsp;</div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=country&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["country"]?></a><?php } ?>
		<?php } ?>
		
		<?php if ($order_by_resource_id) { ?>

		<?php if ($order_by=="resourceid") {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&order_by=resourceid&archive=<?php echo $archive?>&k=<?php echo $k?>&sort=<?php echo $revsort?>"><?php echo $lang["resourceid"]?></a><div class="<?php echo $sort?>">&nbsp;</div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=resourceid&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo $lang["resourceid"]?></a><?php } ?>
		<?php } ?>
		
		<?php # add thumbs_display_fields to sort order links for thumbs views
		if (count($sf)>0){
			for ($x=0;$x<count($sf);$x++)
				{
				if (!isset($metadata_template_title_field)){$metadata_template_title_field=false;} 
				if ($sf[$x]['ref']!=$metadata_template_title_field){?>
				<?php if ($order_by=="field".$sf[$x]['ref']) {?><span class="Selected" data-role="button" data-theme="a"><a href="search.php?search=<?php echo urlencode($search)?>&sort=<?php echo $revsort?>&order_by=field<?php echo $sf[$x]['ref']?>&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo i18n_get_translated($sf[$x]['title'])?></a><div class="<?php echo $sort?>"></div></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=field<?php echo $sf[$x]['ref']?>&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button"><?php echo i18n_get_translated($sf[$x]['title'])?></a><?php } ?>
				<?php } ?>
				<?php } ?>	
			<?php } ?>		
		
		<?php hook("sortorder"); ?>
		</div>
		<hr>
		
		<div data-role="controlgroup" data-type="horizontal" data-mini="true">
		<?php 
		for($n=0;$n<count($results_display_array);$n++){?>
		<?php if ($per_page==$results_display_array[$n]){?><span class="Selected" data-role="button" data-theme="a"><?php echo $results_display_array[$n]?></span><?php } else { ?><a href="search.php?search=<?php echo urlencode($search)?>&order_by=<?php echo $order_by?>&archive=<?php echo $archive?>&k=<?php echo $k?>&per_page=<?php echo $results_display_array[$n]?>&sort=<?php echo $sort?>" data-role="button"><?php echo $results_display_array[$n]?></a><?php } ?><?php if ($n>-1&&$n<count($results_display_array)-1){?><?php } ?>
		<?php } ?>
		</div>
		<hr>
		<?php
		
					# work out common keywords among the results
	if ((count($result)>$suggest_threshold) && (strpos($search,"!")===false) && ($suggest_threshold!=-1))
		{
		for ($n=0;$n<count($result);$n++)
			{
			if ($result[$n]["ref"]) {$refs[]=$result[$n]["ref"];} # add this to a list of results, for query refining later
			}
		$suggest=suggest_refinement($refs,$search);
		if (count($suggest)>0)
			{
			?><div data-role="controlgroup" data-type="horizontal" data-mini="true" data-theme="a"><?php
			for ($n=0;$n<count($suggest);$n++)
				{
				?><a  href="search.php?search=<?php echo  urlencode(strip_tags($suggest[$n])) ?>" data-role="button"><?php echo stripslashes($suggest[$n])?></a><?php
				}
			?></div><?php
			}
		}
	
		} ?>
		
	</div>
	
	
 <div>
	
	<?php
	$results=count($result);
	$totalpages=ceil($results/$per_page);
	if ($offset>$results) {$offset=0;}
	$curpage=floor($offset/$per_page)+1;
	$url="search.php?search=" . urlencode($search) . "&order_by=" . urlencode($order_by) . "&sort=".$sort."&archive=" . $archive . "&k=" . $k."&sort=".$sort;	

	pager();
	$draw_pager=true;
	?>
	
	<?php echo $collection_title ?>
	<?php		
	hook("beforesearchresults");
	
	
		
	# Include public collections and themes in the main search, if configured.		
	if (isset($collections))
		{
		include "../../include/search_public.php";
		}
	
		
	$rtypes=array();
	$types=get_resource_types();
	for ($n=0;$n<count($types);$n++) {$rtypes[$types[$n]["ref"]]=$types[$n]["name"];}
	if (is_array($result)){
	# loop and display the results
	?>
	<br style="clear: both">
	
	<?php if($display=="list" || $display=="thumbs"){ ?>
  <ul data-role="listview">
	
 
 <?php } ?>
 
	<?php if ($display=="smallthumbs") { ?>
  <div style="float: left; overflow:hidden;">
 <?php } ?>
  
	<?php
	for ($n=$offset;(($n<count($result)) && ($n<($offset+$per_page)));$n++)			
		{
		$ref=$result[$n]["ref"];
		$GLOBALS['get_resource_data_cache'][$ref] = $result[$n];
		$url="view.php?ref=" . $ref . "&search=" . urlencode($search) . "&order_by=" . urlencode($order_by) . "&sort=".$sort."&offset=" . urlencode($offset) . "&archive=" . $archive . "&k=" . $k; ?>
		<?php 
		// establish the nature of the rating field-- resource.rating or resource.field[$rating_field]
		if (!$use_resource_column_data && isset($rating_field)){$rating="field".$rating_field;} else {$rating="rating";}?>
			<?php
			
			
			
			
				
			if ($display=="smallthumbs") { #  ---------------------------- Small Thumbnails view ----------------------------
			$height_diff = $result[$n]["thumb_height"] ? round(abs(80 / $result[$n]["thumb_height"]) * 100) : 0;
			
			
			if($result[$n]["thumb_width"] > 80) {
			$thumb_diff = round(abs($result[$n]["thumb_width"]) - 80);
			$img_style = "margin: 0px ". $thumb_diff/2 . " 0px " . $thumb_diff/2 .";";
			$thumb_width = '80px';
			}
			else{
			$img_style = '';
			$thumb_width = $result[$n]["thumb_width"].'px';
			}
			
			$div_style = '';
			if($result[$n]["resource_type"] == 1)
			$div_style .= 'border:3px solid #021a40;';
   		if($result[$n]["resource_type"] == 2)
			$div_style .= 'border:3px solid #629632;';
			if($result[$n]["resource_type"] == 3)
			$div_style .= 'border:3px solid #8B0000;';
			if($result[$n]["resource_type"] == 4)
			$div_style .= 'border:3px solid #CCCCCC;';
			if($result[$n]["resource_type"] == 5)
			$div_style .= 'border:3px solid #0033FF;';
			if($result[$n]["resource_type"] == 6)
			$div_style .= 'border:3px solid #000000;';
			if($result[$n]["resource_type"] == 7)
			$div_style .= 'border:3px solid #FFFFFF;';
		?>
		 
		
	
	<?php $access=get_resource_access($result[$n]);
	$use_watermark=false; ?>

	<div style="float: left; <?php echo $div_style ?>">
	<a href="<?php echo $url?>"><?php if ($result[$n]["has_image"]==1) { ?><img src="<?php echo get_resource_path($ref,false,"thm",false,$result[$n]["preview_extension"],-1,1,$use_watermark,$result[$n]["file_modified"])?>" height=80px style="<?php echo $img_style; ?> height=80px width="<?php echo $thumb_width ?>" align=left /><?php } else { ?><img src="../../gfx/<?php echo get_nopreview_icon($result[$n]["resource_type"],$result[$n]["file_extension"],false)?>" /><?php } ?>
	</a>
	</div>
	
		<?php 
		
		} 
		
					if ($display=="xlthumbs") { #  ---------------------------- X-Large Thumbnails view ----------------------------
			?>
		 
<?php if (!hook("renderresultlargethumb")) { ?>

<!--Resource Panel-->
	<div class="ResourcePanelShellLarge" id="ResourceShell<?php echo $ref?>">
	<div class="ResourcePanelLarge">
	
<?php if (!hook("renderimagelargethumb")) { ?>			
	<?php $access=get_resource_access($result[$n]);
	$use_watermark=check_use_watermark();?>
	<table border="0" class="ResourceAlignLarge<?php if (in_array($result[$n]["resource_type"],$videotypes)) { ?> IconVideoLarge<?php } ?>">
	<tr><td>
	<a href="<?php echo $url?>" <?php if (!$infobox) { ?>title="<?php echo str_replace(array("\"","'"),"",htmlspecialchars(i18n_get_translated($result[$n]["field".$view_title_field])))?>"<?php } ?>><?php if ($result[$n]["has_image"]==1) { ?><img src="<?php echo get_resource_path($ref,false,"pre",false,$result[$n]["preview_extension"],-1,1,$use_watermark,$result[$n]["file_modified"])?>" class="ImageBorder"
	<?php if ($infobox) { ?>onmouseover="InfoBoxSetResource(<?php echo $ref?>);" onmouseout="InfoBoxSetResource(0);"<?php } ?>
	 /><?php } else { ?><img border=0 src="../../gfx/<?php echo get_nopreview_icon($result[$n]["resource_type"],$result[$n]["file_extension"],false) ?>" 
	<?php if ($infobox) { ?>onmouseover="InfoBoxSetResource(<?php echo $ref?>);" onmouseout="InfoBoxSetResource(0);"<?php } ?>
	/><?php } ?></a>
		</td>
		</tr></table>
<?php } ?> <!-- END HOOK Renderimagelargethumb-->	
<?php if ($display_user_rating_stars && $k==""){ ?>
		<?php if ($result[$n]['user_rating']=="") {$result[$n]['user_rating']=0;}?>
		
		<div  class="RatingStars" onMouseOut="UserRatingDisplay(<?php echo $result[$n]['ref']?>,<?php echo $result[$n]['user_rating']?>,'StarCurrent');">&nbsp;<?php
		for ($z=1;$z<=5;$z++)
			{
			?><a href="#" onMouseOver="UserRatingDisplay(<?php echo $result[$n]['ref']?>,<?php echo $z?>,'StarSelect');" onClick="UserRatingSet(<?php echo $userref?>,<?php echo $result[$n]['ref']?>,<?php echo $z?>);return false;" id="RatingStarLink<?php echo $result[$n]['ref'].'-'.$z?>"><span id="RatingStar<?php echo $result[$n]['ref'].'-'.$z?>" class="Star<?php echo ($z<=$result[$n]['user_rating']?"Current":"Empty")?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></a><?php
			}
		?>
		</div>
		<?php } ?>
<?php hook("icons");?>
<?php if (!hook("rendertitlelargethumb")) { ?>	
<?php if ($use_resource_column_data) { // omit default title display ?>		
		<div class="ResourcePanelInfo"><a href="<?php echo $url?>" <?php if (!$infobox) { ?>title="<?php echo str_replace(array("\"","'"),"",htmlspecialchars(i18n_get_translated($result[$n]["title"])))?>"<?php } ?>><?php echo str_replace("#zwspace","&#x200b",highlightkeywords(htmlspecialchars(wordwrap(tidy_trim(i18n_get_translated($result[$n]["title"]),$results_title_trim),$results_title_wordwrap,"#zwspace;",true)),$search))?><?php if ($show_extension_in_search) { ?><?php echo " [" . strtoupper($result[$n]["file_extension"] . "]")?><?php } ?></a>&nbsp;</div>
<?php } //end if use_resource_column_data ?>

<?php } ?> <!-- END HOOK Rendertitlelargethumb -->			
		
		<?php
		# thumbs_display_fields
		for ($x=0;$x<count($df);$x++)
			{
			#value filter plugin -tbd	
			$value=$result[$n]['field'.$df[$x]['ref']];
			$plugin="../../plugins/value_filter_" . $df[$x]['name'] . ".php";
			if (file_exists($plugin)) {include $plugin;}
			
			# swap title fields if necessary
			if (isset($metadata_template_resource_type) && isset ($metadata_template_title_field)){
				if (!$use_resource_column_data && ($df[$x]['ref']==$view_title_field) && ($result[$n]['resource_type']==$metadata_template_resource_type)){
					$value=$result[$n]['field'.$metadata_template_title_field];
					}
				}
			?>		
			<?php 
			// extended css behavior 
			if ( in_array($df[$x]['ref'],$xl_thumbs_display_extended_fields) &&
			( (isset($metadata_template_title_field) && $df[$x]['ref']!=$metadata_template_title_field) || !isset($metadata_template_title_field) ) ){ ?>
			<?php if (!hook("replaceresourcepanelinfolarge")){?>
			<div class="ResourcePanelInfo">
			<?php if (!$use_resource_column_data && $x==0){ // add link if necessary ?><a href="<?php echo $url?>" <?php if (!$infobox) { ?>title="<?php echo str_replace(array("\"","'"),"",htmlspecialchars(i18n_get_translated($value)))?>"<?php } //end if infobox ?>><?php } //end link
			echo str_replace("#zwspace","&#x200b",highlightkeywords(htmlspecialchars(wordwrap(tidy_trim(TidyList(i18n_get_translated($value)),$results_title_trim),$results_title_wordwrap,"#zwspace;",true)),$search,$df[$x]['partial_index'],$df[$x]['name'],$df[$x]['indexed']))?><?php if ($show_extension_in_search) { ?><?php echo " [" . strtoupper($result[$n]["file_extension"] . "]")?><?php } ?><?php if (!$use_resource_column_data && $x==0){ // add link if necessary ?></a><?php } //end link?>&nbsp;</div>
			<?php } /* end hook replaceresourcepanelinfolarge */?>
			<?php 

			// normal behavior
			} else if  ( (isset($metadata_template_title_field)&&$df[$x]['ref']!=$metadata_template_title_field) || !isset($metadata_template_title_field) ) {?> 
			<div class="ResourcePanelInfo"><?php if (!$use_resource_column_data && $x==0){ // add link if necessary ?><a href="<?php echo $url?>" <?php if (!$infobox) { ?>title="<?php echo str_replace(array("\"","'"),"",htmlspecialchars(i18n_get_translated($value)))?>"<?php } //end if infobox ?>><?php } //end link?><?php echo highlightkeywords(tidy_trim(TidyList(i18n_get_translated($value)),28),$search,$df[$x]['partial_index'],$df[$x]['name'],$df[$x]['indexed'])?><?php if (!$use_resource_column_data && $x==0){ // add link if necessary ?></a><?php } //end link?>&nbsp;</div><div class="clearer"></div>
			<?php } ?>
			<?php
			}
		?>
		
		<div class="ResourcePanelIcons">&nbsp;</div>	
				
		<?php if (!hook("replacefullscreenpreviewicon")){?>
		<a href="preview.php?from=search&ref=<?php echo $ref?>&ext=<?php echo $result[$n]["preview_extension"]?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button" ><img src="../../gfx/interface/sp.gif" /></a>
		<?php } /* end hook replacefullscreenpreviewicon */?>
		<?php if(!hook("iconcollect")){?>
		<?php if (!checkperm("b") && $k=="" && !$use_checkboxes_for_selection) { ?>
		<span class="IconCollect"><?php echo add_to_collection_link($ref,$search)?><img src="../../gfx/interface/sp.gif" alt="" width="22" height="12"/></a></span>
		<?php } ?>
		<?php } # end hook iconcollect ?>

		<?php if (!checkperm("b") && substr($search,0,11)=="!collection" && $k=="" && !$use_checkboxes_for_selection) { ?>
		<?php if ($search=="!collection".$usercollection){?><span class="IconCollectOut"><?php echo remove_from_collection_link($ref,$search)?><img src="../../gfx/interface/sp.gif" alt="" width="22" height="12" /></a></span>
		<?php } ?>
		<?php } ?>
		
		<?php if ($allow_share && $k=="") { ?><span class="IconEmail"><a href="resource_email.php?ref=<?php echo $ref?>&search=<?php echo urlencode($search)?>&offset=<?php echo $offset?>&order_by=<?php echo $order_by?>&sort=<?php echo $sort?>&archive=<?php echo $archive?>&k=<?php echo $k?>" data-role="button" title="<?php echo $lang["emailresource"]?>"><img src="../../gfx/interface/sp.gif" alt="" width="16" height="12" /></a></span><?php } ?>
		<?php if ($result[$n][$rating]>0) { ?><div class="IconStar"></div><?php } ?>
		<?php if ($collection_reorder_caption && $allow_reorder) { ?>
		<span class="IconComment"><a href="collection_comment.php?ref=<?php echo $ref?>&collection=<?php echo substr($search,11)?>" title="<?php echo $lang["addorviewcomments"]?>"><img src="../../gfx/interface/sp.gif" alt="" width="14" height="12" /></a></span>			
		<?php if ($order_by=="relevance"){?><div class="IconReorder" onmousedown="InfoBoxWaiting=false;"> </div><?php } ?>
		<?php } hook("xlargesearchicon");?>
		<div class="clearer"></div>
		<?php if(!hook("thumbscheckboxes")){?>
		<?php if ($use_checkboxes_for_selection){?><input type="checkbox" id="check<?php echo $ref?>" class="checkselect" <?php if (in_array($ref,$collectionresources)){ ?>checked<?php } ?> onclick="if ($('check<?php echo $ref?>').checked){ <?php if ($frameless_collections){?>AddResourceToCollection(<?php echo $ref?>);<?php }else {?>parent.collections.location.href='collections.php?add=<?php echo $ref?>';<?php }?> } else if ($('check<?php echo $ref?>').checked==false){<?php if ($frameless_collections){?>RemoveResourceFromCollection(<?php echo $ref?>);<?php }else {?>parent.collections.location.href='collections.php?remove=<?php echo $ref?>';<?php }?> <?php if ($frameless_collections && isset($collection)){?>document.location.href='?search=<?php echo urlencode($search)?>&order_by=<?php echo urlencode($order_by)?>&sort=<?php echo $revsort?>&archive=<?php echo $archive?>&offset=<?php echo $offset?>';<?php } ?> }"><?php } ?>
		<?php } # end hook thumbscheckboxes?>
	</div>
</div>

<?php } ?>

		<?php 
		

		} elseif ($display=="thumbs") { # ---------------- Thumbs view ---------------------
			
			 $height_diff = $result[$n]["thumb_height"] ? round(abs(80 / $result[$n]["thumb_height"]) * 100) : 0;
			
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
			<li><a href="<?php echo $url?>">
				<?php if ($result[$n]["has_image"]==1) { ?>
				<img src="
				<?php echo get_resource_path($ref,false,"thm",false,$result[$n]["preview_extension"],-1,1,$use_watermark,$result[$n]["file_modified"])?>" style="overflow: hidden; <?php echo $img_style; ?>" height=80px width="<?php echo $thumb_width ?>">
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

		} else if ($display=="list") { # ----------------  List view -------------------
		?>
		
		 <?php
			if($result[$n]["resource_type"] == 1)
			$bubble = 'Photo';
   		if($result[$n]["resource_type"] == 2)
			$bubble = 'Book';
			if($result[$n]["resource_type"] == 3)
			$bubble = 'Video';
			if($result[$n]["resource_type"] == 4)
			$bubble = 'Audio';
			if($result[$n]["resource_type"] == 5)
			$bubble = 'App';
			if($result[$n]["resource_type"] == 6)
			$bubble = 'Template';
			if($result[$n]["resource_type"] == 7)
			$bubble = 'Vector';
  ?>
		
		<li><a href="<?php echo $url?>">
				<?php if ($result[$n]["has_image"]==1) { ?>
				<img src="
				<?php echo get_resource_path($ref,false,"col",false,$result[$n]["preview_extension"],-1,1,$use_watermark,$result[$n]["file_modified"])?>" height=40px>
			<?php } else { ?>  <img src="
				<?php echo get_nopreview_icon($result[$n]["resource_type"],$result[$n]["file_extension"],false) ?>" class="ui-li-icon"> <?php } ?>
				<p><?php echo str_replace(array("\"","'"),"",htmlspecialchars(i18n_get_translated($result[$n]["field".$view_title_field])))?></p><span class="ui-li-count"><?php echo $bubble ?></span>
			</a>
			</li>
		
		
		
		<?php
		}
	
	hook("customdisplaymode");
	
		}
    }
	if ($display=="list" || $display == "thumbs")
		{
		?>
		</ul>
		<?php
		}
	
	if ($display!="list")
		{
			
		?>
	<?php if ($display=="smallthumbs") { ?>
  </div>
 <?php } ?>
 
	<br style="clear: both">
		
		<!--Key to Panel-->
		<?php if (!hook("replacesearchkey")){?>
		<div class="BottomInpageKey"> 
			<?php echo $lang["key"]?>:
			<?php if ($display=="thumbs") { ?>
				
				<?php if ($orderbyrating) { ?><div class="KeyStar"><?php echo $lang["verybestresources"]?></div><?php } ?>
				<?php if ($allow_reorder) { ?><div class="KeyReorder"><?php echo $lang["reorderresources"]?></div><?php } ?>
				<?php if ($allow_reorder || (substr($search,0,11)=="!collection")) { ?><div class="KeyComment"><?php echo $lang["addorviewcomments"]?></div><?php } ?>
				<?php if ($allow_share) { ?><div class="KeyEmail"><?php echo $lang["emailresource"]?></div><?php } ?>
			<?php } ?>
			
			<?php if (!checkperm("b")) { ?><div class="KeyCollect"><?php echo $lang["addtocurrentcollection"]?></div><?php } ?>
			<div class="KeyPreview"><?php echo $lang["fullscreenpreview"]?></div>
			<?php hook("searchkey");?>
		</div>
		<?php }/*end replacesearchkey */?>
		<?php
		}
	}
else
	{
	?>
	<div class="BasicsBox"> 
	  <div class="NoFind">
		<p><?php echo $lang["searchnomatches"]?></p>
		<?php if ($result!="")
		{
		?>
		<p><?php echo $lang["try"]?>: <a href="search.php?search=<?php echo urlencode(strip_tags($result))?>"><?php echo stripslashes($result)?></a></p>
		<?php
		}
		else
		{
		?>
		<p><?php if (strpos($search,"country:")!==false) { ?><p><?php echo $lang["tryselectingallcountries"]?> <?php } 
		elseif (strpos($search,"year:")!==false) { ?><p><?php echo $lang["tryselectinganyyear"]?> <?php } 
		elseif (strpos($search,"month:")!==false) { ?><p><?php echo $lang["tryselectinganymonth"]?> <?php } 
		else 		{?><?php echo $lang["trybeinglessspecific"]?><?php } ?> <?php echo $lang["enteringfewerkeywords"]?></p>
		<?php
		}
	  ?>
	  </div>
	</div>
	<?php
	} 
?>
<!--Bottom Navigation - Archive, Saved Search plus Collection-->
<div class="BottomInpageNav">
<?php if (($archive==0) && (strpos($search,"!")===false) && $archive_search) { 
	$arcresults=do_search($search,$restypes,$order_by,2,0);
	if (is_array($arcresults)) {$arcresults=count($arcresults);} else {$arcresults=0;}
	if ($arcresults>0) 
		{
		?>
		<div class="InpageNavLeftBlock"><a href="search.php?search=<?php echo urlencode($search)?>&archive=2">&gt;&nbsp;<?php echo $lang["view"]?> <span class="Selected" data-role="button" data-theme="a"><?php echo number_format($arcresults)?></span> <?php echo ($arcresults==1)?$lang["match"]:$lang["matches"]?> <?php echo $lang["inthearchive"]?></a></div>
		<?php 
		}
	else
		{
		?>
		<div class="InpageNavLeftBlock">&gt;&nbsp;<?php echo $lang["nomatchesinthearchive"]?></div>
		<?php 
		}
	} ?>
	<?php if (!checkperm("b") && $k=="") { ?>
	<?php if($allow_save_search) { ?><div class="InpageNavLeftBlock"><a href="collections.php?addsearch=<?php echo urlencode($search)?>&restypes=<?php echo urlencode($restypes)?>&archive=<?php echo $archive?>" target="collections">&gt;&nbsp;<?php echo $lang["savethissearchtocollection"]?></a></div><?php } ?>
	<?php if($allow_smart_collections) { ?><div class="InpageNavLeftBlock"><a href="collections.php?addsmartcollection=<?php echo urlencode($search)?>&restypes=<?php echo urlencode($restypes)?>&archive=<?php echo $archive?>" target="collections">&gt;&nbsp;<?php echo $lang["savesearchassmartcollection"]?></a></div><?php } ?>
	<div class="InpageNavLeftBlock"><a href="collections.php?addsearch=<?php echo urlencode($search)?>&restypes=<?php echo urlencode($restypes)?>&archive=<?php echo $archive?>&mode=resources" target="collections">&gt;&nbsp;<?php echo $lang["savesearchitemstocollection"]?></a></div>
	<?php } ?>
	
	<?php hook("resultsbottomtoolbar"); ?>
	
	<?php 
	$url="search.php?search=" . urlencode($search) . "&order_by=" . urlencode($order_by) . "&sort=".$sort."&archive=" . $archive . "&k=" . $k;	

	if (isset($draw_pager)) {pager(false);} ?>
</div>	

<?php hook("endofsearchpage");?>

</div>
</div>
</div><!-- /content -->

<?php
include "footer.php";
?>
