%system getOuterContent('./%template_resources%/tpls/content/header.inc.tpl')%
<section id="content">
	<aside>
		%content get_site_menu('sl',30)%
 
	</aside>
	<section id="main">
		<a class="pathway" href="/">На главную</a>
		 
        

		<ul class="news">
		%content articles_list()%	

			
		</ul>

	
	</section>
</section>
%system getOuterContent('./%template_resources%/tpls/content/footer.inc.tpl')%