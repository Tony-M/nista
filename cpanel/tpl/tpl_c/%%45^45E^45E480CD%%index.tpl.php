<?php /* Smarty version 2.6.12, created on 2009-08-01 22:11:12
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', '__i18n', 'index.tpl', 3, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "overall_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  if ($this->_tpl_vars['MOD_TEMPLATE'] == ""): ?>
	<h1><?php $this->_tag_stack[] = array('__i18n', array('type' => 'header')); $_block_repeat=true;smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Добро пожаловать в Night Stalker.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h1>	
	<hr>
	<p><?php $this->_tag_stack[] = array('__i18n', array('type' => 'text')); $_block_repeat=true;smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Благодарим вас за то, что сделали свой выбор в сторону использования системы Night Stalker в качестве CMS. На данной странице представлен краткий обзор и статистика по системе и её компонентам. Вы всегда можете вернуться на данную страницу нажав на изображение домика. Остальные элементы страницы позволят вам управлять всеми компонентами системы. Каждая страница будет снабжена всеми необходимыми инструкциями.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></p>
	<h1><?php $this->_tag_stack[] = array('__i18n', array('type' => 'header')); $_block_repeat=true;smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Текущая версия<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> (<?php echo $this->_tpl_vars['DOCUMENT']['kernel_version']['version']; ?>
.<?php echo $this->_tpl_vars['DOCUMENT']['kernel_version']['version_type']; ?>
)</h1>
	<p><?php $this->_tag_stack[] = array('__i18n', array('type' => 'text')); $_block_repeat=true;smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Ваша версия продукта не требует обновления<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></p>
<?php else: ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['MOD_TEMPLATE']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif;  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "overall_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>