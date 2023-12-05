<!-- Add Bootstrap CSS and JavaScript CDNs to your HTML file -->
<div class="modal right fade come-from-modal" id="cartModal" tabindex="-1" role="dialog"
  aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <?php
    ?>
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title fs-3" id="cartModalLabel">Your Cart</h5>
        <span class="close p-1 fs-3" data-dismiss="modal" aria-label="Close">
          <i class="fa-solid fa-xmark"></i>
        </span>
      </div>
      <div class="modal-body" style="overflow-y:'scroll';">
        <!-- Your cart content goes here -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>