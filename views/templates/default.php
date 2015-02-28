<!doctype html>
<html>
	<head>
		<?php echo $document->getHeaders(); ?>
	</head>
	<body>
		<?php echo $document->getPrependedElements(); ?>
		
		<?php echo $pageContent; ?>
		
		<?php echo $document->getAppendedElements(); ?>
	</body>
</html>