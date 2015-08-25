<?php
$FORMS = array();
/*
content tagsAccountCloud
content tagsDomainCloud
content tagsAccountUsageCloud
content tagsDomainUsageCloud
content tagsAccountEfficiencyCloud
content tagsDomainEfficiencyCloud
*/

$FORMS['cloud_tags'] = "%items%";
$FORMS['cloud_tags_empty'] = "";

$FORMS['cloud_tag'] = "<a href=\"/content/pagesBy%context%Tags/%tag_urlencoded%\" style=\"font-size:%font%pt;\">%tag%</a>";

$FORMS['cloud_tagseparator'] = ", ";

/*
content pagesByAccountTags
content pagesByDomainTags
*/
$FORMS['pages'] = "<ul>%items%</ul><p>%system numpages(%total%, %per_page%)%</p>";
$FORMS['pages_empty'] = "";
$FORMS['page'] = "<li><a href=\"%link%\">%name%</a></li>";

?>