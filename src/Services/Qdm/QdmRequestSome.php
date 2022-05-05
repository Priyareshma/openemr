<?php

/**
 * @package OpenEMR
 * @link      http://www.open-emr.org
 * @author    Ken Chapple <ken@mi-squared.com>
 * @copyright Copyright (c) 2021 Ken Chapple <ken@mi-squared.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU GeneralPublic License 3
 */

namespace OpenEMR\Services\Qdm;

use OpenEMR\Services\Qdm\Interfaces\QdmRequestInterface;

class QdmRequestSome implements QdmRequestInterface
{
    public $pids = [];

    public $pidString = "";

    /**
     * QdmQuery constructor.
     * @param array $pids
     */
    public function __construct(array $pids)
    {
        $this->pids = $pids;

        if (is_array($pids)) {
            $this->pidString = implode(",", $pids);
        }
    }

    public function getPidString()
    {
        return $this->pidString;
    }

    /**
     * @return array
     */
    public function getPids(): array
    {
        return $this->pids;
    }

    /**
     * @param array $pids
     */
    public function setPids(array $pids): void
    {
        $this->pids = $pids;
    }


    public function getFilter()
    {
        // TODO: Implement getFilter() method.
    }
}
