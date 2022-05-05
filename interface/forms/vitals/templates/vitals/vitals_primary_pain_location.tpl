<tr><td>{xlt t="Primary Pain Location"}<td></td>
    <td class='currentvalues p-2'><select name="primary_pain_location" class="form-control" id='primary_pain_location'><option value=""> </option>
            <option value="Joint Pain"              {if $vitals->get_primary_pain_location() == "Joint Pain"              || $vitals->get_primary_pain_location() == 2 } selected{/if}>{xlt t="Joint Pain"}
            <option value="Chest Pain" {if $vitals->get_primary_pain_location() == "Chest Pain" || $vitals->get_primary_pain_location() == 1 } selected{/if}>{xlt t="Chest Pain"}
            <option value="Back Pain"            {if $vitals->get_primary_pain_location() == "Back Pain"            || $vitals->get_primary_pain_location() == 3 } selected{/if}>{xlt t="Back Pain"}
            <option value="Body Pain"          {if $vitals->get_primary_pain_location() == "Body Pain"          || $vitals->get_primary_pain_location() == 4 } selected{/if}>{xlt t="Body Pain"}
            <option value="Nerve Damage"   {if $vitals->get_primary_pain_location() == "Nerve Damage" } selected{/if}>{xlt t="Nerve Damage"}
        </select></td>
    <td class="editonly"></td>


    { include file='vitals_historical_values.tpl' useMetric=false vitalsValue="get_primary_pain_location" results=$results }

