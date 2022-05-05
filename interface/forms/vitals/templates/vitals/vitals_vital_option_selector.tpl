<select name="vital_option[{$input|attr}]" class="form-control" id='vital_option_{$input|attr}'>
    <option value=""> </option>
    {foreach item=option from=$vital_options}
        {if isset($vitalDetails) && $option.id == $vitalDetails->get_interpretation_option_id()}
            <option selected="selected" value="{$option.id|attr}">{$option.title|xlt}</option>
        {else}
        <option {if $option.is_default}selected="selected"{/if}value="{$option.id|attr}">{$option.title|xlt}</option>
        {/if}
    {/foreach}
</select>
