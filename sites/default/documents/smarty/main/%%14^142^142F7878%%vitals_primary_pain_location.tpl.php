<?php /* Smarty version 2.6.33, created on 2022-04-22 06:37:04
         compiled from vitals_primary_pain_location.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'xlt', 'vitals_primary_pain_location.tpl', 1, false),)), $this); ?>
<tr><td><?php echo smarty_function_xlt(array('t' => 'Primary Pain Location'), $this);?>
<td></td>
    <td class='currentvalues p-2'><select name="primary_pain_location" class="form-control" id='primary_pain_location'><option value=""> </option>
            <option value="Joint Pain"              <?php if ($this->_tpl_vars['vitals']->get_primary_pain_location() == 'Joint Pain' || $this->_tpl_vars['vitals']->get_primary_pain_location() == 2): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Joint Pain'), $this);?>

            <option value="Chest Pain" <?php if ($this->_tpl_vars['vitals']->get_primary_pain_location() == 'Chest Pain' || $this->_tpl_vars['vitals']->get_primary_pain_location() == 1): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Chest Pain'), $this);?>

            <option value="Back Pain"            <?php if ($this->_tpl_vars['vitals']->get_primary_pain_location() == 'Back Pain' || $this->_tpl_vars['vitals']->get_primary_pain_location() == 3): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Back Pain'), $this);?>

            <option value="Body Pain"          <?php if ($this->_tpl_vars['vitals']->get_primary_pain_location() == 'Body Pain' || $this->_tpl_vars['vitals']->get_primary_pain_location() == 4): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Body Pain'), $this);?>

            <option value="Nerve Damage"   <?php if ($this->_tpl_vars['vitals']->get_primary_pain_location() == 'Nerve Damage'): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Nerve Damage'), $this);?>

        </select></td>
    <td class="editonly"></td>


    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'vitals_historical_values.tpl', 'smarty_include_vars' => array('useMetric' => false,'vitalsValue' => 'get_primary_pain_location','results' => $this->_tpl_vars['results'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
