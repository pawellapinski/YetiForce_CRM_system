<?php
/* Smarty version 4.2.0, created on 2025-03-23 11:22:57
  from 'C:\xampp7.4\htdocs\crm\layouts\basic\modules\Vtiger\PageFooter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.0',
  'unifunc' => 'content_67dfe10150c2c0_00104897',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '09f0aaf3426312821d6c1608195a33cc2ce7c133' => 
    array (
      0 => 'C:\\xampp7.4\\htdocs\\crm\\layouts\\basic\\modules\\Vtiger\\PageFooter.tpl',
      1 => 1660909119,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67dfe10150c2c0_00104897 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- tpl-Base-PageFooter --></div><input type="hidden" id="processEvents" value="<?php echo \App\Purifier::encodeHtml(\App\Json::encode(App\Process::getEvents()));?>
" /><?php if ($_smarty_tpl->tpl_vars['SHOW_FOOTER']->value) {
$_smarty_tpl->_subTemplateRender(\App\Layout::getTemplatePath('Footer.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
$_smarty_tpl->_subTemplateRender(\App\Layout::getTemplatePath('JSResources.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
if (\App\Debuger::isDebugBar()) {
echo \App\Debuger::getDebugBar()->getJavascriptRenderer()->render();
}?></body></html><!-- /tpl-Base-PageFooter -->
<?php }
}
