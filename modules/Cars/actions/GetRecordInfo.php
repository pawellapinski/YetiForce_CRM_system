<?php
/**
 * Get record info action class.
 *
 * @package   Action
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    YetiForce
 */

class Cars_GetRecordInfo_Action extends \App\Controller\Action
{
    /**
     * tutaj dałem do stałej cenę benzyny mozna zmienić.
     */
    private const FUEL_PRICE_PER_LITER = 5.0;

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
        if (!\App\Privilege::isPermitted('Cars', 'DetailView', $recordId)) {
            throw new \App\Exceptions\NoPermittedToRecord('ERR_NO_PERMISSIONS_FOR_THE_RECORD', 406);
        }
    }

    /**
     * @param \App\Request $request
     * @return void
     */
    public function process(\App\Request $request): void
    {
        $recordId = $request->getInteger('record');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $result = [];
        
        try {
        
            if ($startDate && $endDate && strtotime($startDate) > strtotime($endDate)) {
                throw new \Exception('Start date cannot be later than end date');
            }
            
            $recordModel = Vtiger_Record_Model::getInstanceById($recordId, 'Cars');
            $result['car_name'] = $recordModel->get('car_name');
            $averageFuel = (float)$recordModel->get('average_fuel');
            $result['average_fuel'] = $averageFuel;
            
            // tutaj pobieram dane o wyjazdach
            $departureData = $this->getDepartureData($recordId, $startDate, $endDate);
            $result = array_merge($result, $departureData);
            
            $response = new Vtiger_Response();
            $response->setResult($result);
            $response->emit();
        } catch (\Exception $e) {
            $response = new Vtiger_Response();
            $response->setError($e->getMessage());
            $response->emit();
        }
    }
    
    /**
     * Pobiera dane o wyjazdach i oblicza koszty.
     *
     * @param int $recordId ID rekordu samochodu
     * @param string|null $startDate Data początkowa
     * @param string|null $endDate Data końcowa
     * @return array Dane o wyjazdach i obliczonych kosztach
     */
    private function getDepartureData(int $recordId, ?string $startDate, ?string $endDate): array
    {
        // Tutaj sobie sprawdzam, czy istnieją powiązane rekordy w module Departures w podanym zakresie dat
        $query = (new \App\Db\Query())->select(['departuresid', 'kilometers_traveled'])
            ->from('u_yf_departures')
            ->innerJoin('vtiger_crmentity', 'vtiger_crmentity.crmid = u_yf_departures.departuresid')
            ->where(['u_yf_departures.car' => $recordId, 'vtiger_crmentity.deleted' => 0]);
        
        // Dodaj warunek na zakres dat, jeśli podano daty
        if ($startDate && $endDate) {
            $query->andWhere(['between', 'u_yf_departures.departure_date', $startDate, $endDate]);
        }
        
        // Pobierz wszystkie pasujące rekordy
        $departureRecords = $query->all();
        $departureDetails = [];
        $totalKilometers = 0.0;
        
        foreach ($departureRecords as $record) {
            $kilometers = (float)$record['kilometers_traveled'];
            $totalKilometers += $kilometers;
            
            $departureDetails[] = [
                'id' => $record['departuresid'],
                'kilometers' => $kilometers
            ];
        }
        
        $recordModel = Vtiger_Record_Model::getInstanceById($recordId, 'Cars');
        $averageFuel = (float)$recordModel->get('average_fuel');
        
        // tutaj sobie policzylem koszt
        $cost = $this->calculateCost($totalKilometers, $averageFuel);
        
        return [
            'departure_details' => $departureDetails,
            'total_kilometers' => $totalKilometers,
            'total_cost' => $cost,
            'found_records' => !empty($departureDetails)
        ];
    }
    
    /**
     * Oblicza koszt eksploatacji na podstawie przejechanych kilometrów i średniego zużycia paliwa.
     *
     * @param float $kilometers Przejechane kilometry
     * @param float $averageFuel Średnie zużycie paliwa (l/100km)
     * @return float Obliczony koszt
     */
    private function calculateCost(float $kilometers, float $averageFuel): float
    {
        if ($kilometers <= 0 || $averageFuel <= 0) {
            return 0.0;
        }
        
        return ($kilometers / 100) * $averageFuel * self::FUEL_PRICE_PER_LITER;
    }
}