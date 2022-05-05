<?php /* Smarty version 2.6.33, created on 2022-04-19 08:00:10
         compiled from vitals_intensity.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'xlt', 'vitals_intensity.tpl', 1, false),)), $this); ?>
<tr><td><?php echo smarty_function_xlt(array('t' => 'Pain Intensity'), $this);?>
<td></td>
    <td class='currentvalues p-2'><select name="primary_pain_intensity" class="form-control" id='primary_pain_intensity'><option value=""> </option>
    <option value="Axillary"          <?php if ($this->_tpl_vars['vitals']->get_temp_method() == 'Axillary' || $this->_tpl_vars['vitals']->get_temp_method() == 4): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Axillary'), $this);?>

            <option value="Temporal Artery"   <?php if ($this->_tpl_vars['vitals']->get_temp_method() == 'Temporal Artery'): ?> selected<?php endif; ?>><?php echo smarty_function_xlt(array('t' => 'Temporal Artery'), $this);?>

        </select></td>
    <td class="editonly"></td>