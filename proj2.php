<?php

$request = ms_newowsrequestobj();

foreach ($_GET as $k=>$v) {
     $request->setParameter($k, $v);
}

ms_ioinstallstdouttobuffer();
$oMap = ms_newMapobj("/home/sing20/public_html/term_project/proj2.map");

$new_layer =ms_newlayerobj($oMap);
$new_layer->set("type", MS_LAYER_POLYGON);
$new_layer->set("dump", 1);
$new_layer->set("status", 1);
$new_layer->set("name","nypp");
$new_layer->set("template","infotemplate.html");
$new_layer->setMetaData("wms_name","nypp");
$new_layer->setMetaData("gml_include_items","all");
$new_layer->setMetaData("gml_featureid","precinct");
$new_layer->setMetaData("wms_feature_info_mime_type","text/html");
$new_class = ms_newClassObj($new_layer);
$new_style = ms_newStyleObj($new_class);
$new_style-> outlinecolor->setRGB(255, 0, 0);

$new_layer->setConnectionType(MS_POSTGIS);
$new_layer->set("connection","user=username password=password dbname=d408 host=192.168.88.30");
$data="geom from (select gid, geom, county, name, (SELECT cases FROM covid cov WHERE cov.county = name and cov.state = 'New York' and case_date='2020-04-15') as cases, (SELECT deaths FROM covid cov WHERE cov.county = name and cov.state = 'New York' and case_date='2020-04-15') as deaths from county) as foo using unique gid using SRID=2263";
$new_layer->set("data",$data) ;

$oMap->owsdispatch($request);
$contenttype = ms_iostripstdoutbuffercontenttype();
if ($contenttype == 'image/png')
{
   header('Content-type: image/png');
   ms_iogetStdoutBufferBytes();
}
else
{
	$buffer = ms_iogetstdoutbufferstring();
	echo $buffer;
}
ms_ioresethandlers();
?>
