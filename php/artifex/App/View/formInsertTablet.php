<?php
$appConfig= require dirname(__DIR__, 2) . DIRECTORY_SEPARATOR. 'appConfig.php';
$baseUrl = $appConfig['baseURL'].$appConfig['prjName'];
$tabletAttributes = require dirname(__DIR__, 1) . DIRECTORY_SEPARATOR.'Attributes'.DIRECTORY_SEPARATOR.'tabletAttributes.php';
$title='Insert tablet';
require 'header.php';

?>
<div class="content">
    <h2>Inserisci nuovo tablet</h2>
    <form action="<?=$baseUrl?>insert/onetablet" method="post">
        <?php
        foreach ($tabletAttributes as $attribute => $attributeValues) { ?>
            <label for="<?=$attribute?>"> <?=$attributeValues['label']?></label> <br>
            <input type="<?=$attributeValues['type']?>" name="<?=$attribute?>" id="<?=$attribute?>" required>
            <br><br>
        <?php  }  ?>
        <input type="submit" value="invia">
</div>
<?php
require 'footer.php';
?>
