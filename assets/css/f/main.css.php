<style type="text/css">
/* Reset ------------------------------------------------------------------------------------- */
html{margin:0;padding:0;border:0;font-size:100.01%;color:#000;}
body{margin:0;padding:0;border:0;font:0.75em/1.25 arial,helvetica,sans-serif;}
div,span,object,iframe,blockquote,q,abbr,acronym,address,big,cite,code,ins,del,em,img,small,strong,sub,sup,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,label,input,legend,table,caption,tbody,tfoot,thead,tr,textarea,p,th,td{margin:0;padding:0;border:0;font:inherit;}
table{border-collapse:collapse;border-spacing:0;}
li{list-style:none}
blockquote,q{quotes:none;}
blockquote:before,blockquote:after,q:before,q:after{content: '';content: none;}
*:focus {outline:none;}
/* General
 ------------------------------------------------------------------------------------- */
.left{ float:left;}
.right{ float:right;}
.clr,.clear{ clear:both;}
a{ text-decoration:none; color:#000;}
a:hover{ color:#18c1f3;}
.notfound{ color:#f00; height:40px; line-height:40px; background:#FFF0F0; padding:0px 20px; border-left:3px solid #f00;} 
.maintenance{ margin:50px 0; padding:50px; background:#f5f480; color:#3c7bc6; font-size:24px; box-shadow:0 0 5px #000;}
strong,b{font-weight:bold;}
/* Special Fonts
------------------------------------------------------------------------------------- */
@font-face {
	font-family: 'Conv_TitilliumText25L005';
	src: url('./fonts/TitilliumText25L005.eot');
	src: local('?'), url('./fonts/TitilliumText25L005.woff') format('woff'), url('./fonts/TitilliumText25L005.ttf') format('truetype'), url('./fonts/TitilliumText25L005.svg') format('svg');
	font-weight: normal;
	font-style: normal;
}
.titillium{font-family:'Conv_TitilliumText25L005';}

/* CSS
 ------------------------------------------------------------------------------------- */
html{ direction:ltr;}
body{background:#938e94; font-family: arial, sans-serif; font-size: 12px;}
#bodyWrapper{ background:#fff; position:relative; z-index:2; min-height:500px;}
#treeWrapper{ position:relative; height:30px; background: url(../../images/f/tree-bg.png) repeat-x top center; z-index:3; margin-top:-30px;}
#footerWrapper{ position:relative; background: url(../../images/f/footer-bg.png) repeat-x top center; z-index:3;}



/* Body Wrapper
 ------------------------------------------------------------------------------------- */
#bodyWrapper #pageWrapper{width:960px; margin:0 auto; position:relative; background:#fff;}
#pageWrapper #sidebar{position:relative; float:left; margin-left:0px; width:150px; min-height:1100px; background:#fff; border-radius:0 0 5px 5px; padding-bottom:190px;}
#pageWrapper #page{position:relative; float:left; margin-left:15px; width:795px;}


/* Sidebar
 ------------------------------------------------------------------------------------- */
#pageWrapper #sidebar #logo{ width:150px; height:131px; background:url(../../images/f/logo.png) no-repeat top left; position:relative; margin:0 auto; margin-top:60px;}
#pageWrapper #sidebar #logo a{width:150px; height:131px; display:block;}

/* search panel */
#pageWrapper #sidebar #search-panel{position:relative; margin-top:70px; padding-bottom:15px;}
#pageWrapper #sidebar #search-panel .find{color:#000; height:25px; line-height:25px; padding-left:30px; font-size:20px; background:url(../../images/f/search-find.png) no-repeat top left;}
#pageWrapper #sidebar #search-panel #search-text{position:relative; height:33px; width:153px; border:1px solid #f0efef; margin-left:11px; margin-top:10px; padding-left:2px; color:#000; background:#ececec; line-height:33px;}
#pageWrapper #sidebar #search-panel .example{margin-left:12px; font-family:tahoma; font-size:9px; color:#999999; margin-top:2px;}

#pageWrapper #sidebar #search-panel .box{position:relative; height:33px; width:148px;  border:1px solid #f0efef; margin-left:11px; margin-top:10px; padding-left:8px; line-height:33px; background:#fff; color:#999999; font-size:12px; font-family:tahoma; box-shadow: 2px 4px 5px;}
#pageWrapper #sidebar #search-panel .box a{background:#fff url(../../images/f/search-shape.png) no-repeat center right; float:left; width:130px; color:#999999;}

#pageWrapper #sidebar #search-panel .search-logo{position:relative; float:left; margin-left:11px; width:63px; height:26px; margin-top:15px; background:url(../../images/f/search-logo.png) no-repeat top left;}
#pageWrapper #sidebar #search-panel .search-advanced{ float:right; margin-right:25px; margin-top:15px; color:#0066cc; font-size:11px; text-align:center; width:50px;}
#pageWrapper #sidebar #search-panel .search-advanced a{color:#0066cc;}
#pageWrapper #sidebar #search-panel .search-advanced a:hover{text-decoration:underline;}

#pageWrapper #sidebar .left-ads{position:relative; width:120px; height:240px; line-height:350px; text-align:center; color:#fff; background:#ccc; margin:0 auto;}
#pageWrapper #sidebar .left-ads img{width:120px; height:240px; display:none;}
/* page
 ------------------------------------------------------------------------------------- */
 
 /* Header */
#page #header{position:relative; width:790px; height:135px; background:#fff; margin-left:0; z-index:10;}
#page #header .header-adss{position:relative; width:728px; height:90px;  margin:0 auto; margin-top:7px; line-height:90px; text-align:center; color:#fff; background:#ccc;}
#page #header .header-adss img{ width:728px; height:90px; display:none;}
#page #header .country-container{position:relative; float:left; margin-left:15px; margin-top:15px;}
#page #header .country-container .country{float:left; color:#004175; font-size:12px; padding-left:20px; max-width:145px;}
#page #header .country-container .shape{float:left; width:12px; height:15px; background:url(../../images/f/country-shape.png) no-repeat center center; margin-left:10px;}
#page #header .country-container .shape a{ width:12px; height:15px; display:block;}
#page #header .country-container .home{float:left; width:19px; height:19px; margin-left:10px; background:url(../../images/f/country-home.png) no-repeat left top; margin-top:-4px;}
#page #header .country-container .home a{width:19px; height:19px; display:block;}
#page #header .country-container ul.location-box{position:absolute; float:left; left:0; margin-top:16px; width:760px; min-height:150px; background:#eee; border:1px solid #f0efef; padding:0 2px; display:none;}
#page #header .country-container ul.location-box li{ margin:5px 0 12px 0; padding:0; clear:both;}
#page #header .country-container ul.location-box li img{width:15px; height:10px;}
#page #header .country-container ul.location-box li ul{position:relative; margin-left:20px; display:none;}
#page #header .country-container ul.location-box li ul li{position:relative; float:left; width:135px; margin:5px 0 0 12px; clear:none;}
#page #header .country-container ul.location-box li ul li span img{display:none;}
#page #header .country-container ul.location-box li ul li a{background:url(../../images/f/item/violet-bullet.png) no-repeat left center; padding-left:15px;}

#page #header .country-container .loc-shape{float:left; width:12px; height:15px; background:url(../../images/f/country-shape.png) no-repeat center center; margin:0 5px; cursor:pointer;}

#inline1-bg{position:fixed; width:100%; height:100%; background:#000; background:rgba(0,0,0,0.7); display:block; top:0; left:0; z-index:999999999;}
#inline1{position:relative; min-height:500px; width:775px; margin:0 auto; text-align:left;  margin-top:100px; padding:10px; background:#eee;}
#inline1 #inline1-logo{position:absolute; width:186px; height:52px; bottom:5px; right:5px; display:block; background:url(../../images/f/location-popup-logo.png) no-repeat bottom right; z-index:1;}
#inline1 .country{float:left; color:#004175; font-size:12px; padding-left:20px; max-width:145px;}
#inline1 .shape{float:left; width:12px; height:15px; background:url(../../images/f/country-shape.png) no-repeat center center; margin-left:10px;}
#inline1 .shape a{ width:12px; height:15px; display:block;}
#inline1 .home{float:left; width:19px; height:19px; margin-left:10px; background:url(../../images/f/country-home.png) no-repeat left top; margin-top:-4px;}
#inline1 .home a{width:19px; height:19px; display:block;}
#inline1 ul.location-box{position:absolute; float:left; left:0; margin-top:16px; width:760px; min-height:150px; padding:0 2px; z-index:2;}
#inline1 ul.location-box li{ margin:5px 0 12px 0; padding:0; clear:both;}
#inline1 ul.location-box li img{width:15px; height:10px;}
#inline1 ul.location-box li ul{position:relative; margin-left:20px; display:none;}
#inline1 ul.location-box li ul li{position:relative; float:left; width:135px; margin:5px 0 0 12px; clear:none;}
#inline1 ul.location-box li ul li span img{display:none;}
#inline1 ul.location-box li ul li a{background:url(../../images/f/item/violet-bullet.png) no-repeat left center; padding-left:15px;}

#inline1 .loc-shape{float:left; width:12px; height:15px; background:url(../../images/f/country-shape.png) no-repeat center center; margin:0 5px; cursor:pointer;}


#page #header .header-right {float:right; right:0; height:20px; margin-top:10px;}
#page #header .header-right > ul{ height:20px; display:block;}
#page #header .header-right > ul > li{ float:right; height:15px; position:relative;}
#page #header .header-right > ul > li.sep{border-right:2px dotted #9e579d;}
#page #header .header-right > ul > li > a{ height:15px; line-height:15px; padding:0 10px; color:#000; display:block; font-size:14px; font-weight:bold;}
#page #header .header-right > ul > li > a#facebook{background:url(../../images/f/header-facebook.png) no-repeat top center; width:20px; height:20px; margin-top:-3px;}
#page #header .header-right > ul > li > a:hover, #page #header .header-right > ul > li > a.selected, #page #header .header-right > ul > li:hover > a{color:#9e579d;}

.login-box{position:absolute; float:right; right:0; margin-top:30px; width:200px; min-height:190px; background:#eee; border:1px solid #f0efef; display:none;}
.login-box .j-form .field .input input[type="text"], .login-box .j-form .field .input input[type="password"], .login-box .j-form .field .input select, .login-box .j-form .field .input textarea{width:175px;}
.login-box #forgot_password{position:relative; text-align:center;}
.login-box #forgot_password a{color:#77BE43;}
.login-box #forgot_password a:hover{color:#999;}

#page #menu{ width:790px; height:65px; position:relative; margin-top:9px; z-index:9;}
#page #menu #main-navigation { position:absolute; top:0; left:0; height:65px;}
#main-navigation > ul{ height:65px; display:block;}
#main-navigation > ul > li{float:left; height:65px; width:130px; background:#fff; padding:0; }
#main-navigation > ul > li.sep{ border-left:none;}
#main-navigation > ul > li > a{position:absolute; top:0; height:65px; width:130px; display:block; background:url(../../images/f/menu/menu-point.png) repeat; z-index:5;}
#main-navigation > ul > li > div.shape{position:relative; z-index:3; width:130px; height:8px; background:url(../../images/f/menu/menu-shape.png) no-repeat bottom center; display:block;}
#main-navigation > ul > li > a:hover,#main-navigation > ul > li:hover > span{}
#main-navigation > ul > li:hover{background:#f0efef;}
#main-navigation > ul > li:hover > div.shape{display:block;}
#main-navigation > ul > li > span{ height:55px; line-height:55px; padding:0 10px; color:#000; display:block; text-align:center; font-size:22px; position:relative; z-index:2;}

#menuLog { font-size:1.4em; margin:20px; }
.hidden { position:absolute; top:0; left:-9999px; width:1px; height:1px; overflow:hidden; }
.positionHelper{z-index:10; left: 50% !important; margin-left: -315px; width: 783px !important;}

/* #main-navigation > ul > li > span#motors{background:url(../../images/f/menu/menu-motors.png) no-repeat top center;}
#main-navigation > ul > li > span#classifieds{background:url(../../images/f/menu/menu-classifieds.png) no-repeat top center;}
#main-navigation > ul > li > span#properties{background:url(../../images/f/menu/menu-properties.png) no-repeat top center;}
#main-navigation > ul > li > span#jobs{background:url(../../images/f/menu/menu-jobs.png) no-repeat top center;}
#main-navigation > ul > li > span#community{background:url(../../images/f/menu/menu-community.png) no-repeat top center;}
#main-navigation > ul > li > span#deals{background:url(../../images/f/menu/menu-deals.png) no-repeat top center;}

#main-navigation > ul > li > div.submenu-box-container{position:absolute; left:0; top:65px; display:none; }
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box{position:relative; width:785px; display:block; background:#fff; border:1px solid #f0efef;}
#main-navigation > ul > li:hover > div.submenu-box-container{ display:block;}


#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul{ top:0; left:0px; display:block; position:relative; width:200px; background:#fff;}
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li > a{ color:#666; padding:5px; margin-right:5px; display:block; line-height:12px; font-weight:bold;}
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li:hover{ background:#800080; color:#fff;}
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box  > ul > li:hover > a{ background:url(../../images/f/menu/submenu-shape.png) no-repeat right center; color:#fff;}
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li:hover > ul{ display:block;}

#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li > ul{ left:200px; top:0px; display:none; position:absolute; width:585px; background:#f5b0f5;}
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li > ul > div.title{text-decoration:underline; color:#000;}
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li > ul > li{ color:#333; width:195px; display:block; float:left;}
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li > ul > li > a{ color:#333; padding:5px; display:block;}
#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li > ul > a:hover,#main-navigation > ul > li > div.submenu-box-container > div.submenu-box  > ul > li > ul > li:hover > a{color:#fff; background:#77be43;}*/

/* banner */
#page .banner-container{position:relative; width:790px; height:38px; margin-top:25px; background:none;}
#page .banner-container .banner-text{position:relative; width:450px; height:38px; line-height:38px; font-size:24px; margin:0 auto; text-align:center;}

/* body */
#page #body{position:relative; width:795px; margin-top:15px; padding-bottom:45px; z-index:8;}

/* home box categories */
#page #body .box-container{float:left; width:193px; min-height:220px; margin:30px 35px 0  35px;}
#page #body .box-container .box-image-link{width:193px; height:168px; display:block;}
#page #body .box-container .title-container{position:relative; padding:0;}
#page #body .box-container .title-container.border-1{ border-bottom:2px solid #800080;}
#page #body .box-container .title-container.border-2{ border-bottom:2px solid #77be43;}
#page #body .box-container .title-container.border-3{ border-bottom:2px solid #dc4a25;}
#page #body .box-container .title-container .title{float:left; left:0; color:#000; font-size:18px; font-weight:bold;}
#page #body .box-container .title-container a{float:right; right:0; color:#999999; font-size:13px; margin-top:4px;}
#page #body .box-container .title-container a:hover{text-decoration:underline;}
/*<!--#page #body .box-container .box-image-motors{width:193px; height:168px; background:url(../../images/f/home/motors-bg.jpg) no-repeat top left; margin-bottom:5px;}
#page #body .box-container .box-image-classifieds{width:193px; height:168px; background:url(../../images/f/home/classifieds-bg.jpg) no-repeat top left; margin-bottom:5px;}
#page #body .box-container .box-image-properties{width:193px; height:168px; background:url(../../images/f/home/properties-bg.jpg) no-repeat top left; margin-bottom:5px;}
#page #body .box-container .box-image-jobs{width:193px; height:168px; background:url(../../images/f/home/jobs-bg.jpg) no-repeat top left; margin-bottom:5px;}
#page #body .box-container .box-image-community{width:193px; height:168px; background:url(../../images/f/home/community-bg.jpg) no-repeat top left; margin-bottom:5px;}
#page #body .box-container .box-image-deals{width:193px; height:168px; background:url(../../images/f/home/deals-bg.jpg) no-repeat top left; margin-bottom:5px;}-->*/
#page #body .box-container .box-image{width:193px; height:168px; background:url(../../images/f/home/home_list_bg.jpg) no-repeat top left; margin-bottom:5px;}
#page #body .box-container .box-image-motors{ background-position:0 0;}
#page #body .box-container .box-image-classifieds{ background-position:0 -168px;}
#page #body .box-container .box-image-properties{ background-position:0 -336px;}
#page #body .box-container .box-image-jobs{ background-position:0 -504px;}
#page #body .box-container .box-image-community{ background-position:0 -672px;}
#page #body .box-container .box-image-deals{ background-position:0 -840px;}

#page #body .box-container a.place-ads{height:21px; line-height:21px; color:#519603; font-size:14px; background:url(../../images/f/category-place-ads.png) no-repeat top right; display:block; margin-top:4px;}
#page #body .box-container a.place-ads:hover{color:#ccc;}

#page #body .box-container a.search-ads{float:left; height:25px; line-height:22px; color:#000; font-size:14px; display:block; margin-top:10px;}
#page #body .box-container a.search-ads:hover{color:#ccc;}


#page #body .box-container .search-ads-icons{float:right; width:26px; height:25px; display:block; background:url(../../images/f/home/home-search-ads-icons.png) no-repeat top left; margin-top:10px;}
#page #body .box-container .search-ads-motors{background-position:0 0; }
#page #body .box-container .search-ads-classifieds{background-position:0 -25px; }
#page #body .box-container .search-ads-properties{ background-position:0 -50px; }
#page #body .box-container .search-ads-jobs{background-position:0 -75px; }
#page #body .box-container .search-ads-community{background-position:0 -100px; }
#page #body .box-container .search-ads-deals{ background-position:0 -125px; }


/* List Page */
.list-page{position:relative;}
	.list-page .list-samelevel{position:relative; border:1px solid #f0efef; padding:5px; margin-top:15px;}
		.list-page .list-samelevel .title-box{border-bottom:2px dotted #f0efef; padding:2px; margin-bottom:5px;}
		.list-page .list-samelevel .title-box span{color:#7d7b7b; font-size:14px;}
		.list-page .list-samelevel .title-box a{color:#000;}
		.list-page .list-samelevel .title-box a:hover{color:#ccc;}
		.list-page .list-samelevel .item{float:left; margin-right:10px; margin-left:5px; width:245px; height:26px; line-height:15px;}
		.list-page .list-samelevel .item a{float:left; color:#040404; font-size:15px; background:url(../../images/f/item/violet-bullet.png) no-repeat left center; padding-left:10px;}
		.list-page .list-samelevel .item a:hover{color:#aaa;}
		.list-page .list-samelevel .item a span{color:#0066cc;}


	.list-page .list-subcategories{position:relative; border:1px solid #f0efef; padding:5px; margin-top:15px;}
		.list-page .list-subcategories .title-box{border-bottom:2px dotted #f0efef; padding:2px; margin-bottom:5px;}
		.list-page .list-subcategories .title-box span{color:#7d7b7b; font-size:14px;}
		.list-page .list-subcategories .title-box a{color:#000;}
		.list-page .list-subcategories .title-box a:hover{color:#ccc;}
		.list-page .list-subcategories .item{float:left; margin-right:10px; margin-left:5px; width:245px; height:26px; line-height:15px;}
		.list-page .list-subcategories .item a{float:left; color:#040404; font-size:15px; background:url(../../images/f/item/violet-bullet.png) no-repeat left center; padding-left:10px;}
		.list-page .list-subcategories .item a:hover{color:#aaa;}
		.list-page .list-subcategories .item a span{color:#0066cc;}

	.list-page .list-ads{position:relative;  padding:5px; margin-top:15px;}
	.list-page .list-ads .empty-list{position:relative; background: none repeat scroll 0 0 #9E579D; color: #FFFFFF; font-size: 16px; padding: 2px 0; text-align: center;}
	.list-page .list-ads .big-title{border-bottom:1px solid #f0efef; margin-bottom:20px;}
    
    .list-page .list-ads .item{position:relative; border:1px solid #ddd; padding:5px; margin-top:15px;}
		.list-page .list-ads .item .image{position:relative; float:left; width:170px; height:auto; }
		.list-page .list-ads .item .image img.image-ads{display:block; width:170px; height:110px;}
		.list-page .list-ads .item .title{position:relative; float:left; margin-left:10px; width:440px;}
		.list-page .list-ads .item .title .name{color:#800080; font-size:16px; font-weight:bold;}
		.list-page .list-ads .item .title .name:hover{color:#000;}
		.list-page .list-ads .item .title .date{color:#cccccc; font-size:13px;}
		
		.list-page .list-ads .item .description{position:relative; float:left; left:0; margin-top:8px;}
		.list-page .list-ads .item .description .price{float:left; color:#800080; font-size:18px;}
		.list-page .list-ads .item .description .price .currency{color:#7d7b7b; font-size:14px;}
		.list-page .list-ads .item .description .desc{position:relative; float:left; margin-top:10px;}
		.list-page .list-ads .item .description .desc div{ float:left; font-size:13px;}
		.list-page .list-ads .item .description .desc div .name{color:#800080; float:left; width:150px; font-size:13px; font-weight:normal;}
		.list-page .list-ads .item .description .desc div .text{color:#7d7b7b; font-size:13px; font-weight:normal; float:right; width:290px;}
		
		.list-page .list-ads .item .member-container{position:relative; float:right; right:0; width:150px; }
		.list-page .list-ads .item .member-container .price{float:right; color:#800080; font-size:18px; margin-bottom:10px;}
		.list-page .list-ads .item .member-container .price .currency{color:#7d7b7b; font-size:14px;}
		.list-page .list-ads .item .member-container .member-image{position:relative; width:100px; height:100px; float:right; right:0;}
		.list-page .list-ads .item .member-container .member-image img{position:relative; width:100px; height:100px; display:block;}
		.list-page .list-ads .item .member-container .member-name{position:relative; float:right; right:4px;}
		.list-page .list-ads .item .member-container .member-name .listed-title{float:left; left:0; font-size:14px; color:#800080;}
		.list-page .list-ads .item .member-container .member-name .listed-text{float:left; left:0; font-size:14px; color:#7d7b7b;}
		.list-page .list-ads .item .member-container .member-name .listed-text a{color:#7d7b7b;}
		.list-page .list-ads .item .member-container .member-name .listed-text a:hover{color:#999;}
		.list-page .list-ads .item .member-container .view-profile{position:relative; float:right; right:20px;}
		.list-page .list-ads .item .member-container .view-profile a{font-size:16px; color:#000;}
		.list-page .list-ads .item .member-container .view-profile a:hover{color:#999;}
		
		.list-page .list-ads .item #status_ads{position:absolute; bottom:1px; right:2px; color:#800080; font-size:12px;}
		.list-page .list-ads .item #status_ads a{color:#800080;}
		.list-page .list-ads .item #status_ads a:hover{color:#000; text-decoration:underline;}
		
		.list-page .list-ads .item .location-box{position:relative; background:url(../../images/f/item/location-breadcumb.png) no-repeat left top; padding-left:20px; font-size:13px !important; color:#7d7b7b; margin-top:5px; width:500px; float:left;}
		.list-page .list-ads .item .location-box a{color:#800080;}
		.list-page .list-ads .item .location-box a:hover{color:#000;}
		.list-page .list-ads .item .category-box{position:relative; background:url(../../images/f/item/item-breadcumb.png) no-repeat left center; padding-left:20px; font-size:13px!important; color:#7d7b7b; margin-top:5px; width:500px; float:left;}
		
		.list-page .shape{float:right; height:15px; background:url(../../images/f/country-shape.png) no-repeat right center; margin-right:10px; margin-top:8px;}
		.list-page .shape a{ height:15px; display:block; padding-right:15px;}
		.list-page ul.sorting-box{position:absolute; float:right; right:0; margin-top:8px; width:180px; background:#eee; border:1px solid #f0efef; padding:0 2px; display:none; clear:both; z-index:10;}
		.list-page ul.sorting-box li{ margin:2px 0; padding:0; padding-left:5px;}
		.list-page ul.sorting-box li a.selected{color:#800080;}
		.list-page .sorted{padding:0!important; margin:0!important; }
		
		.empty-list{position:relative; background: none repeat scroll 0 0 #9E579D; color: #FFFFFF; font-size: 16px; padding: 2px 0; text-align: center; margin-top:10px;}
/* Preview Page */
.preview-page{position:relative;}
	.preview-page .list-samelevel{position:relative; border:1px solid #f0efef; padding:5px; margin-top:15px;}
		.preview-page .list-samelevel .title-box{border-bottom:2px dotted #f0efef; padding:2px; margin-bottom:5px;}
		.preview-page .list-samelevel .title-box span{color:#7d7b7b; font-size:14px;}
		.preview-page .list-samelevel .item{float:left; margin-right:10px; margin-left:5px; width:245px; height:26px; line-height:15px;}
		.preview-page .list-samelevel .item a{float:left; color:#040404; font-size:15px; background:url(../../images/f/item/violet-bullet.png) no-repeat left center; padding-left:10px;}
		.preview-page .list-samelevel .item a:hover{color:#aaa;}
		.preview-page .list-samelevel .item a span{color:#0066cc;}


	.preview-page .list-subcategories{position:relative; border:1px solid #f0efef; padding:5px; margin-top:15px;}
		.preview-page .list-subcategories .title-box{border-bottom:2px dotted #f0efef; padding:2px; margin-bottom:5px;}
		.preview-page .list-subcategories .title-box span{color:#7d7b7b; font-size:14px;}
		.preview-page .list-subcategories .item{float:left; margin-right:10px; margin-left:5px; width:245px; height:26px; line-height:15px;}
		.preview-page .list-subcategories .item a{float:left; color:#040404; font-size:15px; background:url(../../images/f/item/violet-bullet.png) no-repeat left center; padding-left:10px;}
		.preview-page .list-subcategories .item a:hover{color:#aaa;}
		.preview-page .list-subcategories .item a span{color:#0066cc;}

	.preview-page .preview-ads{position:relative;  padding:5px; margin-top:15px; border:1px solid #f0efef;}
		.preview-page .preview-ads .left-block{position:relative; width:365px; float:left; left:0; overflow:hidden;}
			.preview-page .preview-ads .left-block .image{position:relative; width:365px; height:245px; cursor:pointer;}
			.preview-page .preview-ads .left-block .image img{display:block; width:365px; height:245px;}
			.preview-page .preview-ads .left-block .image .enlarge{position:absolute; right:0; bottom:-22px; background:#77be43; color:#fff; padding:2px 4px; font-weight:bold;}
			.preview-page .preview-ads .left-block .image .enlarge:hover{color:#000;}
			
			.preview-page .preview-ads .left-block .description {position:relative; float:left; margin-top:30px; margin-right:10px;}
			.preview-page .preview-ads .left-block .description div{ float:left; margin-left:10px; margin-top:5px; font-size:14px; clear:both;}
			.preview-page .preview-ads .left-block .description div .name{color:#800080; font-size:14px; float:left; width:150px;}
			.preview-page .preview-ads .left-block .description div .text{color:#7D7B7B; font-size:14px; float:right; width:195px;}
			.preview-page .preview-ads .left-block .description div .text.description-box{float:none; width:auto;}

		.preview-page .preview-ads .right-block{position:relative; width:400px; float:right; right:0;}
			.preview-page .preview-ads .right-block .title{position:relative; float:left; margin-left:10px;}
			.preview-page .preview-ads .right-block .title .name{color:#800080; font-size:22px; font-weight:bold;}
			.preview-page .preview-ads .right-block .title .date{color:#cccccc; font-size:13px;}
			
			.preview-page .preview-ads .right-block .price{float:right; color:#800080; font-size:18px;}
			.preview-page .preview-ads .right-block .price .currency{color:#7d7b7b;}
			
			.preview-page .preview-ads .right-block .contact-block{position:relative; margin-top:8px;}
			.preview-page .preview-ads .right-block .contact-block .details{width:130px; height:35px; display:block; background:#f7f7f7; font-size:16px; color:#77BE43; line-height:35px; text-align:center; float:left; margin:0 25px; font-weight:bold;}
			.preview-page .preview-ads .right-block .contact-block .details#favorite-button{color:#0066CC;}
			.preview-page .preview-ads .right-block .contact-block .details#tellfriend-button{color:#0066CC; margin-left:42px;}
			.preview-page .preview-ads .right-block .contact-block .details#favorite-button:hover,.preview-page .preview-ads .right-block .contact-block .details#tellfriend-button:hover{color:#800080;}
			.preview-page .preview-ads .right-block .contact-block .details:hover{color:#800080;}
			.preview-page .preview-ads .right-block .contact-block .contact-seperator{float:left; left:5px; font-size:20px; color:#7D7B7B; padding-top:12px;}
			.preview-page .preview-ads .right-block .facebook-block{position:relative; float:left; left:25px; margin-top:15px; width:350px;}
			.preview-page .preview-ads .right-block .phone{position:relative; background:#f7f7f7; text-align:center; font-size:16px; color:#7d7b7b; margin-top:15px; padding:5px; display:none;}
			.preview-page .preview-ads .right-block .mailing{position:relative; background:#f7f7f7; text-align:center; font-size:16px; color:#7d7b7b; margin-top:15px; padding:5px; display:none;}
			.preview-page .preview-ads .right-block .tellfriend-mailing{position:relative; background:#f7f7f7; text-align:center; font-size:16px; color:#7d7b7b; margin-top:15px; padding:5px; display:none;}
			
			.preview-page .preview-ads .right-block .location-box{postion:relative; background:url(../../images/f/item/location-breadcumb.png) no-repeat left top; padding-left:20px; font-size:13px; color:#7d7b7b; margin-top:5px;}
			.preview-page .preview-ads .right-block .location-box a{color:#800080;}
			.preview-page .preview-ads .right-block .location-box a:hover{color:#000;}
			.preview-page .preview-ads .right-block .category-box{postion:relative; background:url(../../images/f/item/item-breadcumb.png) no-repeat left center; padding-left:20px; font-size:13px; color:#7d7b7b; margin-top:5px;}
			.preview-page .preview-ads .right-block .advertisement{position:relative; background:#ccc; width:300px; height:250px; line-height:250px; color:#fff; text-align:center; margin:0 auto; margin-top:15px;}
			
			.preview-page .preview-ads .right-block .related-block{position:relative; margin-top:15px;}
			.preview-page .preview-ads .right-block .related-block .rel-title{font-size:18px; color:#800080; font-weight:bold; border-bottom:1px dotted #ccc; padding-bottom:5px;}
			.preview-page .preview-ads .right-block .related-block .item{position:relative; margin-top:10px;}
			.preview-page .preview-ads .right-block .related-block .item img{float:left; width:130px; height:90px;}
			.preview-page .preview-ads .right-block .related-block .item .desc{float:left; width:260px; margin-left:5px;}
			.preview-page .preview-ads .right-block .related-block .item .desc .name a{color:#000; font-size:18px; font-family:'calibri';}
			.preview-page .preview-ads .right-block .related-block .item .desc .name a:hover{color:#ccc;}
			.preview-page .preview-ads .right-block .related-block .item .desc .location{postion:relative; background:url(../../images/f/item/location-breadcumb.png) no-repeat left top; padding-left:15px; font-size:13px; color:#7d7b7b; margin-top:5px;}
			.preview-page .preview-ads .right-block .related-block .item .desc .price{float:right; color:#bc0057; font-size:16px;}
	.preview_ad_buttons{position:relative; margin:10px;}
		.preview_ad_buttons .button{background:#CCC; border:1px solid #f0efef; color:#9E579D; cursor:pointer; font-weight:bold; padding:5px; margin:0 5px;}
		.preview_ad_buttons .button:hover{color:#fff;}
		
/* View Member Profile
 ------------------------------------------------------------------------------------- */ 		
.member-page{position:relative; margin-top:15px;}
.member-page .member-image{position:relative; width:100px; height:100px; float:left; left:0; }
.member-page .member-image img{position:relative; width:100px; height:100px; display:block;}
.member-page .member-name{position:relative; float:left; left:0; margin-top:10px; clear:both;}
.member-page .member-name .listed-title{float:left; left:0; font-size:14px; color:#800080; width:120px;}
.member-page .member-name .listed-text{float:left; left:0; font-size:14px; color:#7d7b7b;}
.member-page .view-profile{position:relative; float:left; left:0;}
.member-page .view-profile a{font-size:14px; color:#800080;}
.member-page .view-profile a:hover{font-size:14px; color:#7d7b7b;}
.member-page .member-location{postion:relative; background:url(../../images/f/item/location-breadcumb.png) no-repeat left top; padding-left:20px; font-size:13px; color:#7d7b7b; margin-top:5px;}
.member-page .member-location a{color:#800080;}
.member-page .member-location a:hover{color:#000;}
 
/* Tree Wrapper
 ------------------------------------------------------------------------------------- */ 
#treeWrapper #tree-container{width:960px; margin:0 auto; position:relative;}
#treeWrapper #tree-container #left-tree{position:absolute; width:161px; height:127px; left:-170px; top:-124px; background:url(../../images/f/left-tree.png) no-repeat top left;}
#treeWrapper #tree-container #right-tree{position:absolute; width:179px; height:137px; right:-210px; top:-127px; background:url(../../images/f/right-tree.png) no-repeat top left;}
 
 /* Footer Wrapper
 ------------------------------------------------------------------------------------- */
 /* News */
#footerWrapper #news-room-container{width:960px; min-height:180px; margin:0 auto; position:relative; padding:0; padding-bottom:10px;}
#news-room-container .big-title{float:left; height:24px; line-height:24px; font-size:25px; font-weight:bold;}
#news-room-container .big-title a{color:#000;}
#news-room-container .big-title a:hover{color:#000;}
#news-room-container .big-title a span{color:#F58366;}
#news-room-container .big-title a:hover span{color:#F58366;}

#news-room-container .more-all-news{float:right; color:#000; font-size:15px; background:url(../../images/f/more-all-news.png) no-repeat center right; padding-right:16px;}
#news-room-container .more-all-news a:hover{color:#000; text-decoration:underline;}

#news-room-container .news-box{float:left; position:relative; width:470px; height:160px; margin-top:10px;}
#news-room-container .news-box .desc{float:left; width:300px;}
#news-room-container .news-box .desc .title{min-width:220px; font-size:17px; color:#604a7b;}
#news-room-container .news-box .desc .title a{font-size:17px; color:#604a7b;}
#news-room-container .news-box .desc .text{font-size:14px; color:#000; margin-top:12px;}
#news-room-container .news-box .desc a{font-size:14px; color:#000; margin-top:12px; float:left;}
#news-room-container .news-box .desc a:hover{color:#604a7b;}
#news-room-container .news-box .image{float:right; width:170px; text-align:center; margin-top:25px;}
#news-room-container .news-box .image img{width:155px; height:110px;}

#news-room-container .sep{float:left; height:160px; border-right:1px solid #a6a6a6; margin:0 8px;}

/* Footer */
#footerWrapper #footer-container{width:960px; margin:0 auto; position:relative; margin-top:35px; padding:10px 0;}

#footerWrapper #footer-container .footer-left-section{position:relative; float:left; left:0;}
.footer-left-section ul.footer-menu{float:left; left:0; position:relative; width:180px; height:110px; background:url(../../images/f/footer-menu.png) no-repeat top left; padding-left:120px;}
.footer-left-section ul.footer-menu > li{list-style:none; margin-bottom:3px;}
.footer-left-section ul.footer-menu > li > a{color:#333333; font-size:12px;}
.footer-left-section ul.footer-menu > li > a:hover{color:#0066CC;}

.footer-left-section ul.social{float:left;}
.footer-left-section ul.social > li{float:left; left:10px; height:30px;}
.footer-left-section ul.social > li > a{width:30px; height:30px; margin-right:2px; background:url(../../images/f/footer-social.png) no-repeat top left; display:block;}
.footer-left-section ul.social > li > a#facebook{background-position:0 0;}
.footer-left-section ul.social > li > a#facebook:hover{background-position:0 -30px;}
.footer-left-section ul.social > li > a#twitter{background-position:-30px 0;}
.footer-left-section ul.social > li > a#twitter:hover{background-position:-30px -30px;}
.footer-left-section ul.social > li > a#linkedin{background-position:-60px 0;}
.footer-left-section ul.social > li > a#linkedin:hover{background-position:-60px -30px;}
.footer-left-section ul.social > li > a#google{background-position:-90px 0;}
.footer-left-section ul.social > li > a#google:hover{background-position:-90px -30px;}


#footerWrapper #footer-container .footer-right-section{position:relative; float:right; right:0; top:55px;}
.footer-right-section ul.privacy{float:right;}
.footer-right-section ul.privacy > li{float:left; left:10px;}
.footer-right-section ul.privacy > li > a{width:23px; height:23px; margin-right:7px; color:#cccccc; font-size:13px;}
.footer-right-section ul.privacy > li > a:hover{color:#0066CC;}

.footer-right-section #copyright-sochivi{ position:relative; float:right; right:0px; margin-top:15px; font-size:12px; color:#fff;}

ul.footer-country{position:relative;float:right; display:none; margin-top:15px;}
ul.footer-country > li{float:left; left:10px; height:40px;}
ul.footer-country > li > a{width:32px; height:40px; margin-right:4px; background:url(../../images/f/footer-countries.png) no-repeat top left; display:block;}
ul.footer-country > li > a#ksa{background-position:0 0;}
ul.footer-country > li > a#ksa:hover{background-position:0 -40px;}
ul.footer-country > li > a#uae{background-position:-36px 0;}
ul.footer-country > li > a#uae:hover{background-position:-36px -40px;}
ul.footer-country > li > a#kuwait{background-position:-70px 0;}
ul.footer-country > li > a#kuwait:hover{background-position:-70px -40px;}
ul.footer-country > li > a#qatar{background-position:-107px 0;}
ul.footer-country > li > a#qatar:hover{background-position:-107px -40px;}
ul.footer-country > li > a#bahrain{background-position:-144px 0;}
ul.footer-country > li > a#bahrain:hover{background-position:-144px -40px;}
ul.footer-country > li > a#oman{background-position:-179px 0;}
ul.footer-country > li > a#oman:hover{background-position:-179px -40px;}
ul.footer-country > li > a#lebanon{background-position:-220px 0;}
ul.footer-country > li > a#lebanon:hover{background-position:-220px -40px;}

/* Form Generator
 ------------------------------------------------------------------------------------- */ 
.form-generator{ position:relative; margin:5px; padding:5px;}
.form-generator h1.title{margin:5px; border-bottom:1px solid #363092; height:40px; line-height:40px; color:#363092; font-size:22px; margin-bottom:20px;}
.form-generator fieldset{ margin:5px; padding:15px 5px; margin:20px 0; border:1px solid #f0efef; background:#f5f5f5; position:relative;}
.form-generator fieldset legend{ position:absolute; height:30px; left:40px; top:-15px; background:#9E579D; line-height:30px; color:#fff; padding:0 10px;}
.form-generator fieldset .error{ display:none; color:#b10303; background:none; margin:0; padding:5px;}
.form-generator fieldset table{ width:100%;}
.form-generator fieldset th, .form-generator fieldset td{ padding:5px; text-align:left;}
.form-generator fieldset th{ font-weight:bold;}
.form-generator fieldset .required{ color:#000;}
.form-generator fieldset input[type=text],.form-generator fieldset input[type=password],.form-generator fieldset textarea{ padding:5px; width:98%; border:1px solid #f0efef;}
.form-generator fieldset select{ padding:5px; width:100%; border:1px solid #f0efef;}
.form-generator .submit{ margin:5px; padding:5px; background:#eee;}
.form-generator .submit input[type=submit],.form-generator .submit input[type=reset]{ cursor:pointer; padding:5px; background:#ccc; color:#9E579D; font-weight:bold;float:right; border:1px solid #f0efef;}
.form-generator #preview_button{ cursor:pointer; padding:5px; background:#ccc; color:#9E579D; font-weight:bold;float:left; border:1px solid #f0efef;}
.form-generator .submit input[type=submit]:hover,.form-generator .submit input[type=reset]:hover{ background:#9E579D; color:#fff;}

.form-generator .tagsinput{ width:100% !important; background:#faf6af;}
.form-generator .tagsinput .tag{ position:relative; display:inline-block; padding:5px; float:left;}
.form-generator .tagsinput .tag span{ display:block; padding:5px; background:#fabc00;}
.form-generator .tagsinput .tag a{ color:#fff; position:absolute; top:10px; right:7px;}
.form-generator .tagsinput .tag a:hover{ color:#f00;}
.form-generator .tagsinput div{ float:left; padding:8px 5px;}
.form-generator .tagsinput .tags_clear{ clear:both;}
.form-generator .tagsinput input{ padding:4px; position:relative; top:-3px; border:1px solid #f0efef;}
.form-generator .poll{ margin:15px; padding:15px; background:#faf9e1;border:1px solid #f0efef;}
.form-generator .poll .vote{ position:relative;}
.form-generator .poll .result{ position:relative;}
.form-generator .poll h1{ font-weight:bold; font-size:18px;}
.form-generator .poll .vote ul li{ padding:3px; background:#e4e19a; margin:2px;}
.form-generator .poll a{ position:relative; display:block; padding:5px; background:#ccd69d; color:#000; text-align:center; font-weight:bold; margin:2px;}
.form-generator .poll .result .outer-vote{ margin:2px; height:25px; border:2px solid #f0efef; background:#eee; /*width:400px;*/}
.form-generator .poll .result .outer-vote .votes{ background:#1fa92c; color:#fff; height:25px; line-height:25px; text-align:center;}

/* Images Selected List
 ------------------------------------------------------------------------------------- */
.finder-image-list{ position:relative; padding:5px;}
.finder-image-list h3{ color:}
.finder-image-list ul{ margin:0; padding:0; display:block; height:auto; width:100%;}
.finder-image-list ul li{ margin:0; padding:5px; list-style:none; float:left; height:100px; position:relative; overflow:hidden;}
.finder-image-list ul li img{ border:none; height:100px;border:1px solid ;}
.finder-image-list ul li a.remove{ width:36px; height:36px; position:absolute; display:block; top:10px; right:10px;background:;
color:#fff; text-align:center; line-height:33px; font-size:30px; font-family:"Arial Black", Gadget, sans-serif; display:none;}
.finder-image-list ul li:hover a.remove{ display:block;}
.finder-image-list ul li.addnew{width:100px; height:100px; text-align:center; font-size:120px;}
.finder-image-list ul li.addnew a{ border:none; height:100px;border:1px solid #f0efef; display:block;width:100px; height:100px;line-height:90px;
 color:#ccc; font-family:"Arial Black", Gadget, sans-serif;background:#fff;}
.finder-image-list ul li.addnew a:hover{ color:;}


/* J Form
 ------------------------------------------------------------------------------------- */ 
.j-form{ position:relative;}
.j-form .field{ position:relative; padding:5px;}
.j-form .field .label{ width:300px;}
.j-form .field .label label{ display:block; padding:5px 10px; font-size:12px; color:#000; font-weight:bold;}
.j-form .field .label label span.required{ color:#F00; font-size:14px; font-weight:normal;}
.j-form .field .checkbox .label{ width:auto !important;}
.j-form .field .input{ padding:0; float:left; background-color:#938E94; margin-top:10px;}
.j-form .field > .error{ float:left; padding:1px;}
.j-form .field > .error .errorMessage{background-color:none;color:#B10303;padding:0px;font-size:10px;font-weight:bold; border:none; top:0px; position:relative;}
.j-form .field .input input[type=text],.j-form .field .input input[type=password],.j-form .field .input select,.j-form .field .input textarea{padding:5px; width:310px; border:1px solid #f0efef;}
.j-form .field .input #MemberForm_image{width:320px;}
.j-form .field .input select{ width:322px;}
.j-form .field .input textarea{ height:200px;}
.j-form .field .input.success{ background-color:#56c444;}
.j-form .field .input.error{ background-color:#f81b1b;}
.j-form .submit{ padding:5px; text-align:center;}
.j-form .submit input[type=submit],.j-form .submit input[type=reset]{ font-size:14px; text-align:center; padding:5px 10px; color:; cursor:pointer;  background:#77BE43; color:#fff;}
.j-form .submit input[type=submit]:hover,.j-form .submit input[type=reset]:hover{  background:#aaa; color:#fff;}
.j-form .file-container{padding:5px; float:left; width:320px;}
.j-form .file-container .file-field{ position:relative; padding:2px 0px;}
.j-form .file-container .input{ float:none;}
.j-form .file-container a.opt{ position:absolute; top:8px; right:5px; padding:5px; color:#c2c2c2; background-color:#010101; font-size:12px;}
.j-form .file-container a.opt:hover{background-color:; color:#c2d8e6;}
.j-form .image{ position:relative; padding:5px;}
.j-form .image img{ width:100%;}
.j-form .image a.delete{ position:absolute; right:10px; bottom:10px;}
.j-form .outer-images{ position:relative; padding:5px; margin:0 auto;}
.j-form .outer-images .inner-images{ padding:5px; position:relative; border:1px solid #f0efef; background-color:#f5f5f5;}
.j-form .outer-images .inner-images .image{ position:relative; float:left; padding:5px;}
.j-form .outer-images .inner-images .image img{ width:200px;}
.j-form .outer-images .inner-images .image a.delete{ position:absolute; right:10px; bottom:10px;}
.j-form .field .outer-display{ padding:5px; float:left;}
.j-form .field .outer-display .inner-display{ padding:5px; border:1px solid #f0efef; font-size:12px;}
.j-form .outer-section{ position:relative; padding:20px;}
.j-form .outer-section.floatting{float:left; width:344px;}
.j-form .outer-section .inner-section{ border:1px solid #f0efef; position:relative;}
.j-form .outer-section .inner-section .title{ background:#9E579D; padding:5px 20px; 
font-size:12px; font-weight:normal; color:#fff; position:absolute; left:20px; top:-13px; display:block;box-shadow:0px 5px 5px #666; z-index:10;}
.j-form .outer-section .inner-section .title .l{ width:0; height:0; position:absolute; border-left:12px solid transparent;
border-bottom:12px solid #f0efef; top:0px; left:-12px; display:block;}
.j-form .outer-section .inner-section .title .r{ width:0; height:0; position:absolute; border-right:12px solid transparent;
border-bottom:12px solid #f0efef; top:0px; right:-12px; display:block;}
.j-form .outer-section .inner-section .fields{ padding:15px; background-color:#eee;}
.j-form .outer-html{ padding:10px;border:1px solid #f0efef;  background:#fff;}
.j-form .outer-html .inner-html{ padding:10px; background:#fff; font-size:14px; color:#363636; line-height:22px; font-family:"Courier New", Courier, monospace; text-align:justify; } 
.j-form .tagsinput .tag{ position:relative; display:inline-block; padding:5px; float:left;}
.j-form .tagsinput .tag span{ display:block; padding:5px; background:;}
.j-form .tagsinput .tag a{ color:#fff; position:absolute; top:10px; right:7px;}
.j-form .tagsinput .tag a:hover{ color:#f00;}
.j-form .tagsinput div{ float:left; padding:8px 5px;}
.j-form .tagsinput .tags_clear{ clear:both;}

.loader{position:absolute; z-index:10; background:url(../../images/f/bgDark50.png) repeat center; width:100%; height:100%; top:0; left:0; display:none!important;}
#placead_container .loader{position:absolute; z-index:10; background:url(../../images/f/bgDark50.png) repeat center; width:100%; height:100%; top:0; left:0; display:none!important;}
#placead_container #submitPlaceAd{ font-size:14px; text-align:center; padding:5px 10px; color:; cursor:pointer;  background:url(../../images/ui/selectbox_bg.png) repeat-x top center; color:#333;}
#placead_container #submitPlaceAd:hover{  background:#aaa; color:#fff;}
/* CMS
 ------------------------------------------------------------------------------------- */ 
.cms-title{margin:5px; border-bottom:1px solid #F58366; height:40px; line-height:40px; color:#F58366; font-size:22px;}
.cms-text{ margin:5px; padding:5px; background:#fff; line-height:22px; text-align:justify; font-size:14px;}
.cms-text img{width:155px; height:110px; border:1px solid #F58366; float:left; margin-right:10px;}
.cms-comments{ margin:20px;}
.cms-comments .cms-comment{ margin:20px; padding:20px; background:#363092; color:#fff;}
.cms-comments .cms-comment .cms-h{ padding:5px; background:#fabb02; color:#363092;}
.cms-comments .cms-comment .cms-h span{ font-size:14px; font-weight:bold;}
.cms-comments .cms-comment .cms-t{ padding:5px;}

.category-list{ margin:10px; padding:10px;}
.category-list ul{ margin:0; padding:0; dispaly:block;}
.category-list ul li{ margin:5px; width:300px; height:100px; float:left; list-style:none;}
.category-list ul li a{ width:300px; height:100px; line-height:100px; display:block; background:#363092; color:#fff; text-align:center; font-weight:bold; font-size: 16px; }
.category-list ul li a:hover{background:#fabb02; color:#363092;}

.content-list{ margin:10px; padding:10px;}
.content-list ul{ margin:0; padding:0; dispaly:block;}
.content-list ul li{ margin:6px; list-style:none; float:left; width:48%;}
.content-list ul li a{display:block; background:none; color:#F58366; text-align:left; font-weight:bold; font-size: 16px; padding:5px; }
.content-list ul li a:hover{ color:#aaa;}
.content-list ul li div.text{ background:#fff; padding:5px; font-size:14px; line-height:22px; text-align:justify;}
.content-list ul > li > div.text a{ background:none!important; padding:0px; font-size:14px; line-height:22px; text-align:justify; color:#F58366; font-weight:normal; display:inline-block;}
.content-list ul > li > div.text a:hover{color:#aaa;}
.content-list ul li div.text img{width:155px; height:110px; float:left; margin-right:10px;} 

/* -- Pagination
----------------------------------------------------------------------------------------*/

.pagination{position:relative; height:18px; padding:10px; }
.pagination ul{margin:0 auto;height:12px;padding:0px 9px; position:relative; width:400px;}
.pagination li{list-style:none; float:left; display:inline-block; padding-right:5px;}
.pagination li a:link, .pagination li a:visited{color:#800080; display:block; padding:3px 0;border-radius:15px;-moz-border-radius:15px;-webkit-border-radius:15px; background-color:#e9e9e9;border:1px solid #d4d4d4; width:24px; font-size:14px; text-align:center}
.pagination li a:hover{color:#fff; background-color:#77be43; border-color:#77be43;}
.pagination .yiiPager .selected a{color:#fff; background-color:#77be43; border-color:#77be43;}
.pagination .yiiPager .hidden a{visibility:hidden;}

.pagination .yiiPager .next a,.pagination .yiiPager .last a,.pagination .yiiPager .first a,.pagination .yiiPager .previous a{}
.pagination .yiiPager .first a{}
.pagination .yiiPager .last a{}
.pagination .yiiPager .previous a{}
.pagination .yiiPager .next a{}

.message-box{padding:5px; background:#800080; color:#fff; font-size:14px;}

/*-- UI 
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
/*-- Range Slider 
------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
.ui-range-slider{ height:30px; position:relative;}
.ui-range-slider .numbers{ position:absolute; top:0px; width:100%; height:25px;}
.ui-range-slider .numbers .n1,.ui-range-slider .numbers .n2{ position:absolute; top:7px; font-size:11px;}
.ui-range-slider .ranger{ position:absolute !important; top:25px; width:100%; height:4px !important; background:#d7d7d7;}
.ui-range-slider .ranger.ui-slider .ui-slider-handle{ width:14px; height:14px; background:url(../../images/ui/slider_handle.png) no-repeat top left; border:none; position:absolute;}
.ui-slider-range{ background:url(../../images/ui/slider_zone_selected.png) repeat-x top center; overflow:hidden;}
/*-- Select Box 
------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
.ui-selectbox{ height:34px; border:1px solid #f0efef; -moz-border-radius:2px; -webkit-border-radius:2px; border-radius:2px; position:relative;}
.ui-selectbox .prompt{ height:34px; position:relative; width:100%; background:url(../../images/ui/selectbox_bg.png) repeat-x top center;}
.ui-selectbox .prompt:hover{ background-position:0px -34px;}
.ui-selectbox .prompt .value{ cursor:pointer; position:absolute; top:0px; height:34px; line-height:34px; left:0px; right:30px; text-overflow:ellipsis;overflow:hidden;white-space:nowrap; padding:0px 10px; color:#acacac;}
.ui-selectbox .prompt .arrow{ background:url(../../images/ui/selectbox_arrow.png) no-repeat top left; width:29px; height:34px; position:absolute; top:0px; right:0px; border-left:1px solid #d3d3d3; cursor:pointer;}
.ui-selectbox .prompt:hover .arrow{ background-position:0px -34px;}
.ui-selectbox .list{ position:absolute; top:36px; left:-1px; border:1px solid #f0efef; -moz-border-radius:2px; -webkit-border-radius:2px; border-radius:2px; width:100%; background:url(../../images/ui/selectbox_list_bg.png) repeat-x bottom center #fafafa; display:none; max-height:238px; overflow:auto; z-index:999;}
.ui-selectbox .list ul{ margin:0; padding:0; display:block; position:relative; background:url(../../images/ui/selectbox_list_top_bg.png) repeat-x top center;}
.ui-selectbox .list ul li{ display:block; list-style:none;}
.ui-selectbox .list ul li a{ list-style:none; display:block; height:34px; line-height:34px; padding:0px 5px; font-size:14px; color:#555; cursor:pointer; text-overflow:ellipsis; overflow:hidden; white-space: nowrap; text-decoration:none;}
.ui-selectbox .list ul li a:hover{ background-color:#283891; color:#fff;}
.ui-selectbox .list ul li.selected a{ background:url(../../images/ui/selectedbox_list_item_selected.png) no-repeat 5px center #fff; border-bottom:1px solid #d3d3d3; border-top:1px solid #d3d3d3; padding-left:25px; color:#555;}
.ui-selectbox .list ul li.first.selected{ border-top:none;}
.ui-selectbox .list ul li.last.selected{ border-bottom:none;}
.ui-selectbox .list ul li.empty{ color:#CCC; font-size:12px;}
/*-- Check Box 
------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
.ui-checkbox{ width:16px; height:17px; background:url(../../images/ui/checkbox.png) no-repeat 0px 0px; cursor:pointer;}
.ui-checkbox.checked{ background-position:0px -17px;}
/*-- Text Field 
------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
.ui-textfield{ height:25px; border:1px solid #f0efef; overflow:hidden; -moz-border-radius:2px; -webkit-border-radius:2px; border-radius:2px;}
.ui-textfield input[type=text]{ height:25px; line-height:25px; border:none;border-color: transparent;}
.ui-textfield .inputdiv{ height:25px; line-height:25px; cursor:text;}
/* 
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 /UI --*/
 
 
 /* -- Search Panel
----------------------------------------------------------------------------------------*/
/* #sidebar{ width:220px; height:380px; background-color:#FFF; border:1px solid #f0efef; position:relative; z-index:2; -webkit-border-radius:2px; -moz-border-radius:2px; border-radius:2px; padding:0px 10px; float:left; }*/
#sidebar .sp-field{ position:relative; height:auto;}
#sidebar .sp-field .label{ position:relative; height:34px;}
#sidebar .sp-field .label label{ color:#3cb6ee; display:block; font-family:"Economica-BoldItalic"; font-size:14pt; height:34px; line-height:34px;}
#sidebar .sp-field .label label sup{ color:#3cb6ee;}
#sidebar .sp-field .input{position:relative; padding:6px 0px;}
#sidebar .sp-field.search-lot{ padding-top:17px;}
#sidebar .sp-field.search-lot .label{ width:50px; padding:5px; padding-top:0px;}
#sidebar .sp-field.search-lot .input{ width:150px;}
#sidebar .sp-field.search-lot .input .ex{ font-size:10px; color:#999999; height:18px; line-height:18px; font-style:italic;}
#sidebar .sp-field.search-type .input label{ font-family:Tahoma, Geneva, sans-serif; color:#3a3a3a; padding:5px; padding-right:15px;}
#sidebar .sp-field.rooms{ width:110px;}
#sidebar .sp-field.sep{border-bottom:1px dotted #d3d3d3;}
#sidebar .submit{ padding:10px; position:relative; height:33px;}
#sidebar .submit a{ background:#77BE43; height:33px; display:block; line-height:32px; text-align:center; font-size:16px; color:#fff; position:absolute; top:10px; left:0; padding:0 10px; width:130px;}
#sidebar .submit a:hover{background-position:0 -34px; }

.search-result{ float:left; margin-left:20px; width:700px;}
.search-result .pagination{ width:700px!important;}


/*-- Search Form Widget
------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
.search-form{position:relative;}
.search-form .simple{position:relative; background:#f0f0f0; margin:3px 0;}
.search-form .advanced{position:relative; background:#f0f0f0; margin:3px 0;}
.search-form .advanced .fields{display:none;}
.search-form .advanced > a{display:block; width:100%; padding:5px 0; text-align:center; background:#800080; color:#fff; font-size:16px;}
.search-form .advanced > a:hover{ background:#ad23ad;}
.search-form input[type=text],.search-form select{ padding:5px; border:1px solid #f0efef; width:138px; background:#fff;}
.search-form select{ width:150px;}
.search-form input[type=text].two{width:62px;}
.search-form select.two{width:73px;}
.search-form input[type=checkbox],.search-form input[type=radio]{margin-left:10px;}
.search-form .twice{width:75px;}
.search-form .twice,.search-form .no-twice{margin-top:10px;}
.search-form label{display:block; color:#000; font-weight:bold; padding:3px;}
.search-form .loader{position:absolute; z-index:10; background:url(../../images/f/bgDark50.png) repeat center; width:100%; height:100%; top:0; left:0; display:none!important;}
.search-form .toggle{display:block;}
.search-form .a-toggle{display:block; text-align:center; color:#999;}
.search-form .a-toggle:hover{text-decoration:underline;}

.rw-ui-report .rw-ui-poweredby{display:none!important; background:#666666!important;}
.rw-ui-report .rw-ui-poweredby a{display:none!important; background:#666666!important;}

#address_mapping{display:none;}
.pickermap{padding:0 !important; border:none !important; width:320px !important;}
.form-generator .pickermap{width:100% !important;}
.addthis_default_style{position:relative; margin-top:10px;}
</style>