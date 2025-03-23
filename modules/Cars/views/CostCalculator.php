<?php

class Cars_CostCalculator_View extends Vtiger_BasicModal_View
{
    /**
     * Sprawdza uprawnienia do wykonania akcji.
     *
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
        if (!\App\Privilege::isPermitted('Cars', 'DetailView', $recordId)) {
            throw new \App\Exceptions\NoPermittedToRecord('ERR_NO_PERMISSIONS_FOR_THE_RECORD', 406);
        }
    }

    /**
     * wyświetla widok mojego kalkulatora kosztów.
     *
     * @param \App\Request $request
     * @return void
     */
    public function process(\App\Request $request): void
    {
        try {
            $this->preProcess($request);
            $viewer = $this->getViewer($request);
            $viewer->assign('MODULE_NAME', $request->getModule());
            $viewer->assign('RECORD_ID', $request->getInteger('record'));
            $viewer->view('CostCalculatorModal.tpl', $request->getModule());
            $this->postProcess($request);
        } catch (\Exception $e) {
            \App\Log::error('Error in CostCalculator view: ' . $e->getMessage());
            throw $e;
        }
    }
}