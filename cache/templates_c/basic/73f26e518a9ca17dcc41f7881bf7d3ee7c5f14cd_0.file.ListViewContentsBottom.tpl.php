<?php
/* Smarty version 4.2.0, created on 2025-03-23 11:22:57
  from 'C:\xampp7.4\htdocs\crm\layouts\basic\modules\Vtiger\ListViewContentsBottom.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_67dfe101368b32_30111976',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '73f26e518a9ca17dcc41f7881bf7d3ee7c5f14cd' => 
    array (
      0 => 'C:\\xampp7.4\\htdocs\\crm\\layouts\\basic\\modules\\Vtiger\\ListViewContentsBottom.tpl',
      1 => 1660909119,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67dfe101368b32_30111976 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- tpl-Base-ListViewContentsBottom --><?php if ($_smarty_tpl->tpl_vars['LISTVIEW_ENTRIES_COUNT']->value == '0') {?><table class="emptyRecordsDiv"><tbody><tr><td><?php echo \App\Language::translate('LBL_RECORDS_NO_FOUND');?>
. <?php if ($_smarty_tpl->tpl_vars['IS_MODULE_EDITABLE']->value) {?><a href="<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getCreateRecordUrl();?>
"><?php echo \App\Language::translate('LBL_CREATE_SINGLE_RECORD');?>
</a><?php }?></td></tr></tbody></table><?php }?><!-- /tpl-Base-ListViewContentsBottom -->
<?php }
}
