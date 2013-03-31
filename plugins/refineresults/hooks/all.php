<?php

function HookRefineresultsSearchBeforesearchresults()
	{
	global $baseurl_short,$result,$lang,$search,$k,$archive,$parameters_string, $collections;
	$results=0;
	if (is_array($result)) $results=count($result);
	if (is_array($collections)) $results+=count($collections);
	if ($k!="" || $results==0) {return false;}
	
	#if (substr($search,0,1)=="!") {return false;} # Only work for normal (non 'special') searches
	?>
	<div class="SearchOptionNav"><a href="#" onClick="
	if (jQuery('#RefinePlus').html()=='+')
		{
		jQuery('#RefineResults').slideToggle();
		jQuery('#RefinePlus').html('&minus;');
		jQuery('#refine_keywords').focus();
		}
	else
		{
		jQuery('#RefineResults').slideToggle();
		jQuery('#RefinePlus').html('+');
		}
	"><span id='RefinePlus'>+</span> <?php echo $lang["refineresults"]?></a><?php if ($search!=""){?>&nbsp;&nbsp;<a href='<?php echo $baseurl_short?>pages/search.php?search=<?php echo $parameters_string?>'>&gt;&nbsp;<?php echo $lang["clearsearch"]?></a><?php } ?></div>
	<?php
	return true;
	}
	
function HookRefineresultsSearchBeforesearchresultsexpandspace()
	{
	global $baseurl_short,$lang,$search,$k,$archive;
	if ($k!="") {return false;}
	?>
	
	<div class="RecordBox clearerleft" id="RefineResults" style="display:none;">
	<div class="RecordPanel">  
	
	<form method="post" action="<?php echo $baseurl_short?>pages/search.php">
	<div class="Question" id="question_related" style="border-top:none;">
	<label for="related"><?php echo $lang["additionalkeywords"]?></label>
	<input class="stdwidth" type=text id="refine_keywords" name="refine_keywords" value="">
	<input type=hidden name="archive" value="<?php echo $archive?>">
	<input type=hidden name="search" value="<?php echo htmlspecialchars($search) ?>">
	<div class="clearerleft"> </div>
	</div>

	<div class="QuestionSubmit" style="padding-top:0;margin-top:0;margin-bottom:0;padding-bottom:0;">
	<label for="buttons"> </label>
	<input  name="save" type="submit" value="&nbsp;&nbsp;<?php echo $lang["refine"]?>&nbsp;&nbsp;" />
	</div>
	</form>
	
	</div>
	<div class="PanelShadow"></div>
	</div>
	<?php
	
	return true;
	}

function HookRefineresultsSearchSearchstringprocessing()
	{
	global $search;
	$refine=trim(getvalescaped("refine_keywords",""));
	if ($refine!="")
		{
		$search.="," . $refine;	
		}
	$search=refine_searchstring($search);	
	}

?>
