<h1>Создание/редактирование пункта меню</h1>

{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<p>Выберите необходимое действие:</p>
<a href="{$DOCUMENT.mod.data.http_referer}">Вернуться на страницу источник пункта (сторонний аздел)</a>
<a href="index.php?p=menu&sp=ls_menu">Перейти к списку меню</a>
