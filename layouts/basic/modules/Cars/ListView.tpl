<!--
&lt;!&ndash; Modal Kalkulator kosztu eksploatacji &ndash;&gt;
<div class="modal fade" id="costCalculatorModal" tabindex="-1" role="dialog" aria-labelledby="costCalculatorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="costCalculatorModalLabel">
          <span class="fas fa-calculator mr-1"></span>
          Kalkulator kosztu eksploatacji
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="costCalculatorForm">
          <input type="hidden" id="recordId" name="recordId" value="">
          <div class="form-group row">
            <label for="startDate" class="col-sm-4 col-form-label">Data początku eksploatacji:</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="startDate" name="startDate">
            </div>
          </div>
          <div class="form-group row">
            <label for="endDate" class="col-sm-4 col-form-label">Data końca eksploatacji:</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="endDate" name="endDate">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="calculateButton">
          <span class="fas fa-calculator mr-1"></span>
          Oblicz
        </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">
          <span class="fas fa-times mr-1"></span>
          Anuluj
        </button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
// Funkcja do obsługi modalu kalkulatora kosztów
function showCostCalculatorModal(recordId) {
    // Ustawienie ID rekordu w formularzu
    jQuery('#recordId').val(recordId);
    
    // Wyświetlenie modalu
    jQuery('#costCalculatorModal').modal('show');
    
    // Obsługa przycisku "Oblicz"
    jQuery('#calculateButton').off('click').on('click', function() {
        const startDate = jQuery('#startDate').val();
        const endDate = jQuery('#endDate').val();
        
        // Na razie tylko wyświetlamy alert z wybranymi datami
        alert('Obliczanie kosztu eksploatacji od ' + startDate + ' do ' + endDate);
    });
}

// Inicjalizacja po załadowaniu dokumentu
jQuery(document).ready(function () {
    // Obsługa przycisku kalkulatora w każdym wierszu
    jQuery(document).on('click', '.js-calculate-cost', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const recordId = jQuery(this).data('record-id');
        showCostCalculatorModal(recordId);
    });
});
</script>-->
