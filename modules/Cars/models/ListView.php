<?php

class Cars_ListView_Model extends Vtiger_ListView_Model
{
    /**
     * Pobiera akcje masowe dostępne w widoku listy.
     *
     * @param array $linkParams Parametry linku
     * @return array Akcje masowe
     */
    public function getListViewMassActions($linkParams): array
    {
        $massActionLinks = parent::getListViewMassActions($linkParams);

        $moduleModel = $this->getModule();
        if ($moduleModel->isPermitted('EditView')) {
            $massActionLinks['add'][] = [
                'linktype' => 'LISTVIEWMASSACTION',
                'linklabel' => 'Oblicz koszt',
                'linkicon' => 'fas fa-calculator',
                'linkclass' => 'js-calculate-cost',
                'linkurl' => 'javascript:void(0);',
            ];
        }

        return $massActionLinks;
    }
}