{include file="overall_header.tpl"}
{if $MOD_TEMPLATE == ""}
	<h1>{__i18n type="header"}Добро пожаловать в Night Stalker.{/__i18n}</h1>	
	<hr>
	<p>{__i18n type="text"}Благодарим вас за то, что сделали свой выбор в сторону использования системы Night Stalker в качестве CMS. На данной странице представлен краткий обзор и статистика по системе и её компонентам. Вы всегда можете вернуться на данную страницу нажав на изображение домика. Остальные элементы страницы позволят вам управлять всеми компонентами системы. Каждая страница будет снабжена всеми необходимыми инструкциями.{/__i18n}</p>
	<h1>{__i18n type="header"}Текущая версия{/__i18n} ({$DOCUMENT.kernel_version.version}.{$DOCUMENT.kernel_version.version_type})</h1>
	<p>{__i18n type="text"}Ваша версия продукта не требует обновления{/__i18n}</p>
{else}
	{include file="$MOD_TEMPLATE"}
{/if}
{include file="overall_footer.tpl"}
