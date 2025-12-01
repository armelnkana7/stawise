<?php if (isset($layout) && $layout === 'auth'): ?>
    <!-- Auth footer -->
    <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
        <div class="d-flex flex-center fw-semibold fs-6">
            <a href="https://keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">About</a>
            <a href="https://devs.keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
        </div>
    </div>
    <!-- Javascript -->
    <script>var hostUrl = "<?php echo url('theme/dist/assets/'); ?>";</script>
    <script src="<?php echo url('theme/dist/assets/plugins/global/plugins.bundle.js'); ?>"></script>
    <script src="<?php echo url('theme/dist/assets/js/scripts.bundle.js'); ?>"></script>
    <script src="<?php echo url('theme/dist/assets/js/custom/authentication/sign-in/general.js'); ?>"></script>
    </body>

    </html>
<?php else: ?>
    <!-- Footer -->
    <footer class="mt-5 py-4 border-top">
        <div class="container text-center">
            <small class="text-muted">&copy; <?php echo date('Y'); ?> StatWise</small>
        </div>
    </footer>
    </div> <!-- end .d-flex flex-column flex-column-fluid -->
    </div> <!-- end .app-main -->
    </div> <!-- end .app-wrapper -->
    </div> <!-- end .app-page -->
    </div> <!-- end .app-root -->
    <!-- Javascript -->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script>var hostUrl = "<?php echo url('theme/dist/assets/'); ?>";</script>
    <script src="<?php echo url('theme/dist/assets/plugins/global/plugins.bundle.js'); ?>"></script>
    <script src="<?php echo url('theme/dist/assets/js/scripts.bundle.js'); ?>"></script>
    <script src="<?php echo url('theme/dist/assets/js/custom/apps/chat/chat.js'); ?>"></script>
    <script src="<?php echo url('theme/dist/assets/plugins/custom/datatables/datatables.bundle.js'); ?>"></script>

    </html>
<?php endif; ?>
<script>
    // Show flash messages using toastr if available
    (function () {
        var f = window.__flash || {};
        try {
            if (typeof toastr !== 'undefined') {
                Object.keys(f).forEach(function (k) {
                    var msg = f[k];
                    if (!msg) return;
                    if (k === 'success') toastr.success(msg);
                    else toastr.error(msg);
                });
            } else {
                // fallback: log
                Object.keys(f).forEach(function (k) { if (f[k]) console.log(k + ': ' + f[k]); });
            }
        } catch (e) { console.error('toastr display failed', e); }
    })();
</script>
<script>
    // Initialize Select2 for enhanced selects if plugin present
    (function () {
        try {
            if (typeof $ !== 'undefined' && typeof $.fn !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
                document.querySelectorAll('.select2').forEach(function (el) {
                    if (!$(el).data('select2')) {
                        $(el).select2({ width: '100%' });
                    }
                });
            }
        } catch (e) { console.error('Select2 init failed', e); }
    })();
</script>

<script>
    $(document).ready(function () {
        // Generic: initialize a datatable per card (if any) and bind its local filters
        $('.card').each(function () {
            var card = $(this);
            var tableEl = card.find('table').first();
            if (!tableEl || tableEl.length === 0) return;
            var dt = tableEl.DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "lengthChange": false,
                "pageLength": 10,
            });

            // search input within this card
            card.find('input[data-kt-customer-table-filter="search"]').on('keyup', function () {
                dt.search(this.value).draw();
            });

            // Month select filter in card
            card.find('select[data-kt-customer-table-filter="month"]').on('change', function () {
                var val = $(this).val();
                if (val) {
                    // We try to search in the whole table or a logical column; fallback to global search
                    dt.search(val, true, false).draw();
                } else {
                    dt.search('').draw();
                }
            });

            // Payment type filter (radio) within card
            card.find('input[name="payment_type"]').on('change', function () {
                var val = $(this).val();
                if (val === 'all') {
                    dt.search('').draw();
                } else {
                    dt.search(val, true, false).draw();
                }
            });

            // Reset filters within this card
            card.find('[data-kt-customer-table-filter="reset"]').on('click', function () {
                dt.search('').columns().search('').draw();
                card.find('input[name="payment_type"][value="all"]').prop('checked', true);
                card.find('select[data-kt-customer-table-filter="month"]').val('').trigger('change');
            });
        });
    });

</script>
<!-- Global confirm delete modal -->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="modalDeleteForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmDeleteLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalDeleteMessage">Voulez-vous supprimer cet élément ?</p>
                    <input type="hidden" name="id" id="modalDeleteId" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger" id="modalConfirmDeleteBtn">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    (function(){
        // When a .btn-open-delete-modal is clicked, populate modal form and show
        document.addEventListener('click', function(e){
            const el = e.target.closest('.btn-open-delete-modal');
            if (!el) return;
            e.preventDefault();
            const action = el.dataset.action || el.getAttribute('data-action');
            const id = el.dataset.id || el.getAttribute('data-id');
            const name = el.dataset.name || el.getAttribute('data-name') || '';
            const message = name ? ('Voulez-vous supprimer "' + name + '" ?') : 'Voulez-vous supprimer cet élément ?';
            const modal = document.getElementById('modalConfirmDelete');
            const form = document.getElementById('modalDeleteForm');
            const idInput = document.getElementById('modalDeleteId');
            const msg = document.getElementById('modalDeleteMessage');
            if (form) form.setAttribute('action', action);
            if (idInput) idInput.value = id || '';
            if (msg) msg.textContent = message;
            var bs = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
            bs.show();
        });
    })();
    // Generic edit button handler for subjects (and others) using data-* attributes
    (function(){
        document.addEventListener('click', function(e){
            var el = e.target.closest('.btn-edit-subject');
            if (!el) return;
            e.preventDefault();
            var id = el.dataset.id || '';
            var name = el.dataset.name || '';
            var code = el.dataset.code || '';
            var desc = el.dataset.desc || '';
            var est = el.dataset.establishmentId || el.dataset.establishmentId || '';
            var dept = el.dataset.departmentId || el.dataset.departmentId || '';
            var modal = document.getElementById('modalSubjectEdit');
            if (!modal) return;
            document.getElementById('edit_subject_id').value = id;
            document.getElementById('edit_subject_name').value = name;
            document.getElementById('edit_subject_code').value = code;
            document.getElementById('edit_subject_description').value = desc;
            if (est) { $('#edit_subject_est').val(est).trigger('change'); } else { $('#edit_subject_est').val('').trigger('change'); }
            if (dept) { $('#edit_subject_dept').val(dept).trigger('change'); } else { $('#edit_subject_dept').val('').trigger('change'); }
            var bs = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
            bs.show();
        });
    })();
</script>
<script>
    // Update role description text for create/edit role selects
    (function(){
        // On page load, set create role description if present
        var createSel = document.getElementById('create_user_role');
        if (createSel) {
            var descEl = document.getElementById('createRoleDesc');
            var selectedDesc = createSel.selectedOptions && createSel.selectedOptions[0] ? createSel.selectedOptions[0].dataset.desc : '';
            if (descEl) descEl.textContent = selectedDesc || '';
            createSel.addEventListener('change', function(e){
                var d = e.target.selectedOptions && e.target.selectedOptions[0] ? e.target.selectedOptions[0].dataset.desc : '';
                if (descEl) descEl.textContent = d || '';
            });
        }

        // For any edit role selects, use delegated change handler
        document.addEventListener('change', function(e){
            var el = e.target;
            if(!el) return;
            if (el.id && el.id.indexOf('edit_role_select_') === 0) {
                var id = el.id.split('_').pop();
                var desc = el.selectedOptions && el.selectedOptions[0] ? el.selectedOptions[0].dataset.desc : '';
                var dest = document.getElementById('editRoleDesc_' + id);
                if (dest) dest.textContent = desc || '';
            }
        });
    })();
</script>