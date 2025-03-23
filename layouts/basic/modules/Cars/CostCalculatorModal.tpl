{strip}
    <div class="modal-header">
        <h5 class="modal-title">
            <span class="fas fa-calculator mr-1"></span>
            Kalkulator kosztów
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Zamknij">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="costCalculatorForm">
            <input type="hidden" name="record" value="{$RECORD_ID}" />
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">
                    Data początkowa:
                </label>
                <div class="col-sm-8">
                    <div class="input-group date">
                        <input type="text" name="start_date" class="dateField form-control" data-date-format="yyyy-mm-dd" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <span class="fas fa-calendar-alt"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">
                    Data końcowa:
                </label>
                <div class="col-sm-8">
                    <div class="input-group date">
                        <input type="text" name="end_date" class="dateField form-control" data-date-format="yyyy-mm-dd" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <span class="fas fa-calendar-alt"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" type="button" name="calculateButton" id="calculateButton">
            <span class="fas fa-calculator mr-1"></span>
            Oblicz
        </button>
        <button class="btn btn-danger" type="reset" data-dismiss="modal">
            <span class="fas fa-times mr-1"></span>
            Anuluj
        </button>
    </div>
<!-- Jeśli rozbudowywałbym ten modul to przenioslbym ten JS do jakiegos zewnetrznego pliku -->
    <script type="text/javascript">
        jQuery(document).ready(function () {
            // Inicjalizacja kalendarzy
            jQuery('#costCalculatorForm').find('.dateField').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });
            
            // Obsługa przycisku "Oblicz"
            jQuery('#calculateButton').on('click', function () {
                const form = jQuery('#costCalculatorForm');
                const startDate = form.find('input[name="start_date"]');
                const endDate = form.find('input[name="end_date"]');
                let isValid = true;
                
                // Resetowanie poprzednich błędów
                form.find('.form-control').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
                
                // Walidacja daty początkowej
                if (!startDate.val()) {
                    startDate.addClass('is-invalid');
                    startDate.parent().append('<div class="invalid-feedback">To pole jest wymagane</div>');
                    isValid = false;
                }
                
                // Walidacja daty końcowej
                if (!endDate.val()) {
                    endDate.addClass('is-invalid');
                    endDate.parent().append('<div class="invalid-feedback">To pole jest wymagane</div>');
                    isValid = false;
                }
                
                // Walidacja zakresu dat (jeśli obie daty są wypełnione)
                if (startDate.val() && endDate.val()) {
                    const start = new Date(startDate.val());
                    const end = new Date(endDate.val());
                    if (start > end) {
                        endDate.addClass('is-invalid');
                        endDate.parent().append('<div class="invalid-feedback">Data końcowa musi być późniejsza niż data początkowa</div>');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    app.showNotify({
                        text: 'Proszę wypełnić wszystkie wymagane pola',
                        type: 'error'
                    });
                    return false;
                }
                
                const recordId = form.find('input[name="record"]').val();
                
                // tutaj pobirram dane o rekordzie i powiązanych rekordach za pomocą AJAX
                AppConnector.request({
                    module: 'Cars',
                    action: 'GetRecordInfo',
                    record: recordId,
                    start_date: startDate.val(),
                    end_date: endDate.val()
                }).done(function(response) {
                    if (response.success) {
                        const data = response.result;
                        
                        let title = 'Wynik kalkulacji kosztów';
                        let message = '<div class="cost-calculation-result">';
                        message += '<p><strong>Samochód:</strong> ' + data.car_name + ' (ID: ' + recordId + ')</p>';
                        message += '<p><strong>Zakres dat:</strong> od ' + startDate.val() + ' do ' + endDate.val() + '</p>';
                        message += '<p><strong>Średnie zużycie paliwa:</strong> ' + data.average_fuel + ' l/100km</p>';
                        
                        // Dodałem sobie informacji o powiązanych rekordach Departures jeśli istnieją
                        if (data.found_records) {
                            message += '<p><strong>Znalezione wyjazdy:</strong></p><ul>';
                            
                            data.departure_details.forEach(function(departure) {
                                message += '<li>Rekord Departures (ID: ' + departure.id + '), przejechane kilometry: ' + departure.kilometers + '</li>';
                            });
                            
                            message += '</ul>';
                            message += '<p><strong>Łączna liczba przejechanych kilometrów:</strong> ' + data.total_kilometers.toFixed(2) + ' km</p>';
                            message += '<p><strong>Koszt eksploatacji:</strong> ' + data.total_cost.toFixed(2) + ' zł</p>';
                            message += '<p><small>(Obliczono według wzoru: (Suma kilometrów / 100) * Średnie zużycie paliwa * 5 zł)</small></p>';
                            
                            // Zapisuje sobie obliczony koszt do pola operating_costs
                            saveOperatingCosts(recordId, data.total_cost.toFixed(2), title, message);
                        } else {
                            message += '<p><strong>Nie znaleziono żadnych wyjazdów w podanym zakresie dat.</strong></p>';
                            message += '</div>';
                            
                            // powiadomienia
                            app.showNotify({
                                title: title,
                                text: message,
                                type: 'info',
                                textTrusted: true,
                                animation: 'show',
                                delay: 0,
                                hide: false,
                                closer: true,
                                sticker: false
                            });
                        }
                    } else {
                        app.showNotify({
                            title: 'Błąd',
                            text: 'Nie udało się obliczyć kosztu eksploatacji',
                            type: 'error'
                        });
                    }
                }).fail(function() {
                    app.showNotify({
                        title: 'Błąd',
                        text: 'Wystąpił błąd podczas komunikacji z serwerem',
                        type: 'error'
                    });
                });
            });
            
            // Funkcja do zapisywania kosztu eksploatacji polaczone z moim php SaveOperatingCosts
            function saveOperatingCosts(recordId, cost, title, message) {
                AppConnector.request({
                    module: 'Cars',
                    action: 'SaveOperatingCosts',
                    record: recordId,
                    operating_costs: cost
                }).done(function(response) {
                    // Wyświetl powiadomienie z informacją o kosztach
                    app.showNotify({
                        title: title,
                        text: message + '<p class="text-success mt-2"><strong>Koszt został zapisany do rekordu.</strong></p></div>',
                        type: 'success',
                        textTrusted: true,
                        animation: 'show',
                        delay: 0,
                        hide: false,
                        closer: true,
                        sticker: false
                    });
                    
                    // Zamknij okno modalne
                    app.hideModalWindow();
                    
                    // Odśwież widok rekordu, jeśli jesteśmy na stronie szczegółów
                    if (app.getViewName() === 'Detail') {
                        app.event.trigger('DetailView.UpdateRecord');
                    }
                }).fail(function() {
                    // W przypadku błędu wyświetl powiadomienie z informacją o kosztach, ale z ostrzeżeniem
                    app.showNotify({
                        title: title,
                        text: message + '<p class="text-danger mt-2"><strong>Uwaga: Nie udało się zapisać kosztu eksploatacji do rekordu.</strong></p></div>',
                        type: 'warning',
                        textTrusted: true,
                        animation: 'show',
                        delay: 0,
                        hide: false,
                        closer: true,
                        sticker: false
                    });
                });
            }
        });
    </script>
{/strip}
