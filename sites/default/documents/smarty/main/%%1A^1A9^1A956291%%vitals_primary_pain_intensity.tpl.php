<?php /* Smarty version 2.6.33, created on 2022-04-21 07:42:12
         compiled from vitals_primary_pain_intensity.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'xlt', 'vitals_primary_pain_intensity.tpl', 1, false),)), $this); ?>
<tr><td><?php echo smarty_function_xlt(array('t' => 'Primary Pain Intensity'), $this);?>
<td></td>
    <td class='currentvalues p-2'><select name="primary_pain_intensity" class="form-control" id='primary_pain_intensity'><option value=""> </option>
            <option value="Severe discomfort"              <?php if ($this->_tpl_vars['vitals']->get_primary_pain_intensity() == 'Severe discomfort' || $this->_tpl_vars['vitals']->get_primary_pain_intensity() == 2): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Severe discomfort'), $this);?>

            <option value="Moderate pain" <?php if ($this->_tpl_vars['vitals']->get_primary_pain_intensity() == 'Moderate pain' || $this->_tpl_vars['vitals']->get_primary_pain_intensity() == 1): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Moderate pain'), $this);?>

            <option value="Discomfort"            <?php if ($this->_tpl_vars['vitals']->get_primary_pain_intensity() == 'Discomfort' || $this->_tpl_vars['vitals']->get_primary_pain_intensity() == 3): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Discomfort'), $this);?>

            <option value=" Mild discomfort"          <?php if ($this->_tpl_vars['vitals']->get_primary_pain_intensity() == ' Mild discomfort' || $this->_tpl_vars['vitals']->get_primary_pain_intensity() == 4): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => ' Mild discomfort'), $this);?>

            <option value="Comfortable"   <?php if ($this->_tpl_vars['vitals']->get_primary_pain_intensity() == 'Comfortable'): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Comfortable'), $this);?>

        </select></td>
    <td class="editonly"></td>


    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'vitals_historical_values.tpl', 'smarty_include_vars' => array('useMetric' => false,'vitalsValue' => 'get_primary_pain_intensity','results' => $this->_tpl_vars['results'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


