<?php

/**
 * vitals report.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @author    Sherwin Gaddis <sherwingaddis@gmail.com>
 * @copyright Copyright (c) 2018 Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2021 Sherwin Gaddis <sherwingaddis@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once(__DIR__ . "/../../globals.php");
require_once($GLOBALS["srcdir"] . "/api.inc");

require_once($GLOBALS['fileroot'] . "/library/patient.inc");
use Mpdf\Mpdf;

require_once("$srcdir/options.inc.php");
require_once("$srcdir/patient.inc");
require_once("$srcdir/forms.inc");


$id=$_GET['id'];


    $PDF_OUTPUT = 1;

    if ($PDF_OUTPUT) {
        $config_mpdf = array(
            'tempDir' => $GLOBALS['MPDF_WRITE_DIR'],
            'mode' => $GLOBALS['pdf_language'],
            'format' => 'Letter',
            'default_font_size' => '9',
            'default_font' => 'dejavusans',
            'margin_left' => $GLOBALS['pdf_left_margin'],
            'margin_right' => $GLOBALS['pdf_right_margin'],
            'margin_top' => $GLOBALS['pdf_top_margin'],
            'margin_bottom' => $GLOBALS['pdf_bottom_margin'],
            'margin_header' => '',
            'margin_footer' => '',
            'orientation' => 'P',
            'shrink_tables_to_fit' => 1,
            'use_kwt' => true,
            'autoScriptToLang' => true,
            'keep_table_proportions' => true
        );
        $pdf = new mPDF($config_mpdf);
        if ($_SESSION['language_direction'] == 'rtl') {
            $pdf->SetDirectionality('rtl');
        }
        ob_start();


    ?>

                <?php
            function US_weight($pounds, $mode = 1)
{

    if ($mode == 1) {
        return $pounds . " " . xl('lb') ;
    } else {
        $pounds_int = floor($pounds);
        $ounces = round(($pounds - $pounds_int) * 16);
        return $pounds_int . " " . xl('lb') . " " . $ounces . " " . xl('oz');
    }
}
$id=$_GET['id'];

function vitals_report( $cols=1, $id, $print = true)
{

    $count = 0;
    $data = formFetch("form_vitals", $id);
    $patient_data = getPatientData($GLOBALS['pid']);
    $patient_age = getPatientAge($patient_data['DOB']);
    $is_pediatric_patient = ($patient_age <= 20 || (preg_match('/month/', $patient_age)));

    $vitals = "";
    // $fh = fopen('', 'r');
    // while (!feof($fh)) {
    //     $vitals .= fread($fh, 8192);
    // }

    // fclose($fh);
    if ($data) {
        $vitals .= "<div class='section'><table><tr>";

        foreach ($data as $key => $value) {
            if (
                $key == "uuid" ||
                $key == "id" || $key == "pid" ||
                $key == "user" || $key == "groupname" ||
                $key == "authorized" || $key == "activity" ||
                $key == "date" || $value == "" ||
                $value == "0000-00-00 00:00:00" || $value == "0.0"
            ) {
                // skip certain data
                continue;
            }

            if ($value == "on") {
                $value = "yes";
            }

            if ($key == 'inhaled_oxygen_concentration') {
                $value .= " %";
            }

            $key = ucwords(str_replace("_", " ", $key));

            //modified by BM 06-2009 for required translation
            if ($key == "Temp Method" || $key == "BMI Status") {
                if ($key == "BMI Status") {
                    if ($is_pediatric_patient) {
                        $value = "See Growth-Chart";
                    }
                }

                $vitals .= '<td><div class="bold" style="display:inline-block">' . xlt($key) . ': </div></td><td><div class="text" style="display:inline-block">' . xlt($value) . "</div></td>";
            } elseif ($key == "Bps") {
                $bps = $value;
                if (!empty($bpd)) {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt('Blood Pressure') . ": </div></td><td><div class='text' style='display:inline-block'>" . text($bps) . "/" . text($bpd)  . "</div></td>";
                } else {
                    continue;
                }
            } elseif ($key == "Bpd") {
                $bpd = $value;
                if ($bpd) {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt('Blood Pressure') . ": </div></td><td><div class='text' style='display:inline-block'>" . text($bps) . "/" . text($bpd)  . "</div></td>";
                } else {
                    continue;
                }
            } elseif ($key == "Weight") {
                $convValue = number_format($value * 0.45359237, 2);
                $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>";
                // show appropriate units
                $mode = $GLOBALS['us_weight_format'];
                if ($GLOBALS['units_of_measurement'] == 2) {
                    $vitals .=  text($convValue) . " " . xlt('kg') . " (" . text(US_weight($value, $mode)) . ")";
                } elseif ($GLOBALS['units_of_measurement'] == 3) {
                    $vitals .=  text(US_weight($value, $mode));
                } elseif ($GLOBALS['units_of_measurement'] == 4) {
                    $vitals .= text($convValue) . " " . xlt('kg');
                } else { // = 1 or not set
                    $vitals .= text(US_weight($value, $mode)) . " (" . text($convValue) . " " . xlt('kg')  . ")";
                }

                $vitals .= "</div></td>";
            } elseif ($key == "Height" || $key == "Waist Circ"  || $key == "Head Circ") {
                $convValue = round(number_format($value * 2.54, 2), 1);
                // show appropriate units
                if ($GLOBALS['units_of_measurement'] == 2) {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($convValue) . " " . xlt('cm') . " (" . text($value) . " " . xlt('in')  . ")</div></td>";
                } elseif ($GLOBALS['units_of_measurement'] == 3) {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($value) . " " . xlt('in') . "</div></td>";
                } elseif ($GLOBALS['units_of_measurement'] == 4) {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($convValue) . " " . xlt('cm') . "</div></td>";
                } else { // = 1 or not set
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($value) . " " . xlt('in') . " (" . text($convValue) . " " . xlt('cm')  . ")</div></td>";
                }
            } elseif ($key == "Temperature") {
                $convValue = number_format((($value - 32) * 0.5556), 2);
                // show appropriate units
                if ($GLOBALS['units_of_measurement'] == 2) {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($convValue) . " " . xlt('C') . " (" . text($value) . " " . xlt('F')  . ")</div></td>";
                } elseif ($GLOBALS['units_of_measurement'] == 3) {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($value) . " " . xlt('F') . "</div></td>";
                } elseif ($GLOBALS['units_of_measurement'] == 4) {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($convValue) . " " . xlt('C') . "</div></td>";
                } else { // = 1 or not set
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($value) . " " . xlt('F') . " (" . text($convValue) . " " . xlt('C')  . ")</div></td>";
                }
            } elseif ($key == "Pulse" || $key == "Respiration"  || $key == "Oxygen Saturation" || $key == "BMI" || $key == "Oxygen Flow Rate") {
                $c_value = number_format($value, 0);
                if ($key == "Oxygen Saturation") {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($c_value) . " " . xlt('%') . "</div></td>";
                } elseif ($key == "Oxygen Flow Rate") {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($value) . " " . xlt('l/min') . "</div></td>";
                } elseif ($key == "BMI") {
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($c_value) . " " . xlt('kg/m^2') . "</div></td>";
                } else { //pulse and respirations
                    $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($c_value) . " " . xlt('per min') . "</div></td>";
                }
            } elseif ($key == "Ped Weight Height" || $key == 'Ped Bmi' || $key == 'Ped Head Circ') {
                if ($is_pediatric_patient) {
                    $c_value = number_format($value, 0);
                    if ($key == "Ped Weight Height") {
                        $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt("Pediatric Height Weight Percentile") . ": </div></td><td><div class='text' style='display:inline-block'>" . text($c_value) . " " . xlt('%') . "</div></td>";
                    } elseif ($key == "Ped Bmi") {
                        $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt("Pediatric BMI Percentile") . ": </div></td><td><div class='text' style='display:inline-block'>" . text($c_value) . " " . xlt('%') . "</div></td>";
                    } elseif ($key == "Ped Head Circ") {
                        $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt("Pediatric Head Circumference Percentile") . ": </div></td><td><div class='text' style='display:inline-block'>" . text($c_value) . " " . xlt('%') . "</div></td>";
                    }
                }
            } else {
                $vitals .= "<td><div class='font-weight-bold d-inline-block'>" . xlt($key) . ": </div></td><td><div class='text' style='display:inline-block'>" . text($value) . "</div></td>";
            }

            $count++;


            if ($count == $cols) {
                $count = 0;
                $vitals .= "</tr><tr>\n";
            }
        }

        $vitals .= "</tr></table></div>";

    }

    if ($print) {
        echo $vitals;

    } else {
        return $vitals;

    }
}
    }
?>

<?php if (!$PDF_OUTPUT) { ?>
    <html>
    <head>
    <?php } ?>

    <style>

    <?php if ($PDF_OUTPUT) { ?>
    td {
     font-family: 'Times New Roman', Times, serif;
     font-weight: normal;
     font-size: 12pt;
    }
    <?php } else { ?>
    body, td {
     font-family: 'Times New Roman', Times, serif;
     font-weight: normal;
     font-size: 12pt;
    }
    body {
     padding: 5pt 5pt 5pt 5pt;
    }
    <?php } ?>

    p.grpheader {
     font-family: Arial;
     font-weight: bold;
     font-size: 12pt;
     margin-bottom: 4pt;
    }

    div.section {
     width: 98%;
    <?php
      // html2pdf screws up the div borders when a div overflows to a second page.
      // Our temporary solution is to turn off the borders in the case where this
      // is likely to happen (i.e. where all form options are listed).
      // TODO - now use mPDF, so should test if still need this fix
    if ($id) {
        ?>
    border-style: solid;
    border-width: 1px;
    border-color: #000000;
    <?php } ?>
     padding: 5pt;
    }
    div.section table {
     width: 100%;
    }
    div.section td.stuff {
     vertical-align: bottom;
     height: 16pt;
    }

    td.lcols1 { width: 20%; }
    td.lcols2 { width: 50%; }
    td.lcols3 { width: 70%; }
    td.dcols1 { width: 30%; }
    td.dcols2 { width: 50%; }
    td.dcols3 { width: 80%; }

    .mainhead {
     font-weight: bold;
     font-size: 14pt;
     text-align: center;
    }

    .under {
     border-style: solid;
     border-width: 0 0 1px 0;
     border-color: #999999;
    }

    .ftitletable {
     width: 100%;
     margin: 0 0 8pt 0;
    }
    .ftitlecell1 {
     width: 33%;
     vertical-align: top;
     text-align: left;
     font-size: 14pt;
     font-weight: bold;
    }
    .ftitlecell2 {
     width: 33%;
     vertical-align: top;
     text-align: right;
     font-size: 9pt;
    }
    .ftitlecellm {
     width: 34%;
     vertical-align: top;
     text-align: center;
     font-size: 9pt;
     font-weight: bold;
    }

    </style>
    </head>

    <body bgcolor='#ffffff'>
        <form>
            <?php
           $logo = '';
           $ma_logo_path = "sites/" . $_SESSION['site_id'] . "/images/ma_logo.png";
           if (is_file("$webserver_root/$ma_logo_path")) {
               $logo = "<img src='$web_root/$ma_logo_path' style='height:" . round(9 * 5.14) . "pt' />";
           } else {
               $logo = "<!-- '$ma_logo_path' does not exist. -->";
           }
           '<td>';
           echo genFacilityTitle(xl('Vital Form'), -1, $logo);
           '</td>';


            echo vitals_report($cols=1, $id, $print = true); ?>
            </form>
            <?php
            function getContent()
{
    global $web_root, $webserver_root;
    $content = ob_get_clean();
    // Fix a nasty html2pdf bug - it ignores document root!
    // TODO - now use mPDF, so should test if still need this fix
    $i = 0;
    $wrlen = strlen($web_root);
    $wsrlen = strlen($webserver_root);
    while (true) {
        $i = stripos($content, " src='/", $i + 1);
        if ($i === false) {
            break;
        }
        if (
            substr($content, $i + 6, $wrlen) === $web_root &&
            substr($content, $i + 6, $wsrlen) !== $webserver_root
        ) {
            $content = substr($content, 0, $i + 6) . $webserver_root . substr($content, $i + 6 + $wrlen);
        }
    }
    return $content;
}
if ($PDF_OUTPUT) {
    $content = getContent();
    $pdf->writeHTML($content);
    $pdf->Output('vitals_form.pdf', 'I'); // D = Download, I = Inline
} else {
    ?>
<!-- This should really be in the onload handler but that seems to be unreliable and can crash Firefox 3. -->
<script>
opener.top.printLogPrint(window);
</script>
</body>
</html>
<?php } ?>







