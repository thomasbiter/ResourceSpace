 
    <footer>
      <div id="footer">
        Copyright &copy; 2012 by HardMagic Publishing
        <a href="http://www.w3.org/html/logo/" target="_blank" class="html5">
            <img src="<?php echo $directory ?>/img/HTML5_1Color_White.png" alt="HTML5 Powered with CSS3 / Styling, and Semantis" title="HTML5 Powered with CSS3 / Styling, and Semantics" />
        </a>
      </div>
    </footer>
    
    
<div class="lowerMenu" data-position="fixed">
        
    
    
    	
    	<?php 
    	
    	if (isset($username)){ ?>
    		<div class="pagesMenu flexslider">
    		<ul class="slides">
    		<?php
				// FOR LOGGED IN USERS
				
				# Load collection info.
				$cinfo=get_collection($usercollection);
				$searches=get_saved_searches($usercollection);
				$result=do_search("!collection" . $usercollection);
				$feedback=$cinfo["request_feedback"];
				
				for ($n=0;$n<=25;$n++)			
						{
						$ref=$result[$n]["ref"];
						$access=get_resource_access($result[$n]);
						$use_watermark=check_use_watermark();
						$col_title = htmlspecialchars(i18n_get_translated($result[$n]["field".$view_title_field]));
						
				 if ($result[$n]["has_image"]==1) { 
						$colimgpath=get_resource_path($ref,false,"col",false,$result[$n]["preview_extension"],-1,1,$use_watermark,$result[$n]["file_modified"]);
						} else 
						{
							$colimgpath = "../../gfx/". get_nopreview_icon($result[$n]["resource_type"],$result[$n]["file_extension"],true);
						} 
					?>
					<li>
            <a href="<?php echo $directory ?>/view.php?ref=<?php echo $ref; ?>" id="linkAbout" class="pageLink pageLink-1-1">
              <div class="iconBox">
                <img src="<?php echo $colimgpath; ?>" alt="<?php echo $col_title; ?>" />
              </div>
              <div class="titleBox">
                <?php echo $col_title; ?>
              </div>
            </a>
        	</li>
					<?php
					}
					?>
					   </ul>
					      </div>
						

				<?php
					
				} 
				else 
				{ // FOR LOGGED OUT USERS
					?>
					<div class="pagesMenu">
					<div>
					<form id="form_login" method="post" action="http://openvase.com/wp-login.php" target="_top">
					<div style="float: left">
				  <input type="text" data-mini="true" name="log" id="user_login" placeholder="UserName" />
				  <input type="password" data-mini="true" name="pwd" placeholder="Password" id="user_pass" />
				  <input type='hidden' name='redirect_to' value='http://openvase.com/library/pages/m/search.php' />
				  <input type='hidden' name='task' value='dologin' />
				  <input type='hidden' class='checkbox' name='persistent' id='persistent' value='true'>
					</div>
				  <div style="float: right"><input name="Submit" data-mini="true" type="submit" value="<?php echo $lang["login"]?>" /></div>
				  </form>
					</div>
					</div>
					<?php
				} ?>
  
  
 
		</div>	
        
        
 


  </div> <!--! end of #container -->




  <!-- JavaScript at the bottom for fast page loading -->

 
  <!-- Debugger - remove for production -->
  <!-- <script src="https://getfirebug.com/firebug-lite.js"></script> -->

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
    s.parentNode.insertBefore(g,s)}(document,"script"));
  </script>

</body>
</html> 