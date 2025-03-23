<?php
/* Smarty version 4.2.0, created on 2025-03-23 11:26:55
  from 'C:\xampp7.4\htdocs\crm\layouts\basic\modules\Vtiger\Detail\Field\Base.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_67dfe1ef318440_05344771',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd8f2e832cf60e4166d2ddcde2f59d1c622ac6a40' => 
    array (
      0 => 'C:\\xampp7.4\\htdocs\\crm\\layouts\\basic\\modules\\Vtiger\\Detail\\Field\\Base.tpl',
      1 => 1660909119,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67dfe1ef318440_05344771 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="tpl-Detail-Field-Base u-paragraph-m-0 u-word-break">
<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'),$_smarty_tpl->tpl_vars['RECORD']->value->getId(),$_smarty_tpl->tpl_vars['RECORD']->value);?>

</div>
<?php }
}
