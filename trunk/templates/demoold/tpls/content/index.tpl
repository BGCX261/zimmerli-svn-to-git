
%system getOuterContent('./%template_resources%/tpls/content/header.inc.tpl')%  
<section id="slide">
    	
    <ul id="slider">
      %content slider()%
        
    </ul>
	%content get_site_menu('sl',30)%
    <!--<nav id="catalog">
		<div class="cat">
			<ul id="for-him">
				<li><a href="#">Для мужчин</a>
					<ul>
						<li><a href="#">Плавки</a></li>
						<li><a href="#">Боксеры</a></li>
						<li><a href="#">Майки</a></li>
						<li><a href="#">Футболки</a></li>
					</ul>
				</li>
			</ul>
			<ul id="for-her">
				<li><a href="#">Для женщин</a>
					<ul>
						<li><a href="#">Плавки</a></li>
						<li><a href="#">Боксеры</a></li>
						<li><a href="#">Майки</a></li>
						<li><a href="#">Футболки</a></li>
					</ul>
				</li>
			</ul>
		</div>


    </nav>-->
</section>
<section id="new">
    <div class="title">
		<!--<a href="/catalog1/?fields_filter[new_item]=1" title="новинки">-->новинки<!--</a>-->
    </div>
    %content novelty_list()% 
</section>
%system getOuterContent('./%template_resources%/tpls/content/footer.inc.tpl')%


<!--
  
		<link type="text/css" rel="stylesheet" href="/templates/demoold/css/style.css?%system_build%"/>
		<link type="text/css" rel="stylesheet" href="/templates/demoold/css/home.css?%system_build%"/>
		<script type="text/javascript">
			if (navigator.appName == "Opera") document.write('<link rel="stylesheet" type="text/css" href="/templates/demoold/css/styleOpera.css"/>');
		</script>

		<script type="text/javascript" src="/js/cross-domain.php?%system_build%"></script>
		<script type="text/javascript" src="/js/client/vote.js?%system_build%" charset="utf-8"></script>

		%system includeQuickEditJs()%
        %system includeEditInPlaceJs()%


        %data getRssMeta(%pid%)%
        %data getAtomMeta(%pid%)%
	</head>
	
	<body id="umi-cms-demo">
		<div id="container">
			
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
					%news lastlist('/akcii', 'akcii', 1, 1)%
					<div>
						<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FUMI.CMS&amp;width=290&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;height=185" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:290px; height: 185px; margin: 10px 0 0;" allowTransparency="true"></iframe>
				</div>
				</div>

				%catalog category('home', '/market/')%



				%faq projects('home', '/faq/')%

				%photoalbum album('/fotogalereya/', 'home', 4)%


			</div>
			
		</div>
	</body>
</html>
-->