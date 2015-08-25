			<h1 class="hdr"><span>Demo site UMI.CMS</span></h1>
			<div id="quick-links">
				<a href="/en/" id="home" title="Главная"><span>Main page</span></a>
				<a href="/en/content/sitemap/" id="sitetree"  title="Дерево сайта"><span>Site map</span></a>
				<a href="/en/contacts/" id="mailto"  title="Написать письмо"><span>E-mail</span></a>
			</div>

			<div id="banner468x60">
				%banners insert('top_banner')%
			</div>

			<div id="header">
				<div id="langs">
					<a href="/">rus</a> <a class="active">eng</a>
				</div>

				%users auth('en_header')%

				<div class="banner">
					%banners insert('text_banner_eng')%
				</div>
			</div>
			%menu%
