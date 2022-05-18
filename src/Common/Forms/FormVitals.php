<?php

/**
 * FormVitals represents a collection of vital measurements for a specific patient in the system.
 * For backwards compatibility it extends ORDataObject (which implements the a form of the Active record data pattern),
 * but the preferred mechanism is to use this as a POPO (Plain old PHP object) and save / retrieve data using
 * the VitalsService class.
 * @package openemr
 * @link      http://www.open-emr.org
 * @author    Stephen Nielson <stephen@nielson.org>
 * @copyright Copyright (c) 2021 Stephen Nielson <stephen@nielson.org>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Common\Forms;

/**
 * class FormVitals
 *
 */

use OpenEMR\Common\Database\QueryUtils;
use OpenEMR\Services\FHIR\Observation\FhirObservationVitalsService;
use OpenEMR\Common\ORDataObject\ORDataObject;
use OpenEMR\Common\Uuid\UuidRegistry;
use OpenEMR\Common\Utils\MeasurementUtils;

class FormVitals extends ORDataObject
{
    /**
     *
     * @access public
     */
    const TABLE_NAME = "form_vitals";

    const LIST_OPTION_VITALS_INTERPRETATION = 'vitals-interpretation';
    const
    LIST_OPTION_VITAL_OPTION = 'vital_option';


    const MEASUREMENT_METRIC_ONLY = 4;
    const MEASUREMENT_USA_ONLY = 3;
    const MEASUREMENT_PERSIST_IN_METRIC = 2;
    const MEASUREMENT_PERSIST_IN_USA = 1;
    /**
     *
     * static
     */
    public $id;
    public $date;
    public $pid;
    public $user;
    public $groupname;
    public $authorized;
    public $activity;
    public $bps;
    public $bpd;
    public $weight;
    public $height;
    public $temperature;
    public $temp_method;
    public $pulse;
    public $respiration;
    public $note;
    public $BMI;
    public $BMI_status;
    public $waist_circ;
    public $head_circ;
    public $oxygen_saturation;
    public $oxygen_flow_rate;
    public $ped_weight_height;
    public $ped_bmi;
    public $ped_head_circ;
    public $uuid;
    public $inhaled_oxygen_concentration;
    public $primary_pain_intensity;
    public $sample_note;
    public $primary_pain_location;
    public $primary_pain_laterality;
    public $primary_pain_radiation;

    /**
     * @var FormVitalDetails[]
     */



        /**
     * @var FormVitalOptions[]
     */


    private $_vitals_details = [];
    private $_vitals_options = [];


    /**
     * @var int Foreign key reference to the encounter (inside form_encounter) this vitals belongs to.
     */
    private $encounter;

    // public $temp_methods;
    /**
     * Constructor sets all Form attributes to their default value
     */

    public function __construct($id = "", $_prefix = "")
    {
        parent::__construct();
        if ($id > 0) {
            $this->id = $id;
        } else {
            $id = "";
            $this->date = $this->get_date();
        }

        $this->_table = self::TABLE_NAME;
        $this->activity = 1;
        $this->pid = $GLOBALS['pid'];
        if (!empty($id)) {
            $this->populate();
        }
    }
    public function populate()
    {
        parent::populate();
        //$this->temp_methods = parent::_load_enum("temp_locations",false);
    }

    public function toString($html = false)
    {
        $string = "\n"
            . "ID: " . $this->id . "\n";

        if ($html) {
            return nl2br($string);
        }

        return $string;
    }
    public function set_id($id)
    {
        if (!empty($id) && is_numeric($id)) {
            $this->id = $id;
        }
    }
    public function get_id()
    {
        return $this->id;
    }
    public function set_pid($pid)
    {
        if (!empty($pid) && is_numeric($pid)) {
            $this->pid = $pid;
        }
    }
    public function get_pid()
    {
        return $this->pid;
    }
    public function set_activity($tf)
    {
        if (!empty($tf) && is_numeric($tf)) {
            $this->activity = $tf;
        }
    }
    public function get_activity()
    {
        return $this->activity;
    }

    public function get_date()
    {
        if (!$this->date) {
            $this->date = date('YmdHis', time());
        }

        return $this->date;
    }

    public function set_date($dt)
    {
        if (!empty($dt)) {
            $dt = str_replace(array('-', ':', ' '), '', $dt);
            while (strlen($dt) < 14) {
                $dt .= '0';
            }

            $this->date = $dt;
        }
    }

    public function get_user()
    {
        return $this->user;
    }
    public function set_user($u)
    {
        if (!empty($u)) {
            $this->user = $u;
        }
    }

    public function get_groupname()
    {
        return $this->groupname;
    }
    public function set_groupname($g)
    {
        if (!empty($g)) {
            $this->groupname = $g;
        }
    }

    public function get_bps()
    {
        return $this->bps;
    }
    public function set_bps($bps)
    {
        if (is_numeric($bps)) {
            $this->bps = $bps;
        }
    }
    public function get_bpd()
    {
        return $this->bpd;
    }
    public function set_bpd($bpd)
    {
        if (is_numeric($bpd)) {
            $this->bpd = $bpd;
        }
    }
    public function get_weight()
    {
        return $this->weight;
    }

    public function get_weight_metric()
    {
        return MeasurementUtils::lbToKg($this->get_weight());
    }
    public function set_weight($w)
    {
        if (!empty($w) && is_numeric($w)) {
            $this->weight = $w;
        }
    }
    public function display_weight($pounds)
    {
        if ($pounds != 0) {
            if ($GLOBALS['us_weight_format'] == 2) {
                $pounds_int = floor($pounds);
                return $pounds_int . " " . xl('lb') . " " . round(($pounds - $pounds_int) * 16) . " " . xl('oz');
            }
        }
        return $pounds;
    }

    public function get_height()
    {
        return $this->height;
    }
    public function get_height_metric()
    {
        return MeasurementUtils::inchesToCm($this->get_height());
    }
    public function set_height($h)
    {
        if (!empty($h) && is_numeric($h)) {
            $this->height = $h;
        }
    }
    public function get_temperature()
    {
        return $this->temperature;
    }
    public function get_temperature_metric()
    {
        return MeasurementUtils::fhToCelsius($this->get_temperature());
    }
    public function set_temperature($t)
    {
        if (!empty($t) && is_numeric($t)) {
            $this->temperature = $t;
        }
    }
    public function get_temp_method()
    {
        return $this->temp_method;
    }
    public function set_temp_method($tm)
    {
        $this->temp_method = $tm;
    }
    // public function get_temp_methods() {
    //  return $this->temp_methods;
    // }
    public function get_pulse()
    {
        return $this->pulse;
    }
    public function set_pulse($p)
    {
        if (!empty($p) && is_numeric($p)) {
            $this->pulse = $p;
        }
    }
    public function get_respiration()
    {
        return $this->respiration;
    }
    public function set_respiration($r)
    {
        if (!empty($r) && is_numeric($r)) {
            $this->respiration = $r;
        }
    }
    public function get_note()
    {
        return $this->note;
    }
    public function set_note($n)
    {
        if (!empty($n)) {
            $this->note = $n;
        }
    }
    public function get_BMI()
    {
        return $this->BMI;
    }

    public function get_BMI_short()
    {
    }
    public function set_BMI($bmi)
    {
        if (!empty($bmi) && is_numeric($bmi)) {
            $this->BMI = $bmi;
        }
    }
    public function get_BMI_status()
    {
        return $this->BMI_status;
    }
    public function set_BMI_status($status)
    {
        $this->BMI_status = $status;
    }
    public function get_waist_circ()
    {
        return $this->waist_circ;
    }
    public function get_waist_circ_metric()
    {
        return MeasurementUtils::inchesToCm($this->get_waist_circ());
    }
    public function set_waist_circ($w)
    {
        if (!empty($w) && is_numeric($w)) {
            $this->waist_circ = $w;
        }
    }
    public function get_head_circ()
    {
        return $this->head_circ;
    }
    public function get_head_circ_metric()
    {
        return MeasurementUtils::inchesToCm($this->get_head_circ());
    }
    public function set_head_circ($h)
    {
        if (!empty($h) && is_numeric($h)) {
            $this->head_circ = $h;
        }
    }
    public function get_oxygen_saturation()
    {
        return $this->oxygen_saturation;
    }
    public function set_oxygen_saturation($o)
    {
        if (!empty($o) && is_numeric($o)) {
            $this->oxygen_saturation = $o;
        }
    }

    public function get_oxygen_flow_rate()
    {
        return $this->oxygen_flow_rate;
    }
    public function set_oxygen_flow_rate($o)
    {
        if (!empty($o) && is_numeric($o)) {
            $this->oxygen_flow_rate = $o;
        } else {
            $this->oxygen_flow_rate = 0.00;
        }
    }

    public function get_inhaled_oxygen_concentration()
    {
        return $this->inhaled_oxygen_concentration;
    }

    public function set_inhaled_oxygen_concentration($value)
    {
        if (!empty($value) && is_numeric($value)) {
            $this->inhaled_oxygen_concentration = $value;
        } else {
            $this->inhaled_oxygen_concentration = 0.00;
        }
    }

    public function get_ped_weight_height()
    {
        return $this->ped_weight_height;
    }
    public function set_ped_weight_height($o)
    {
        if (!empty($o) && is_numeric($o)) {
            $this->ped_weight_height = $o;
        } else {
            $this->ped_weight_height = 0.00;
        }
    }

    public function get_ped_bmi()
    {
        return $this->ped_bmi;
    }
    public function set_ped_bmi($o)
    {
        if (!empty($o) && is_numeric($o)) {
            $this->ped_bmi = $o;
        } else {
            $this->ped_bmi = 0.00;
        }
    }

    public function get_ped_head_circ()
    {
        return $this->ped_head_circ;
    }
    public function set_ped_head_circ($o)
    {
        if (!empty($o) && is_numeric($o)) {
            $this->ped_head_circ = $o;
        } else {
            $this->ped_head_circ = 0.00;
        }
    }

    /**
     * Returns the binary uuid string
     * @return string
     */
    public function get_uuid()
    {
        return $this->uuid;
    }

    /**
     * Set the binary uuid string.
     * @param $uuid string
     */
    public function set_uuid($uuid)
    {
        if (!empty($uuid)) {
            $this->uuid = $uuid;
        }
    }

    public function get_primary_pain_intensity()
    {
        return $this->primary_pain_intensity;
    }
    public function set_primary_pain_intensity($pi)
    {
        $this->primary_pain_intensity = $pi;
    }

    public function get_sample_note()
    {
        return $this->sample_note;
    }
    public function set_sample_note($sn)
    {
        if (!empty($sn)) {
            $this->sample_note = $sn;
        }
    }

    public function get_primary_pain_location()
    {
        return $this->primary_pain_location;
    }
    public function set_primary_pain_location($pl)
    {
        $this->primary_pain_location = $pl;
    }

    public function get_primary_pain_laterality()
    {
        return $this->primary_pain_laterality;
    }

    public function set_primary_pain_laterality($val)
    {
        if (!empty($val) && is_numeric($val)) {
            $this->primary_pain_laterality = $val;
        } else {
            $this->primary_pain_laterality = 0.00;
        }
    }


    public function get_primary_pain_radiation()
    {
        return $this->primary_pain_radiation;
    }

    public function set_primary_pain_radiation($v)
    {
        if (!empty($v) && is_numeric($v)) {
            $this->primary_pain_radiation = $v;
        } else {
            $this->primary_pain_radiation = 0.00;
        }
    }


    public function get_uuid_string()
    {
        if (empty($this->uuid)) {
            return "";
        } else {
            return UuidRegistry::uuidToString($this->uuid);
        }
    }

    public function get_details_for_column($column)
    {
        if (isset($this->_vitals_details[$column])) {
            return $this->_vitals_details[$column];
        }
        return null;
    }

    public function set_details_for_column($column, FormVitalDetails $details)
    {
        $this->_vitals_details[$column] = $details;
    }

    public function get_vital_option_for_column($column)
    {
        if (isset($this->_vitals_options[$column])) {
            return $this->_vitals_options[$column];
        }
        return null;
    }

    public function set_vital_option_for_column($column, FormVitalOptions $details)
    {
        $this->_vitals_options[$column] = $details;
    }

    public function persist()
    {
        if (empty($this->uuid)) {
            $this->uuid = (new UuidRegistry(['table_name' => self::TABLE_NAME]))->createUuid();
        }
        parent::persist();

        foreach ($this->_vitals_details as $item) {
            $item->set_form_id($this->get_id());
            $item->persist();
        }
    }

    /**
     * @param mixed $column
     * @return mixed
     */


    public function populate_array($results)
    {
        // because our vitals form can actually have data values of 0 we can't use the parent populate_array as it does
        // an empty check

        if (is_array($results)) {

            foreach ($results as $field_name => $field) {
                $func = "set_" . $field_name;
                if (is_callable(array($this,$func))) {
                    // if we have a number 0 we want to let it through.  Originally this failed due to the empty check.
                    if (is_numeric($field) || !empty($field)) {
                        //echo "s: $field_name to: $field <br />";
                        call_user_func(array(&$this,$func), $field);
                    }
                }
            }
        }
        $encounter = $results['eid'] ?? $results['encounter'] ?? null;
        $this->set_encounter($encounter);

        // now let's setup our details objects
        if (isset($results['details'])) {
            foreach ($results['details'] as $column => $detail) {
                $vitalsDetail = new FormVitalDetails();
                $vitalsDetail->populate_array($detail);
                $vitalsDetail->set_form_id($this->get_id());
                $this->set_details_for_column($column, $vitalsDetail);
            }
        }
               // now let's setup our details objects
        // if (isset($results['options'])) {
        //         foreach ($results['options'] as $column => $detail) {
        //             $vitalsOption = new FormVitalOptions();
        //             $vitalsOption->populate_array($detail);
        //             $vitalsOption->set_form_id($this->get_id());
        //             $this->set_vital_option_for_column($column, $vitalsOption);
        //         }
        //     }

    }

    public function get_vital_details()
    {
        return array_values($this->_vitals_details);
    }

    // public function get_vital_options()
    // {
    //     return array_values($this->_vitals_options);
    // }
    public function get_data_for_save()
    {
        $values = parent::get_data_for_save();
        $values['eid'] = $this->get_encounter();
        $values['authorized'] = $this->get_authorized();
        $values['details'] = [];
        // $values['options'] = [];

        // now grab the details
        $details = $this->get_vital_details();
        foreach ($details as $detail) {
            $values['details'][] = $detail->get_data_for_save();
        }
        // $options = $this->get_vital_options();
        // foreach ($options as $option) {
        //     $values['options'][] = $option->get_data_for_save();
        // }


        return $values;
    }

    public function get_encounter()
    {
        return $this->encounter;
    }

    public function set_encounter($eid)
    {
        $this->encounter = $eid;
    }
    /**
     * @return mixed
     */
    public function get_authorized()
    {
        return $this->authorized;
    }

    /**
     * @param mixed $authorized
     * @return FormVitals
     */
    public function set_authorized($authorized)
    {
        $this->authorized = $authorized;
        return $this;
    }
}   // end of Form
