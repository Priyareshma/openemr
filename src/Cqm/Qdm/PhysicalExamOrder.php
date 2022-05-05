<?php

namespace OpenEMR\Cqm\Qdm;

/**
 * OpenEMR\Cqm\Qdm\PhysicalExamOrder
 *
 * This is a class generated with Laminas\Code\Generator.
 *
 * @QDM Version 5.5
 * @author Ken Chapple <ken@mi-squared.com>
 * @license https://github.com/openemr/openemr/blob/master/LICENSE GNU General
 * Public License 3
 */
class PhysicalExamOrder extends QDMBaseType
{

    /**
     * @property BaseTypes\DateTime $authorDatetime
     */
    public $authorDatetime = null;

    /**
     * @property BaseTypes\Code $reason
     */
    public $reason = null;

    /**
     * @property BaseTypes\Code $anatomicalLocationSite
     */
    public $anatomicalLocationSite = null;

    /**
     * @property BaseTypes\Code $negationRationale
     */
    public $negationRationale = null;

    /**
     * @property BaseTypes\Any $requester
     */
    public $requester = null;

    /**
     * @property string $hqmfOid
     */
    public $hqmfOid = '2.16.840.1.113883.10.20.28.4.61';

    /**
     * @property string $qrdaOid
     */
    public $qrdaOid = '';

    /**
     * @property string $qdmCategory
     */
    public $qdmCategory = 'physical_exam';

    /**
     * @property string $qdmStatus
     */
    public $qdmStatus = 'order';

    public $_type = 'QDM::PhysicalExamOrder';
}
