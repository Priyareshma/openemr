{if isset($hide) && $hide }
<tr class="hide">
{else}
<tr>
{/if}
    <td class="graph" id="{$input|attr}">{$title|xlt}</td>
    <td>{xlt t=$unit|xlt}</td>
    <td class="editonly">
      { include file='vitals_interpretation_selector.tpl' vitalDetails=$vitals->get_details_for_column($input) }
    </td>

    { include file='vitals_historical_values.tpl' useMetric=false vitalsValue=$vitalsValue results=$results
        vitalsStringFormat=$vitalsStringFormat }
</tr>
