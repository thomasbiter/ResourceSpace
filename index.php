<?php
include "include/db.php";
include "include/general.php";
include "include/collections_functions.php";

# External access support (authenticate only if no key provided, or if invalid access key provided)
$k=getvalescaped("k","");if (($k=="") || (!check_access_key_collection(getvalescaped("c",""),$k) && !check_access_key(getvalescaped("r",""),$k))) {include "include/authenticate.php";}

if (!hook("replacetopurl"))
	{ 
	$topurl="pages/" . $default_home_page;
	// ADD MOBILE DETECT
        $is_mobile = 0;
        include_once("/pages/m/mobile_detect.php");
        $detect = new Mobile_Detect();
        if($detect-&gt;isMobile())
	$is_mobile = 1;
	else 
	$is_mobile = 0;
        if($is_mobile)
        $topurl= "pages/m/search.php?search=" . urlencode("!last".$recent_search_quantity);
        else{
        $topurl="pages/" . $default_home_page;
        if ($use_theme_as_home) {$topurl="pages/themes.php";}
        if ($use_recent_as_home) {$topurl="pages/search.php?search=" . urlencode("!last".$recent_search_quantity);}
        }
	} /* end hook replacetopurl */ 


if (getval("c","")!="")
	{
	# quick redirect to a collection (from e-mails, keep the URL nice and short)
	$c=getvalescaped("c","");
	$topurl="pages/search.php?search=" . urlencode("!collection" . $c) . "&k=" . $k;;
	
	if ($k!="")
		{
		# External access user... set top URL to first resource
		$r=get_collection_resources($c);
		if (count($r)>0)
			{
			# Fetch collection data
			$cinfo=get_collection($c);if ($cinfo===false) {exit("Collection not found.");}
		
			if ($feedback_resource_select && $cinfo["request_feedback"])
				{
				$topurl="pages/collection_feedback.php?collection=" . $c . "&k=" . $k;		
				}
			else
				{
				$topurl="pages/search.php?search=" . urlencode("!collection" . $c) . "&k=" . $k;		
				}
			}
		}
	}

if (getval("r","")!="")
	{
	# quick redirect to a resource (from e-mails)
	$r=getvalescaped("r","");
	$topurl="pages/view.php?ref=" . $r . "&k=" . $k;
	}

if (getval("u","")!="")
	{
	# quick redirect to a user (from e-mails)
	$u=getvalescaped("u","");
	$topurl="pages/team/team_user_edit.php?ref=" . $u;
	}
	
if (getval("q","")!="")
	{
	# quick redirect to a request (from e-mails)
	$q=getvalescaped("q","");
	$topurl="pages/team/team_request_edit.php?ref=" . $q;
	}

if (getval("ur","")!="")
	{
	# quick redirect to periodic report unsubscriptions.
	$ur=getvalescaped("ur","");
	$topurl="pages/team/team_report.php?unsubscribe=" . $ur;
	}

# Redirect.
redirect($topurl);
