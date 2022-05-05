<tr><td>{xlt t="Primary Pain Intensity"}<td></td>
    <td class='currentvalues p-2'><select name="primary_pain_intensity" class="form-control" id='primary_pain_intensity'><option value=""> </option>
            <option value="Severe discomfort"              {if $vitals->get_primary_pain_intensity() == "Severe discomfort"              || $vitals->get_primary_pain_intensity() == 2 } selected{/if}>{xlt t="Severe discomfort"}
            <option value="Moderate pain" {if $vitals->get_primary_pain_intensity() == "Moderate pain" || $vitals->get_primary_pain_intensity() == 1 } selected{/if}>{xlt t="Moderate pain"}
            <option value="Discomfort"            {if $vitals->get_primary_pain_intensity() == "Discomfort"            || $vitals->get_primary_pain_intensity() == 3 } selected{/if}>{xlt t="Discomfort"}
            <option value=" Mild discomfort"          {if $vitals->get_primary_pain_intensity() == " Mild discomfort"          || $vitals->get_primary_pain_intensity() == 4 } selected{/if}>{xlt t=" Mild discomfort"}
            <option value="Comfortable"   {if $vitals->get_primary_pain_intensity() == "Comfortable" } selected{/if}>{xlt t="Comfortable"}
        </select></td>
    <td class="editonly"></td>


    { include file='vitals_historical_values.tpl' useMetric=false vitalsValue="get_primary_pain_intensity" results=$results }



