<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        close window
    </title>
</head>
<body>
<script>
    window.close();
    alert('aaaaa');
    window.top.close();
</script>
</body>
</html>