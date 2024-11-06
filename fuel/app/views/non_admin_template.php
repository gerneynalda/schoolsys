<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo Asset::css("bootstrap.css"); ?>
    <?php if(isset($css) && (count($css) > 0) ):?>
        
        <!-- Array of css -->
        <?php foreach($css as $style): ?>
        <?php echo Asset::css($style); ?>
        <?php endforeach;?>

    <?php endif; ?>

    <title>None Admin</title>
</head>
<body>
    <?php echo isset($content) ? $content : "" ?>
    <?php echo Asset::js('jquery-v.3.7.1.min.js');?>
    <?php echo Asset::js('bootstrap.js');?>
</body>
</html>