
 
 $(document).ready(function(){
   //hide address bar if content is long (safari)
   //MBP.hideUrlBarOnLoad();
     
      var myScroll;
      
      var runFlexsliders = function(){
          
          //run sliders if they're not run already
          var winWidth = $('#container').outerWidth();
          var paddingPercent = (winWidth *2)/100;
          var marginPercent = (winWidth*22)/100;
          var availableWidth = winWidth - marginPercent;
          var perItemWidth = (availableWidth / 3);// - paddingPercent;
          $('.flexslider').each(function(){
               if ($(this).hasClass('pagesMenu')){
                    
                 $(this, ':not(.flexslidered)').addClass("flexslidered").flexslider({
                      animation: "slide",
                      controlNav: false,
                      directionNav: true,
                      slideshow: false,
                      animationLoop: false,
                      itemWidth: perItemWidth
                 });
                 
               } else{
                    $(this, ':not(.flexslidered)').addClass("flexslidered").flexslider({
                         animation: "slide",
                         controlNav: false,
                         directionNav: true
                    });
               }
            });
      }
      

   
         var App = {
            init: function() {
               this.ENTER_KEY = 13;
               this.$duration = 700;
               
               //hide splash
               setTimeout(function(){
                    $('#splash').fadeOut('1000');
               }, 2000);
             
               
               runFlexsliders();
               
                         
               if ($('#pivotTabs').length> 0) {
                  myScroll = new iScroll('pivotTabs', {
                     snap: 'li',
                     momentum: true,
                     hScrollbar: false,
                     vScrollbar: false
                  });
               }
               
               
               
               this.Forms.bind();

               this.createAndCacheElements();
               this.bindEvents();
               
               $('li:last-child').addClass('last');
               $('li:first-child').addClass('first');
               
            
               var tabs = this.$tabs;
               $(tabs).find('li:first-child a').trigger('click');
                 
                 
               //portfolio - instruction - tap to change 
               if ($('#pagePortfolio').length > 0){
                     $('.instruction').fadeIn(App.duration);
                  
                  var options = {};
		  $('.portfolioProjects a.thumb').photoSwipe(options);
                  
                  $('#pagePortfolio .tab').hide();
                  $('#pagePortfolio .tabsPortfolio li:nth-child(2) a').trigger('click');
                  
               }
               
            },
            
            createAndCacheElements:function(){
               this.$tabs = $('#pivotTabs');
               
              
            },
            
            bindEvents: function(){
               var tabs = this.$tabs;
               tabs.on('click', 'li a', this.enablePivotTab);
               
               $('.tabsPortfolio').on('click', 'li a', this.portfolioTabChange)
               
               
               //if has website link, don't show the gallery
               $('.portfolioProjects').on('click', 'li', function(){
                  if ($(this).find('a.website').length == 0){
                     $(this).find('a.thumb').trigger('click');
                  }
               });
               
               $('.menuButton:not(.open)').click(function(e){
                    
               });
               
               $('.menuButton').click(function(e){
                    e.preventDefault();
                    
                    if ($(this).hasClass('open')){
                         $(this).removeClass('open');
                         
                         $('.upperMenu .pagesMenu').animate({
                              opacity: 0
                         }, function(){
                              $('.upperMenu').removeClass('opened');
                         });
                         
                         $('.lowerMenu .pagesMenu').animate({
                              opacity: 0
                         }, function(){
                              $('.lowerMenu').removeClass('opened');
                         });
                            
                    } else{
                         $(this).addClass('open');
                         //we give a delay of 300 because our CSS3 transitions are timed at 0.3s for the menu button (the up arrow) to rotate.
                         setTimeout(function(){
                              $('.upperMenu').addClass('opened');
                              $('.upperMenu .pagesMenu').animate({
                                   opacity: 1
                              });
                              $('.lowerMenu').addClass('opened');
                              $('.lowerMenu .pagesMenu').animate({
                                   opacity: 1
                              });
                         }, 300);
                         
                                          
                    }
                    
               });
               
            },
            
            portfolioTabChange: function(e){
               e.preventDefault();
               
               if ($(this).hasClass('active')){
                  return;
               }
               
               $('.tabsPortfolio li a').removeClass('active');
               $(this).addClass('active');
               
               var classToAdd = $(this).attr('data-value');
               
               $('.portfolioProjects').show().animate({
                  'opacity': 0
               }, 200, function(){
                  var me = $(this);
                  if (classToAdd == "grid"){
                     $('.instruction').addClass('lefter');
                  } else{
                     $('.instruction').removeClass('lefter');                     
                  }
                  $(me).removeClass('list grid').addClass(classToAdd).animate({
                     'opacity': 1
                  }, 200);
               });
               
            },
            
            enablePivotTab: function(e){
               e.preventDefault();
               if ($(this).hasClass('active')){
                  return;
               }
               var me = $(this);
               if ($(this).hasClass('goToFirst')){
                  $(this).parents('ul').find('li:first-child a').trigger('click');
                  return false;
               }
               var myLi = $(this).parent();
               var myLiIndex = $(myLi).index() + 1;
               var activeIndex = $('#pivotTabs a.active').parent().index() + 1;
               var direction1 = "left";
               var direction2 = "right";
               
               if (myLiIndex > activeIndex){
                  direction1 = "left";
                  direction2 = "right";
               } else{
                  direction1 = "right";
                  direction2 = "left";
               }
               
               
               $(this).parents('ul').find('a').removeClass('active');
               $(this).addClass('active');
               
               
               //scroll all tabs and contents
               myScroll.scrollToElement('li:nth-child(' + myLiIndex + ')', 200);
               $('.pivotTab').slideUp(App.duration);
               $($(me).attr('data-value')).slideDown(App.duration);
            },
            
            
            
            Forms: {
               bind: function() {
                  // Add required class to inputs
                  $(':input[required]').addClass('required');
                  
                  // Block submit if there are invalid classes found
                  $('form:not(.html5enhanced)').addClass("html5enhanced").submit(function() {
                        var formEl = this;
                          $('input,textarea').each(function() {
                                  App.Forms.validate(this);
                          });
                          
                          if(($(this).find(".invalid").length) == 0){
                                  // Delete all placeholder text
                                  $('input,textarea').each(function() {
                                          if($(this).val() == $(this).attr('placeholder')) $(this).val('');
                                  });
                                  
                                  //now submit form via ajax
                                  $.ajax({
                                    url: $(formEl).attr("action"),
                                    type: $(formEl).attr("method"),
                                    data: $(formEl).serialize(),
                                    success: function(r) {
                                       $(".successMessage").slideDown('fast');
                                       $('html,body').stop().animate({
                                          scrollTop: $(".successMessage").offset().top - 30
                                       }, 300);
                                       
                                       $(formEl).find('input[type="text"], input[type="email"], input[type="tel"], select').val('');
                                       $(formEl).find('textarea').val('');
                                       setTimeout(function(){
                                          $(".successMessage").slideUp('fast');
                                       }, 4000);
                                    }
                                  })
                                  return false;
                          }else{
                                  return false;
                          }
                  });
         
               },
               is_email: function(value){
                 return (/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/).test(value);
               },
               is_url: function(value){
                       return (/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i).test(value);
               },
               is_number: function(value){
                       return (typeof(value) === 'number' || typeof(value) === 'string') && value !== '' && !isNaN(value);
               },
               validate: function(element) {
                  var $$ = $(element);
                  var validator = element.getAttribute('type'); // Using pure javascript because jQuery always returns text in none HTML5 browsers
                  var valid = true;
                  var apply_class_to = $$;
                  
                  var required = element.getAttribute('required') == null ? false : true;
                  switch(validator){
                          case 'email': valid = App.Forms.is_email($$.val()); break;
                          case 'url': valid = App.Forms.is_url($$.val()); break;
                          case 'number': valid = App.Forms.is_number($$.val()); break;
                  }
                  
                  // Extra required validation
                  if(valid && required && $$.val().replace($$.attr('placeholder'), '') == ''){
                          valid = false;
                  }
                  
                  // Set input to valid of invalid
                  if(valid || (!required && $$.val() == '')){
                          apply_class_to.removeClass('invalid');
                          apply_class_to.addClass('valid');
                          return true;
                  }else{
                          apply_class_to.removeClass('valid');
                          apply_class_to.addClass('invalid');
                          return false;
                  }
               }
            }
            
         };
         App.init();

   
   
   
   var pageChange = function(){
      App.init();
   }
   
   

	function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {

    var result = { width: 0, height: 0, fScaleToTargetWidth: true };

    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {
        return result;
    }

    // scale to the target width
    var scaleX1 = targetwidth;
    var scaleY1 = (srcheight * targetwidth) / srcwidth;

    // scale to the target height
    var scaleX2 = (srcwidth * targetheight) / srcheight;
    var scaleY2 = targetheight;

    // now figure out which one we should use
    var fScaleOnWidth = (scaleX2 > targetwidth);
    if (fScaleOnWidth) {
        fScaleOnWidth = fLetterBox;
    }
    else {
       fScaleOnWidth = !fLetterBox;
    }

    if (fScaleOnWidth) {
        result.width = Math.floor(scaleX1);
        result.height = Math.floor(scaleY1);
        result.fScaleToTargetWidth = true;
    }
    else {
        result.width = Math.floor(scaleX2);
        result.height = Math.floor(scaleY2);
        result.fScaleToTargetWidth = false;
    }
    result.targetleft = Math.floor((targetwidth - result.width) / 2);
    result.targettop = Math.floor((targetheight - result.height) / 2);

    return result;
	}


		function OnImageLoad(evt) {

    var img = evt.currentTarget;

    // what's the size of this image and it's parent
    var w = $(img).width();
    var h = $(img).height();
    var tw = $(img).parent().width();
    var th = $(img).parent().height();

    // compute the new size and offsets
    var result = ScaleImage(w, h, tw, th, false);

    // adjust the image coordinates and size
    img.width = result.width;
    img.height = result.height;
    $(img).css("left", result.targetleft);
    $(img).css("top", result.targettop);
		}




   
   //this is needed because we are enabling navigation via jQuery Mobile.
   //for each time a new page is loaded, the javascript is not run on itself.
   //Hence, we call the application initialize method assuming that all javascript has to be run, since the entire page content is changed.
   
   //to disable the jquery ajax navigation system, please refer to the footer area where the $.mobile.xyz default parameters are set.
   $(document).bind('pagechange', pageChange);
                                 
   
});