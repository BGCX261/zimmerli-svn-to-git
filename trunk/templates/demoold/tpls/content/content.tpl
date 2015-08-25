%system getOuterContent('./%template_resources%/tpls/content/header.inc.tpl')%

<section id="content">
	<aside>
      %content get_site_menu('sl',%pid%)%
      
 
	</aside>
	<section id="main">
		<a class="pathway" href="/">На главную</a>
		
		<article>
			<h1 umi:element-id="%pid%" umi:field-name="h1">%header%</h1>
           
					%system listErrorMessages()%
					%core insertCut()%
					
					%content%
					
			
			
		</article>

	
	</section>
</section>
<?php /*
		<!--<div id="container">
			
			<div id="content">
				<div id="left" class="column">
					%content menu('sl')%

					%news lastlist('/akcii', 'akcii_inner', 1, 1)%
				</div>
				<div id="center" class="column">
					%core navibar('default', 1, 0, 1)%
					<h2 umi:element-id="%pid%" umi:field-name="h1">%header%</h2>
					%system listErrorMessages()%
					%core insertCut()%
					<div umi:element-id="%pid%" umi:field-name="content">
						%content%
					</div>
				</div>
				<div id="right" class="column">
					%search insert_form('home')%
					%catalog getCategoryList('inner', '/market/', '0', '1')%
					
					%emarket currencySelector()%
					%emarket cart('basket')%
					%emarket getCompareList('compare_list')%
				</div>
			</div>
			<div id="footer">
				&copy; ООО "Юмисофт", 2010
			</div>
		</div>-->*/?>
        
%system getOuterContent('./%template_resources%/tpls/content/footer.inc.tpl')%