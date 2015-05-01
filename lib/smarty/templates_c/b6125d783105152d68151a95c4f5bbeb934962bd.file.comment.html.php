<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-03-31 23:56:27
         compiled from "D:\phpworkspace\2015\shop\view\hall\comment.html" */ ?>
<?php /*%%SmartyHeaderCode:501755165d0f33f1b6-64397912%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6125d783105152d68151a95c4f5bbeb934962bd' => 
    array (
      0 => 'D:\\phpworkspace\\2015\\shop\\view\\hall\\comment.html',
      1 => 1427817385,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '501755165d0f33f1b6-64397912',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55165d0f3cfa54_23150820',
  'variables' => 
  array (
    'items' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55165d0f3cfa54_23150820')) {function content_55165d0f3cfa54_23150820($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
    <head>
        <title>ajax comment</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="/public/css/base.css" />
        <?php echo '<script'; ?>
 type="text/javascript" src="/public/js/jquery-2.1.3.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="/public/js/comment.js"><?php echo '</script'; ?>
>
    </head>
    <body>
        <div class="com">
            <div>
                <div id="comm"></div>
                <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['myId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['myId']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                <div ><?php echo $_smarty_tpl->tpl_vars['i']->value['ip'];?>
在<?php echo $_smarty_tpl->tpl_vars['i']->value['time'];?>
说了<?php echo $_smarty_tpl->tpl_vars['i']->value['comment'];?>
&nbsp;&nbsp;&nbsp; <input comment_id="" type="button" onclick="deleted(<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
)" value="刪除"/></div>
                <?php } ?>
            </div>
            <input id ="comment" type="text" value=""/>
            <input type="button" onclick="comment()" value="提交"/>
        </div>
    </body>
</html>

<?php }} ?>
