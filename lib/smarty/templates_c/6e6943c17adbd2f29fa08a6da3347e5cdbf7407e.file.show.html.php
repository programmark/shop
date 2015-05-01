<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-03-28 15:49:35
         compiled from "D:\phpworkspace\2015\shop\view\show.html" */ ?>
<?php /*%%SmartyHeaderCode:1273455165d0f56dbb5-17496099%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e6943c17adbd2f29fa08a6da3347e5cdbf7407e' => 
    array (
      0 => 'D:\\phpworkspace\\2015\\shop\\view\\show.html',
      1 => 1427519412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1273455165d0f56dbb5-17496099',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55165d0f5eea56_37882100',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55165d0f5eea56_37882100')) {function content_55165d0f5eea56_37882100($_smarty_tpl) {?><html>
    <head>
        <title>Test jquery</title>
        <link type="text/css" rel="stylesheet" href="/public/css/base.css" />
        <?php echo '<script'; ?>
 type="text/javascript" src="/public/js/base.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="/public/js/jquery-2.1.3.min.js"><?php echo '</script'; ?>
>
    </head>
    <body>
        <div style="">
            <div id="sp">
                spring is coming. 
            </div>
            <input type="button" onclick="show()" value="提交"/>
        </div>
    </body>
</html>
<?php echo '<script'; ?>
 lang="javascript">
    function show() {
        var sp = $("#sp");
        if (sp.isPrototypeOf("hide")) {
            sp.show();
        } else {
            sp.hide();
        }
    }
<?php echo '</script'; ?>
>

<?php }} ?>
