<?php
 chdir(dirname(__FILE__));include "../../../developerTools/jsPacker/class.JavaScriptPacker.php";include "../../../developerTools/jsPacker/jsPacker.php";$v0f635d0e0f3874fff8b581c132e6c7a7 = @simplexml_load_file('compress.xml');if (!$v0f635d0e0f3874fff8b581c132e6c7a7) {die('// No valid source for packer');}foreach($v0f635d0e0f3874fff8b581c132e6c7a7->packages->pack as $vb484857901742afc9e9d4e9853596ce2) {$vaf32569495f70c7eb1a132641537702b = (string) $vb484857901742afc9e9d4e9853596ce2['path'];$v9399c0edc22233012fb21e19c7c803d0 = array();foreach($vb484857901742afc9e9d4e9853596ce2->file as $v8c7dd922ad47494fc02c388e12c00eac) {$v9399c0edc22233012fb21e19c7c803d0[] = (string) $v8c7dd922ad47494fc02c388e12c00eac['path'];}if ( count($v9399c0edc22233012fb21e19c7c803d0) > 0 ) {$v0b0f137f17ac10944716020b018f8126 = new jsPacker($v9399c0edc22233012fb21e19c7c803d0);$v0b0f137f17ac10944716020b018f8126->pack($vaf32569495f70c7eb1a132641537702b);}}?>