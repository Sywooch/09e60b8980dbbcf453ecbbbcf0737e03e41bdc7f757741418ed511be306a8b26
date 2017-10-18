<?php 
//phpinfo();
?>
<form enctype="multipart/form-data" action="http://api.ramenskoye.100081.ooogoroda.mobi/Img.get" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="my_file" multiple type="file" />
    <input type="submit" value="Send File" />
</form>