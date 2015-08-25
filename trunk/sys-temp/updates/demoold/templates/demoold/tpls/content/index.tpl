<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="/templates/demoold/css/style.css?%system_build%"/>
		<link type="text/css" rel="stylesheet" href="/templates/demoold/css/home.css?%system_build%"/>
		<script type="text/javascript">
			if (navigator.appName == "Opera") document.write('<link rel="stylesheet" type="text/css" href="/templates/demoold/css/styleOpera.css"/>');
		</script>
		<title>%title%</title>

		<meta name="DESCRIPTION" content="%description%" />
		<meta name="KEYWORDS" content="%keywords%" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<script type="text/javascript" src="/js/cross-domain.php?%system_build%"></script>
		<script type="text/javascript" src="/js/client/vote.js?%system_build%" charset="utf-8"></script>

		%system includeQuickEditJs()%
        %system includeEditInPlaceJs()%


        %data getRssMeta(%pid%)%
        %data getAtomMeta(%pid%)%
	</head>
	
	<body id="umi-cms-demo">
		<div id="container">
			%system getOuterContent('./%template_resources%/tpls/content/header.inc.tpl')%
			<div id="content">
				<div class="column">

					<div id="welcome" class="block">
						<h2 umi:element-id="%pid%" umi:field-name="h1">%header%</h2>
						<div umi:element-id="%pid%" umi:field-name="content">
						%content%
						</div>
					</div>
                    
					<div id="welcome" class="block">
					Для регистрации нажмите 
						<a href="/users/registrate/"> здесь</a>
					</div>
					
					%vote insertlast('home')%

					<div>
					
						
						%blogs20 blogsList(2,0,0,'shortlist')%
					</div>
				</div>

				%news lastlist('/vse_novosti/politicheskie_novosti/ /vse_novosti/novosti_ekonomiki/', 'home', 2)%


				<div class="column">
					%search insert_form('home')%

					%forum confs_list('home')%
					%emarket cart('basket')%
					<!--%news lastlist('/akcii', 'akcii', 1, 1)%-->
					<div>
						<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FUMI.CMS&amp;width=290&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;height=185" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:290px; height: 185px; margin: 10px 0 0;" allowTransparency="true"></iframe>
				</div>
				</div>

				%catalog category('home', '/market/')%



				%faq projects('home', '/faq/')%

				%photoalbum album('/fotogalereya/', 'home', 4)%


			</div>
			%system getOuterContent('./%template_resources%/tpls/content/footer.inc.tpl')%
		</div>
	</body>
</html>