<?php

class Cars_SaveOperatingCosts_Action extends \App\Controller\Action
{
    /**

     * @param \App\Request $request
     *
     * @throws \App\Exceptions\NoPermitted
     * @throws \App\Exceptions\NoPermittedToRecord
     * @return void
     */
    public function checkPermission(\App\Request $request): void
    {
        $recordId = $request->getInteger('record');
        if (!$recordId) {
            throw new \App\Exceptions\NoPermittedToRecord('ERR_NO_PERMISSIONS_FOR_THE_RECORD', 406);
        }
        if (!\App\Privilege::isPermitted('Cars', 'EditView', $recordId)) {
            throw new \App\Exceptions\NoPermittedToRecord('ERR_NO_PERMISSIONS_FOR_THE_RECORD', 406);
        }
    }

    /**
     * Process.
     *
     * @param \App\Request $request
     * @return void
     */
    public function process(\App\Request $request): void
    {
        $recordId = $request->getInteger('record');
        $operatingCosts = $request->getByType('operating_costs', 'NumberInUserFormat');
        $result = ['success' => false];
        
        try {
            if ($operatingCosts === null || $operatingCosts < 0) {
                throw new \Exception('Invalid operating costs value');
            }
            
            $recordModel = Vtiger_Record_Model::getInstanceById($recordId, 'Cars');
            
            $recordModel->set('operating_costs', $operatingCosts);
            $recordModel->save();
            
            $result['success'] = true;
            
            $response = new Vtiger_Response();
            $response->setResult($result);
            $response->emit();
        } catch (\Exception $e) {
            $response = new Vtiger_Response();
            $response->setError($e->getMessage());
            $response->emit();
        }
    }
}