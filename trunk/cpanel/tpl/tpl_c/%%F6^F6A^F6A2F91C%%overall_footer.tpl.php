<?php /* Smarty version 2.6.12, created on 2009-05-31 23:44:41
         compiled from overall_footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', '__i18n', 'overall_footer.tpl', 4, false),)), $this); ?>
</td>
</tr>
</table>
<center><a class="a_copyright"><?php $this->_tag_stack[] = array('__i18n', array('type' => 'text')); $_block_repeat=true;smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Правовая информация 2005 - <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  echo date("Y"); ?> Tony-M Studio. <?php $this->_tag_stack[] = array('__i18n', array('type' => 'text')); $_block_repeat=true;smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Все права защищены. Night Stalker v3 свободно распространяемое программное обеспечение по GNU/GPL лицензии.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block___i18n($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></a></center>

</body>

</html>