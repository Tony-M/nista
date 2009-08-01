<?php /* Smarty version 2.6.12, created on 2009-08-01 22:14:08
         compiled from ../mod/item_manager/tpl/page_list.tpl */ ?>
<table cellpadding="5" cellspacing="2" bgcolor="#ffffff" >
<tr>
<td></td>
<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['first'] <> ""): ?><td><a href="" onclick="get_item_list_by_page(<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['first']; ?>
);return false;"> В начало </a></td><?php endif;  if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['show_left_dots'] == '1'): ?><td><a>...</a></td><?php endif;  if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['previous'] != ""): ?><td><a href="" onclick="get_item_list_by_page(<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['previous']; ?>
);return false;">Предыдущая </a></td><?php endif; ?>

<?php unset($this->_sections['pg_list_num']);
$this->_sections['pg_list_num']['name'] = 'pg_list_num';
$this->_sections['pg_list_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['pg_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['pg_list_num']['show'] = true;
$this->_sections['pg_list_num']['max'] = $this->_sections['pg_list_num']['loop'];
$this->_sections['pg_list_num']['step'] = 1;
$this->_sections['pg_list_num']['start'] = $this->_sections['pg_list_num']['step'] > 0 ? 0 : $this->_sections['pg_list_num']['loop']-1;
if ($this->_sections['pg_list_num']['show']) {
    $this->_sections['pg_list_num']['total'] = $this->_sections['pg_list_num']['loop'];
    if ($this->_sections['pg_list_num']['total'] == 0)
        $this->_sections['pg_list_num']['show'] = false;
} else
    $this->_sections['pg_list_num']['total'] = 0;
if ($this->_sections['pg_list_num']['show']):

            for ($this->_sections['pg_list_num']['index'] = $this->_sections['pg_list_num']['start'], $this->_sections['pg_list_num']['iteration'] = 1;
                 $this->_sections['pg_list_num']['iteration'] <= $this->_sections['pg_list_num']['total'];
                 $this->_sections['pg_list_num']['index'] += $this->_sections['pg_list_num']['step'], $this->_sections['pg_list_num']['iteration']++):
$this->_sections['pg_list_num']['rownum'] = $this->_sections['pg_list_num']['iteration'];
$this->_sections['pg_list_num']['index_prev'] = $this->_sections['pg_list_num']['index'] - $this->_sections['pg_list_num']['step'];
$this->_sections['pg_list_num']['index_next'] = $this->_sections['pg_list_num']['index'] + $this->_sections['pg_list_num']['step'];
$this->_sections['pg_list_num']['first']      = ($this->_sections['pg_list_num']['iteration'] == 1);
$this->_sections['pg_list_num']['last']       = ($this->_sections['pg_list_num']['iteration'] == $this->_sections['pg_list_num']['total']);
?>
<td><?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['pg_list'][$this->_sections['pg_list_num']['index']] == $this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['current_pg']): ?><b><?php endif; ?><a href="" onclick="get_item_list_by_page(<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['pg_list'][$this->_sections['pg_list_num']['index']]; ?>
);return false;"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['pg_list'][$this->_sections['pg_list_num']['index']]; ?>
</a><?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['pg_list'][$this->_sections['pg_list_num']['index']] == $this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['current_pg']): ?></b><?php endif; ?></td>
<?php endfor; endif; ?>

<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['next'] != ""): ?><td><a href="" onclick="get_item_list_by_page(<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['next']; ?>
);return false;">Следующая </a></td><?php endif;  if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['show_right_dots'] == '1'): ?><td><a>...</a></td><?php endif;  if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['last'] != ""): ?><td><a href="" onclick="get_item_list_by_page(<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_page_list']['last']; ?>
); return false;">В конец </a></td><?php endif; ?>
</tr>
</table>