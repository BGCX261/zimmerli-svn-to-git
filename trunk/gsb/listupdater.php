<?php
require("phpgsb.class.php");$v4d90362d661461e558408e982aaa49d3 = parse_ini_file('../config.ini');$vce8f9d0355f82957d1e56e105c370da8 = new phpGSB($v4d90362d661461e558408e982aaa49d3['core.dbname'],$v4d90362d661461e558408e982aaa49d3['core.login'],$v4d90362d661461e558408e982aaa49d3['core.password'],$v4d90362d661461e558408e982aaa49d3['core.host']);$vce8f9d0355f82957d1e56e105c370da8->apikey = $v4d90362d661461e558408e982aaa49d3['gsb-apikey'];$vce8f9d0355f82957d1e56e105c370da8->usinglists = array('googpub-phish-shavar','goog-malware-shavar');$vce8f9d0355f82957d1e56e105c370da8->runUpdate();$vce8f9d0355f82957d1e56e105c370da8->close();?>
