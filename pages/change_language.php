<?php
include "../include/db.php";
include "../include/general.php";
include "../include/authenticate.php";

if (getval("save","")!="")
	{
    if ($global_cookies)
        setcookie("language",getval("language",""),time()+(3600*24*1000),"/");
    else
		{
        setcookie("language",getval("language",""),time()+(3600*24*1000),$baseurl_short);

		// Remove previously set cookies to avoid clashes - this can be removed after some time
		setcookie("language","",1,$baseurl_short . "pages/");
		setcookie("language","");
		}

	redirect(getval("uri",$baseurl_short."pages/" . ($use_theme_as_home?'themes.php':$default_home_page)));
	}
include "../include/header.php";
?>

<h1><?php echo $lang["languageselection"]?></h1>
<p><?php echo text("introtext")?></p>
  
<form method="post" action="<?php echo $baseurl_short?>pages/change_language.php">  
<div class="Question">
<label for="password"><?php echo $lang["language"]?></label>
<select class="stdwidth" name="language">
<?php reset ($languages); foreach ($languages as $key=>$value) { ?>
<option value="<?php echo $key?>" <?php if ($language==$key) { ?>selected<?php } ?>><?php echo $value?></option>
<?php } ?>
</select>
<div class="clearerleft"> </div>
</div>

<div class="QuestionSubmit">
<label for="buttons"> </label>		
<input name="save" type="submit" value="&nbsp;&nbsp;<?php echo $lang["save"]?>&nbsp;&nbsp;" />
</div>
</form>


<?php
include "../include/footer.php";
?>
