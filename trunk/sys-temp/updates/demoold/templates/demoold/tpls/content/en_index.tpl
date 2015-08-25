<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<link type="text/css" rel="stylesheet" href="/templates/demoold/css/style.css"/>
		<link type="text/css" rel="stylesheet" href="/templates/demoold/css/home.css"/>
		<script type="text/javascript">
           var nav = navigator.appName;
		   var ver = navigator.appVersion;
		   var ver1=ver.substring(0,3);
               if ((nav == "Opera")&&((ver1 == "9.5")||(ver1 == "9.6")||(ver1 == "9.8")))
               {
               		 document.write('<link rel="stylesheet" type="text/css" href="/templates/demoold/css/styleEnOpera.css"/>');
					 
					
               }  
			   
		</script>
		<title>%title%</title>

		<meta name="DESCRIPTION" content="%description%" />
		<meta name="KEYWORDS" content="%keywords%" />
		<link rel="shortcut icon" href="/favicon.ico" />

		<script type="text/javascript" src="/js/cross-domain.php"></script>
		<script type="text/javascript" src="/js/client/vote.js" charset="utf-8"></script>
		%system includeQuickEditJs()%
		%system includeEditInPlaceJs()%

		%data getRssMeta(%pid%)%
		%data getAtomMeta(%pid%)%
	</head>
	
	<body id="umi-cms-demo">
		<div id="container">
			%system getOuterContent('./%template_resources%/tpls/content/en_header.inc.tpl')%
			<div id="content">
				<div class="column">
					<div id="welcome" class="block">
						<h2>%header%</h2>
						<div umi:element-id="%pid%" umi:field-name="content">
						%content%
					</div>
					</div>

				</div>

				%news lastlist('/world_news/', 'en_home', 2)%

				<div class="column">
					%search insert_form('en_home')%

					%vote insertlast('en_home')%
				</div>
			</div>
			%system getOuterContent('./%template_resources%/tpls/content/footer.inc.tpl')%
		</div>
	</body>
</html>