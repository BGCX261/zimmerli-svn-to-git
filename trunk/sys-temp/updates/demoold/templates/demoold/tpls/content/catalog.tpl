<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="/templates/demoold/css/style.css?%system_build%"/>
		<link type="text/css" rel="stylesheet" href="/templates/demoold/css/inner.css?%system_build%"/>
		<script type="text/javascript">
           var nav = navigator.appName;
		   var ver = navigator.appVersion;
		   var ver1=ver.substring(0,3);
                if ((nav == "Opera")&&((ver1 == "9.5")||(ver1 == "9.6")||(ver1 == "9.8")))
               {
			     
               		 document.write('<link rel="stylesheet" type="text/css" href="/templates/demoold/css/styleOpera.css"/>');
				 
					
               }  
			   
			   
     </script>
		<title>%title%</title>

		<meta name="DESCRIPTION" content="%description%" />
		<meta name="KEYWORDS" content="%keywords%" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<script type="text/javascript" src="/js/cross-domain.php?%system_build%"></script>

		%system includeQuickEditJs()%
		%system includeEditInPlaceJs()%

		%data getRssMeta(%pid%)%
		%data getAtomMeta(%pid%)%
	</head>
	
	<body id="umi-cms-demo">
		<div id="container">
			%system getOuterContent('./%template_resources%/tpls/content/header.inc.tpl')%
			<div id="content">
				<div id="left" class="column">
					%content menu('sl')%
					
					%emarket currencySelector()%
					%emarket cart('basket')%
					%emarket getCompareList('compare_list')%
				</div>
				<div id="center" class="column">
					%core navibar('default', 1, 0, 1)%

					<h2 umi:element-id="%pid%" umi:field-name="h1">%header%</h2>
					<div umi:element-id="%pid%" umi:field-name="content">
					%content%
				</div>
				</div>
				<div id="right" class="column">
					%search insert_form('home')%
					%catalog getCategoryList('inner', '/market/', '0', '1')%
					%news lastlist('/akcii', 'akcii_inner', 1, 1)%
					
					
				</div>
			</div>
			<div id="footer">
				&copy; ООО "Юмисофт", 2010
			</div>
		</div>
	</body>
</html>
