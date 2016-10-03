<!DOCTYPE html>
<html ng-app="app"><head><title>Marmiton</title><base href="/" /><?= stylesheet_tag( 'vendor.css' ) ?><?= stylesheet_tag( 'vendor2.css' ) ?><?= stylesheet_tag( 'app.css' )    ?></head><body ng-controller="appCtrl"><div id="page"></div><div id="header"><div class="navbar navbar-default navbar-fixed-top"><div class="container"><div class="navbar-header"><a href="/#/" class="navbar-brand">Marmiton</a></div></div></div></div><div class="wrapper" id="page_block"><?php if ( $notice = $this->getNotice() ): ?><div class="alert alert-&lt;?= $notice[0] ?&gt;"><?= $notice[1] ?></div><?php endif ?><div class="container"><div ui-view></div></div></div></body>
<script type="text/javascript">
//<![CDATA[
var $units = <?= json_encode( getUnitTypes() ) ?>;


//]]>
</script>
<?= javascript_tag( 'vendor.js' )            ?><ng-include src="'templates.html'"></ng-include><?= javascript_tag( 'app.js' )               ?></html>