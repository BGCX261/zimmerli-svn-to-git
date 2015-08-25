%system getOuterContent('./%template_resources%/tpls/content/header.inc.tpl')%

<section id="content">
	<aside>
		%content get_site_menu('sl',30)%
		%catalog getGuideList(125)%
        
	</aside>
	<section id="main">
		<a class="pathway" href="/">На главную</a>
		<div class="disp">
			Отображать: <a class="active" href="#">12</a> <a href="#">24</a> <a href="#">Все</a>
		</div>
		%content%

        
	</section>
</section>

<?php /*
<div id="container">

	<div id="content">
		<div id="left" class="column">
			%content menu('sl',2,'/collections/')%

			<!--					%emarket currencySelector()%
								%emarket cart('basket')%
								%emarket getCompareList('compare_list')% -->
		</div>
		<div id="center" class="column">
			%core navibar('default', 1, 0, 1)%

			<h2 umi:element-id="%pid%" umi:field-name="h1">%header%</h2>
			<div umi:element-id="%pid%" umi:field-name="content">
				%content%
			</div>
		</div>
		<div id="right" class="column">
			<!--					%search insert_form('home')%
								%catalog getCategoryList('inner', '/collections/', '0', '1', -1)%
								%news lastlist('/akcii', 'akcii_inner', 1, 1)%-->


		</div>
	</div>
	<div id="footer">
		&copy; ООО "Юмисофт", 2010
	</div>
</div>
*/?>

%system getOuterContent('./%template_resources%/tpls/content/footer.inc.tpl')%