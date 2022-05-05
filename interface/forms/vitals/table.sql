CREATE TABLE IF NOT EXISTS `form_vitals` (
`id`                bigint(20)      NOT NULL auto_increment,
`uuid`              binary(16)      DEFAULT NULL,
`date`              datetime        default NULL,
`pid`               bigint(20)      default 0,
`user`              varchar(255)    default NULL,
`groupname`         varchar(255)    default NULL,
`authorized`        tinyint(4)      default 0,
`activity`          tinyint(4)      default 0,
`bps`               varchar(40)     default 0,
`bpd`               varchar(40)     default 0,
`weight`            FLOAT(5,2)      default 0,
`height`            FLOAT(5,2)      default 0,
`temperature`       FLOAT(5,2)      default 0,
`temp_method`       VARCHAR(255)    default NULL,
`pulse`             FLOAT(5,2)      default 0,
`respiration`       FLOAT(5,2)      default 0,
`note`              VARCHAR(255)    default NULL,
`BMI`               FLOAT(4,1)      default 0,
`BMI_status`        VARCHAR(255)    default NULL,
`waist_circ`        FLOAT(5,2)      default 0,
`head_circ`         FLOAT(4,2)      default 0,
`oxygen_saturation` FLOAT(5,2)      default 0,
`oxygen_flow_rate`  FLOAT(5,2)      DEFAULT '0.00',
`ped_weight_height` FLOAT(4,1)      DEFAULT '0.00',
`ped_bmi`           FLOAT(4,1)      DEFAULT '0.00',
`ped_head_circ`     FLOAT(4,1)      DEFAULT '0.00',
PRIMARY KEY (id),
UNIQUE KEY `uuid` (uuid)
) ENGINE=InnoDB;


#IfMissingColumn form_vitals primary_pain_intensity
ALTER TABLE `form_vitals` ADD `primary_pain_intensity` VARCHAR(255) DEFAULT NULL;
#EndIf

#IfMissingColumn form_vitals primary_pain_location
ALTER TABLE `form_vitals` ADD `primary_pain_location` VARCHAR(255) DEFAULT NULL;
#EndIf

#IfMissingColumn form_vitals primary_pain_laterality
ALTER TABLE `form_vitals` ADD `primary_pain_laterality` VARCHAR(255) DEFAULT NULL;
#EndIf

#IfMissingColumn form_vitals primary_pain_radiation
ALTER TABLE `form_vitals` ADD `primary_pain_radiation` VARCHAR(255) DEFAULT NULL;
#EndIf

#IfMissingColumn form_vitals primary_pain_interventions
ALTER TABLE `form_vitals` ADD `primary_pain_interventions` VARCHAR(255) DEFAULT NULL;
#EndIf

#IfMissingColumn form_vitals primary_pain_aggravating_factors
ALTER TABLE `form_vitals` ADD `primary_pain_aggravating_factors` VARCHAR(255) DEFAULT NULL;
#EndIf

#IfMissingColumn form_vitals primary_pain_alleviating_factors
ALTER TABLE `form_vitals` ADD `primary_pain_alleviating_factors` VARCHAR(255) DEFAULT NULL;
#EndIf
