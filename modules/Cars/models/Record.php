<?php
/**
 * Cars Record Model class.
 *
 * @package   Model
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 */
class Cars_Record_Model extends Vtiger_Record_Model
{
    /**
     * Pobiera linki do akcji po prawej stronie w widoku listy rekordów.
     *
     * @return array Linki do akcji
     */
    public function getRecordListViewLinksRightSide(): array
    {
        $links = parent::getRecordListViewLinksRightSide();
        
        $links['CALCULATE_COST'] = Vtiger_Link_Model::getInstanceFromValues([
            'linklabel' => 'Oblicz koszt',
            'linkurl' => "javascript:app.showModalWindow(null, 'index.php?module=Cars&view=CostCalculator&record=" . $this->getId() . "');",
            'linkicon' => 'fas fa-calculator',
            'linkclass' => 'btn-sm btn-light',
        ]);
        
        return $links;
    }
}