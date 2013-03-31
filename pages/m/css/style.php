/* less codes */


/*THEME RED (with blue skills)*/
/*new hosting*/

/*theme black */


@themeColor1: #000;
@themeColor2: lighten(@themeColor1, 30%);
@headerColor: #fafafa;
@shadowMeColor: darken(@themeColor1, 36.5%);
@textShadowColor: darken(@themeColor1, 25%);
@themeSecondarycolor: #bfbfbf;







/*blue: #41b7d8;*/





@bgColor: #f9f9f9;
@darkBgColor: #dfdfdf;
@lightestBGColor: #ffffff;

@boxBorderColor: #c2c2c2;
@boxBorderShadow: #b2b2b2;

@shadowColor1: #999999;


@textColor: #121212;
@midLightTextColor: #414141;
@lightTextColor: #7b7a7a;
@veryLightTextColor: #bababa;
@lightestTextColor:#fff;

@socialLinksColor: #eeeeee;

@textShadowColor1: #000;



.gradient(@color1, @color2){
  background: -moz-linear-gradient(top,  @color1 0%, @color2 100%); /* FF3.6+ */
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,@color1), color-stop(100%,@color2)); /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top,  @color1 0%,@color2 100%); /* Chrome10+,Safari5.1+ */
  background: -o-linear-gradient(top,  @color1 0%,@color2 100%); /* Opera 11.10+ */
  background: -ms-linear-gradient(top,  @color1 0%,@color2 100%); /* IE10+ */
  background: linear-gradient(to bottom,  @color1 0%,@color2 100%); /* W3C */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=@color1, endColorstr=@color2,GradientType=0 ); /* IE6-8 */  
}



.transitioner(@params){
  transition:@params;
  -moz-transition:@params; /* Firefox 4 */
  -webkit-transition:@params; /* Safari and Chrome */
  -o-transition:color @params; /* Opera */
}


.ellipsify(@height){
  overflow: hidden;
  o-text-overflow: ellipsis;
  -o-text-overflow: ellipsis;  
  text-overflow: ellipsis;
  white-space: nowrap;
  height: @height;
}

.shadowMe(@params){
  box-shadow: @params;
  -webkit-box-shadow: @params;
  -moz-box-shadow: @params;
  -o-box-shadow: @params;
  
}


.borderRadiusMe(@params){
  border-radius: @params;
  -webkit-border-radius: @params;
  -moz-border-radius: @params;
  -o-border-radius: @params;
}









/*general css */

::selection
{
background-color: @themeColor1;
color:#fff;
}
::-moz-selection
{
background-color: @themeColor1;
color:#fff;
}




h1,h2,h3,h4,h5,h6,ul,li,p{
  margin: 0;
  padding: 0;
}

ul, li{
  list-style: none;
}

a, a:active, a:visited, a:focus, a:hover{
  text-decoration: none;
  color: @textColor;
}

input[type="text"], input[type="email"], input[type="tel"], select, textarea{
  background: #f9f9f9;
  border: 1px solid #DFDFDF;
  padding: 2%;
    box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  width: 100%;
  font-size: 11px;
  .borderRadiusMe(0);
}


 input.invalid, textarea.invalid{
  border: 1px solid red;
}



/*
 if you want custom top bar and bottom bar background color for the gallery (portfolio page)
.ps-caption, .ps-toolbar{
  .gradient(@themeColor1, @themeColor2);
}
*/


.columnContainer{
  .column{
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    width: 100%;
    padding: 0 2%;
    font-size: 13px;
  }
  
  &.column-1{
    .column{
    text-align: justify;
    }
  }
  
  &.column-2{
    .column{
      width: 50%;
      float: left;
    }
  }
  
  &.column-3{
    .column{
      width: 33%;
      float: left;
    }
  }
  
}

.successMessage{
    background: #FAFFBD;
    display: none;
    color: #121212;
    font-size: 13px;
    padding: 1%;
    margin-bottom: 1%;
}

#buttons{
  .ui-button{
    margin: 3px;
  }
}

.left{
  float: left;
}
.right{
  float: right;
}


.alpha{
  margin-left: 0 !important;
}
.omega{
  margin-right: 0 !important;
}




/*
 BUTTONS
*/

.button{
  border: 1px solid #b3b3b3;
}

.buttonStrong{
  color: #fff;
  font-size: 11px;
  padding: 4px 20px;
  width: auto;
  margin: 2%;
  .gradient(@themeColor1, @themeColor2);
}

a.buttonStrong{
    color: #fff;
}














/* custom css */

#bgImage{
  display: none;
  opacity: 0.02;
  filter: alpha(opacity=2);
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  z-index: -1;
}



.homeButton{
  position: absolute;
  left: 0px;
      /*top: 0px;*/
    background: url(../img/icon-back-white.png) no-repeat center center;
    background-size: 50% auto;
  width: 28px;
  height: 28px;
  color: @headerColor !important;

}


.backButton{
  position: absolute;
  left: 0px;
  top: 0;
  width: 44px;
  text-align: center;
  line-height: 42px;
  font-size: 22px;
  color: @headerColor !important;

}


.nextButton{
  position: absolute;
  right: 0px;
  top: 0;
  width: 44px;
  text-align: center;
  display:none;
  line-height: 42px;
  font-size: 22px;
  color: @headerColor !important;
  
  
}

.menuButton{
    position: absolute;
    right: 0;
    width: 28px;
    height: 28px;
            background: url(../img/icon-menu-white.png) no-repeat center center;
        background-size: 50% auto;
    .transitioner(all 0.3s);
    &.open{
        transform: rotate(180deg);
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
    }
}


#splash{
    position: fixed;
    z-index: 99999999;
    width: 100%;
    height: 100%;
    display: block;
    background-color: #3f3f3f;
    top: 0;
    left: 0;
    #splashBg{
        width: 100%;
        height: 100%;
    }
    
    #splashTitle{
        position: absolute;
        left: 50%;
        width: 170px;
        top: 50%;
        margin-left: -85px;
        margin-top: -37px;
    }
}



#header, #footer{
  
  color: @headerColor;
  text-shadow: 1px 1px 1px @textShadowColor;
  background: @themeColor1;
  .gradient(@themeColor1, @themeColor2);
  }



#header{
  height: 44px;
  text-align: center;
    /*position: fixed;*/
    
  
    .shadowMe(1px 1px 3px 0px @shadowMeColor);
  
  
  width: 100%;
  /*max-width: 1024px;*/
  top:0;
  z-index: 999999;
  .transitioner(all 0.3s);
  
  /*
  &.menuOpened{
    top: 89px !important;
  }
  */
  
  
  
  h1, h2{
    margin: 0;
    font-weight: normal;    
  }
  h1{
    font-size: 16px;
    padding: 5px 0 0;
  }
  h2{
    font-size: 11px;
    padding: 1px 0 0;
    text-transform: capitalize;
    span{
      text-transform: lowercase;
    }
  }
}
  
#footer{
  color: #fff;
          
  padding: 0 2%;
  position: relative;
  
  height: 23px;
  font-size: 10px;
  line-height: 23px;
  
  a.html5{
  
    position: absolute;
    right: 4px;
    top: -2px;
    display: block;
    img{
      height: 21px;
    }
    
      }
  
}




body{
  font-family: 'Source Sans Pro', sans-serif !important;
  background: @bgColor !important;
  color: @textColor;
  font-size: 11px;
  /*padding: 46px 0 0;*/
  overflow-y: scroll !important;
  /*max-width: 1024px;*/
  margin: 0 auto;
}

.page{
      /*padding: 46px 0 0;*/
    
    .flexslider{
        min-height: 365px;
    }
}
  
  
.content{
  margin: 2%;
}

.innerContent{
  padding: 2%;
}
 
 
 @media only screen and (min-width: 1025px) {
    #container{
        width: 1024px;
        left: 50%;
        margin-left: -512px;
    }
 }
 
 
  
.ui-mobile, .ui-mobile .ui-page{
    /*padding-top: 50px;*/
    .transitioner(all 0.3s);
    /*
    &.menuOpened{
        padding-top: 140px;
    }
    */
}
  
  
  
    .lowerMenu{
    background: #000000;
    bottom: 0;
    /*.transitioner(all 0.3s);*/
    /*position: fixed;*/
    width: 100%;
    
    padding: 0;
    overflow:hidden;
    height: 0;
    
    &.opened{
        /*z-index: 999;*/
        /*position: fixed;*/
        /*visibility:visible;*/
        
        padding: 2% 0 1%;
        height: 80px;
        margin-bottom: 0;
    }

    .flex-direction-nav .flex-prev{
        left: -30px;
    }
    .flexslider:hover .flex-prev{
        left: -25px;
    }
    
    .flex-direction-nav .flex-next{
        right: -30px;
    }
    .flexslider:hover .flex-next{
        right: -25px;
    }
    
    
    .pagesMenu{
        margin: 0 11% !important;
        /*
        opacity: 0;
        filter: alpha(opacity=0);
        */
    }
    .pageLink{
      width: 90% !important;
      margin: 0 5% 5% 5% !important;
    }
  }
  
  
  .upperMenu{
    background: #e9e9e9;
    top: 0;
    /*.transitioner(all 0.3s);*/
    /*position: fixed;*/
    width: 100%;
    
    padding: 0;
    overflow:hidden;
    height: 0;
    
    &.opened{
        /*z-index: 999;*/
        /*position: fixed;*/
        /*visibility:visible;*/
        
        padding: 2% 0 1%;
        height: 80px;
        margin-top: 0;
    }

    .flex-direction-nav .flex-prev{
        left: -30px;
    }
    .flexslider:hover .flex-prev{
        left: -25px;
    }
    
    .flex-direction-nav .flex-next{
        right: -30px;
    }
    .flexslider:hover .flex-next{
        right: -25px;
    }
    
    
    .pagesMenu{
        margin: 0 11% !important;
        /*
        opacity: 0;
        filter: alpha(opacity=0);
        */
    }
    .pageLink{
      width: 90% !important;
      margin: 0 5% 5% 5% !important;
    }
  }
  
  
  .separator{
    background: url(../img/separator-line.png) repeat-x;
    height: 2px;
    width: 100%;
    margin: 2% 0;
  }
  
  
    


    .pagesMenu{
      margin: 0 2%;
    }
    .pageLink{
      background: @lightestBGColor;
      .shadowMe(1px 1px 2px 0px @shadowColor1);
      float: left;
      display:block;
      overflow: hidden;
      padding: 2px;
      color: #4d4d4d;
      
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      
      margin: 0 5% 5% 0;
      width: 30%;
      
      &:nth-child(3n+3){
        margin-right: 0;
      }
      
      
      
      .iconBox{
        width: 100%;
        background: @darkBgColor;
        overflow: hidden;

        text-align: center;
        img{
          width: 100%;
        }
      }
      
      
      .titleBox{
        height: 20px;
        text-align: center;
        font-weight: 200;
        font-weight: 400;
        text-transform: uppercase;
        line-height: 23px;
        
      }
    }
    
    
    
    






  .groupBox{
    background: @lightestBGColor;
    border: 1px solid @darkBgColor;
    
    &.rounded{
      .borderRadiusMe(4px);
    }
    
    .flexslider {
        max-height: 250px;
        min-height: 0;
        
        overflow: hidden;
        li{
            padding: 0;
            border: 0;
        }
    }
    
    #banner{
        max-height: 150px;
        overflow: hidden;
    }
    
    .list li{
        padding: 2% 0;
    }
    
    p{
        font-size: 13px;
        line-height:  17px;
    }
    
    .value{
    font-weight: 600;
    font-size: 13px;
  }
  .key{
    font-weight: normal;
    font-size: 11px;
    color: @lightTextColor;
    text-transform: uppercase;
  }
  
    ul{
      &.spacious{
        li{
          /*padding: 3%;*/
        }
      }
      
      
        .icon{
          display: block;
          padding-right: 32px;
          background-position: right center;
          background-repeat: no-repeat;
        }
        
        .iconEmail{
          background-image: url(../img/icon-email.png);
        }
        .iconTel{
          background-image: url(../img/icon-tel.png);
        }
        
      li{
        line-height: 16px;
        padding: 2%;
        border-bottom: 1px solid @darkBgColor;
        
        
        &.last{
          border: 0px;
        }
      }
      /*end li*/
    }
    /*end ul*/
    
  }
  
  












#pageContact{
  
  textarea{
    height: 100px;
  }
  form .groupBox{
    li{
      border-bottom: 0 !important;
      padding-bottom: 0 !important;
    }
  }
  
  #map{
    iframe{
      width: 100%;
      height: 150px;
    }
  }
  
  .pivotTab{
    margin-top: -10px;
  }
  
  #socialTab{
  ul{
    margin-right: 7px;
  }
    
  ul#second{
    margin-bottom: 10px;
  }
    li{
        margin-bottom: 5px;
        a{
            font-size: 13px;
        }
        img{
            width: 32px;
        }
    }
  }
}





#pageResume{
  
  
}






#pagePortfolio,
#pageBlog{
  margin-top: 10px;
  
  .tabsPortfolio{
    position: relative;
    height: 30px;
    
    .instruction{
      position: absolute;
      display: none;
      padding-right: 20px;
      background: url(../img/icon-finger.png) no-repeat right center;
      height: 32px;
      line-height: 32px;
      font-size: 12px;
      color: @lightTextColor;
      &.lefter{
        left: 3%;
      }
      .transitioner(all 0.4s);
    }
    
    ul{
      display: block;
      text-align: center;
      
      li{
        display: inline-block;
        &.second{
          margin-left: -7px;
        }
        
        a{
          font-size: 22px;
          color: @veryLightTextColor;
          &.active{
            color: @midLightTextColor;
            position: relative;
            text-shadow: 1px 1px 1px #fff;
          }
        }
        
      }
    }
    /*end ul*/
  }
  /*end tabsPortfolio*/
  
  
  .portfolioProjects{
    display: none;
    opacity: 0;
    filter: alpha(opacity=0);
    
    li{
      .shadowMe(0 0 1px #999);
      a.thumb{
        display: block;
        /*.borderRadiusMe(3px);*/
        
        /*
        width: 77px;
        height: 67px;
        */
        
        overflow: hidden;
        img{
          width: 100%;
        }
      }
    }
    /*end li*/
  }
  
  
  
  
  
  
  .list{
    margin: 0 2%;
    li {
      margin: 0 0 2% 0;
      .thumb{
        float: left;
        width: 26%;
      }
      .groupBox{
        border-right: 2px solid @themeColor1;
      }
      .description{
        position: relative;
        float: left;
        width: 74%;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;

        padding: 2px 18px 2% 2%;
        .title{
          font-size: 14px;
          line-height: 16px;
          max-height: 32px;
          overflow: hidden;
          padding-bottom: 4px;
          color: @textColor;
        }
        .about{
          font-size: 12px;
          color: @lightTextColor;
          max-height: 28px;
          overflow: hidden;
        }
        
        .website{
          position: absolute;
          right: -10px;
          top: 0;
          color: @themeColor1;
          padding: 0 10px 0 10px;
          font-size: 20px;
          height: 100%;
          display: block;
          line-height: 20px;
        }
      }
    }
  }
  
  .grid{
    margin: 0 0 0 4%;
    li{
      float: left;
      /*margin: 0 22px 22px 0;*/
      border: 1px solid #ddd;
      width: 29%;
      margin: 0 3% 3% 0;
    }
    .description{
      display: none;
    }
    .groupBox{
      background: none !important;
      border: 0 !important;
    }
    .innerContent{
      padding: 0 !important;
    }
    
    /*end thumb*/
  }
  
}





















    #blogSearch{
    padding-top: 0 !important;
        .ui-btn-corner-all{
            .borderRadiusMe(0);
        }
        .searchField{
            padding: 0.7em 0;
        }
    }


  .blogListing{
    display: block;
    opacity: 1;
    filter: alpha(opacity=100);
    }
    
    
    .blogDetail{
        .about{
            max-height: 100% !important;
        }
    }
    
    
    
    .blogDetail{
    margin: 0 2%;
    
    li{
      .shadowMe(0 0 1px #999);
      margin: 0 0 2% 0;
      
      
      .postDetails{
        a.thumb{
            width: 100%;
            display: block;
            /*.borderRadiusMe(3px);*/
            overflow: hidden;
            img{
              width: 100%;
            }
        }
        
        .date{
            padding: 4px 0px 0 0;
        }
        
      }
      
      .groupBox{
        /*border-right: 2px solid @themeColor1;*/
      }
      
        
      .postedBy{
          line-height: 16px;
          margin: 5px 0 0;
      }
        .tags{
            margin: 2px 0 2px 28%;
            a{
                
                padding: 3px 6px;
                float: left;
                margin: 0 6px 3px 0;
                background: #E3E3E3;
                color: #555;
                
                /*
                background: @themeColor2;
                color: @headerColor;
                .borderRadiusMe(2px);
                */
                
                &.writer{
                    padding-right: 15px;
                    background-image: url(../img/icon-writer.png);
                    background-repeat: no-repeat;
                    background-position: right 5px;
                    background-size: 11px auto;
                }
                &.category{
                    padding-right: 15px;
                    background-image: url(../img/icon-category.png);
                    background-repeat: no-repeat;
                    background-position: right 4px;
                    background-size: 13px auto;
                }
                &.date{
                    padding-right: 15px;
                    background-image: url(../img/icon-date.png);
                    background-repeat: no-repeat;
                    background-position: right 4px;
                    background-size: 14px auto;
                }
            }
        }

      
        .title{
          font-size: 15px;
          padding: 2% 0;
        }
        
        
        .description{
          position: relative;
          box-sizing: border-box;
          -moz-box-sizing: border-box;
          -webkit-box-sizing: border-box;
          padding: 4% 0;
          
          .about{
            font-size: 13px;
            color: @midLightTextColor;
          }
          
        }
      
        }
    /*end li*/
  }
  
  
  
  
  
  
    
  .blogListing{
    margin: 0 2%;
    
    li{
      .shadowMe(0 0 1px #999);
      margin: 0 0 2% 0;
      
      
      .postDetails{
        float: left;
        width: 26%;
        a.thumb{
            width: 100%;
            display: block;
            /*.borderRadiusMe(3px);*/
            overflow: hidden;
            img{
              width: 100%;
            }
        }
        
        .date{
            padding: 4px 0px 0 0;
        }
        
      }
      
      .groupBox{
        /*border-right: 2px solid @themeColor1;*/
      }
      
        
      .postedBy{
          line-height: 16px;
          margin: 5px 0 0;
      }
        .tags{
            margin: 2px 0 2px 28%;
            a{
                
                padding: 3px 6px;
                float: left;
                margin: 0 6px 3px 0;
                background: #E3E3E3;
                color: #555;
                
                /*
                background: @themeColor2;
                color: @headerColor;
                .borderRadiusMe(2px);
                */
                
                &.writer{
                    padding-right: 15px;
                    background-image: url(../img/icon-writer.png);
                    background-repeat: no-repeat;
                    background-position: right 5px;
                    background-size: 11px auto;
                }
                &.category{
                    padding-right: 15px;
                    background-image: url(../img/icon-category.png);
                    background-repeat: no-repeat;
                    background-position: right 4px;
                    background-size: 13px auto;
                }
                &.date{
                    padding-right: 15px;
                    background-image: url(../img/icon-date.png);
                    background-repeat: no-repeat;
                    background-position: right 4px;
                    background-size: 14px auto;
                }
            }
        }

      
        
        
        .description{
          position: relative;
          float: left;
          width: 74%;
          box-sizing: border-box;
          -moz-box-sizing: border-box;
          -webkit-box-sizing: border-box;
          padding: 2px 18px 2% 2%;
          
          .title{
            font-size: 14px;
            line-height: 16px;
            max-height: 32px;
            overflow: hidden;
            padding-bottom: 4px;
            color: @textColor;
          }
          .about{
            font-size: 13px;
            color: @midLightTextColor;
            max-height: 80px;
            overflow: hidden;
          }
          
          .website{
            position: absolute;
            right: -10px;
            top: 0;
            color: @themeColor1;
            padding: 0 10px 0 10px;
            font-size: 20px;
            height: 100%;
            display: block;
            line-height: 20px;
          }
        }
      
        }
    /*end li*/
  }
  
  
  









.skills{
  color: @lightTextColor;
  .value{
    margin-bottom: 4px;
  }
  .skillBar{
    background: @bgColor;
    width: 100%;
    height: 17px;
    .skillCount{
      height: 17px;
      line-height: 17px;
      
      background: @themeSecondarycolor;
      color: #fff;
      font-size: 15px;
      font-weight: 600;
      text-align:right;
      position: relative;
      .text{
        position: absolute;
        right: 3px;
      }
    }
    
    .skillCount1{
      width: 10%;
    }
    
    .skillCount2{
      width: 20%;
    }
    
    .skillCount3{
      width: 30%;
    }
    
    .skillCount4{
      width: 40%;
    }

    .skillCount5{
      width: 50%;
    }

    .skillCount6{
      width: 60%;
    }
    
    .skillCount7{
      width: 70%;
    }
    
    .skillCount8{
      width: 80%;
    }
    
    .skillCount9{
      width: 90%;
    }

    .skillCount10{
      width: 100%;
    }
  }
  
}


.pivotTab{
  display: none;
}

#skillsTab{
  margin-top: -10px;
}

#pivotTabs{
  
  width:100%;
  overflow:auto;
  
  #scroller {
    width:4040px;
    float:left;
    padding:0;
    
    ul {
      list-style:none;
      display:block;
      float:left;
      width:100%;
      padding:0;
      margin:0;
      text-align:left;
      
      li{
        float: left;
        a{
          display: block;
          font-size: 22px;
          line-height: 22px;
          text-decoration: none;
          padding: 10px 32px 10px 0;
          text-transform: lowercase;
          color: lighten(@midLightTextColor, 40%);
          
          &.goToFirst{
            /*background:url(../img/icon-tab-first.png) no-repeat 0 center;*/
          }
          &.active{
            color: @midLightTextColor;
            text-shadow: 1px 1px 1px #fff;
          }
        }
      }
    }
    /*end ul*/
    
  }
  /*end scroller*/
  
}
/*end pivotTabs*/




.sectionTitle{
  color: #7b7b7b;
  font-size: 11px;
  text-transform: uppercase;
  font-weight: normal;
  margin-top: 10px;
  padding: 12px 0 7px 0;
  text-shadow: 1px 1px 1px #fff;
}



.qtipLinks{
  display: none;
}

.socialLinks{
  margin-top: 2px;
  a{
    display: block;
    padding: 7px;
    text-align: center;
    background: @socialLinksColor;
    color: @textColor;
    font-size: 14px;
    margin-bottom: 4px;
    width: 130px;
    .borderRadiusMe(4px);
  }
}

