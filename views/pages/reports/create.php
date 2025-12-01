<?php $title = 'Nouveau rapport - Saisie couverture'; $layout = 'main'; require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card p-5">
        <h2>Saisie d'un rapport hebdomadaire</h2>
        <form method="POST" action="<?php echo url('reports'); ?>">
            <?php echo csrf_field(); ?>
            <div class="row mb-3">
                    <div class="col-md-8">
                    <label class="form-label">Programme (Classe - Matière)</label>
                    <div class="d-flex mb-2">
                        <select name="program_id" id="program_select" class="form-control me-2">
                        <option value="">-- Sélectionner un programme --</option>
                        <?php foreach ($programs as $p): ?>
                            <option value="<?php echo $p['id']; ?>" data-nbr-hours="<?php echo $p['nbr_hours']; ?>" data-nbr-lesson="<?php echo $p['nbr_lesson']; ?>" data-nbr-lesson-dig="<?php echo $p['nbr_lesson_dig']; ?>" data-nbr-tp="<?php echo $p['nbr_tp']; ?>" data-nbr-tp-dig="<?php echo $p['nbr_tp_dig']; ?>"><?php echo htmlspecialchars($p['class_name'] . ' - ' . $p['subject_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-target="#modalProgramCreateSmall" data-bs-toggle="modal">Nouveau programme</button>
                    </div>
                </div>
                    <div class="col-md-4">
                    <label class="form-label">Date (Semaine)</label>
                    <input name="week_start_date" type="date" class="form-control" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Heures prévues</label>
                    <input id="planned_hours" name="planned_hours" type="number" class="form-control" step="0.5" readonly />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Heures couvertes (fait)</label>
                    <input id="nbr_hours_do" name="nbr_hours_do" type="number" class="form-control" step="0.5" />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Leçons prévues</label>
                    <input id="planned_lessons" type="number" class="form-control" readonly />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Leçons faites</label>
                    <input id="nbr_lesson_do" name="nbr_lesson_do" type="number" class="form-control" />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Leçons digitalisées prévues</label>
                    <input id="planned_lessons_dig" type="number" class="form-control" readonly />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Leçons digitalisées faites</label>
                    <input id="nbr_lesson_dig_do" name="nbr_lesson_dig_do" type="number" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">TP prévus</label>
                    <input id="planned_tp" type="number" class="form-control" readonly />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">TP faits</label>
                    <input id="nbr_tp_do" name="nbr_tp_do" type="number" class="form-control" />
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">TP digitalisés faits</label>
                    <input id="nbr_tp_dig_do" name="nbr_tp_dig_do" type="number" class="form-control" />
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-success" type="submit">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<!-- Program create modal (small) -->
<div class="modal fade" id="modalProgramCreateSmall" tabindex="-1" aria-labelledby="modalProgramCreateSmallLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProgramCreateSmallLabel">Nouveau programme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?php echo url('programs'); ?>" id="programCreateFormModal">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="return_to" value="reports/create" />
            <input type="hidden" name="return_to" value="reports/create" />
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                                <label class="form-label">Classe</label>
                                <select name="classe_id" class="form-control">
                                        <?php foreach (\App\Core\Database::query('SELECT id, name FROM classes')->fetchAll(\PDO::FETCH_ASSOC) as $c): ?>
                                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                                        <?php endforeach; ?>
                                </select>
                        </div>
                        <div class="col-md-12 mb-3">
                                <label class="form-label">Matière</label>
                                <select name="subject_id" class="form-control">
                                        <?php foreach (\App\Core\Database::query('SELECT id, name FROM subjects')->fetchAll(\PDO::FETCH_ASSOC) as $s): ?>
                                                <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?></option>
                                        <?php endforeach; ?>
                                </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Heures prévues</label><input type="number" name="nbr_hours" class="form-control" step="1" min="0" value="0"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Leçons</label><input type="number" name="nbr_lesson" class="form-control" step="1" min="0" value="0"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('program_select');
    function updatePlanned() {
        const opt = select.options[select.selectedIndex];
        if (!opt || !opt.dataset) return;
        document.getElementById('planned_hours').value = opt.dataset.nbrHours || '';
        document.getElementById('planned_lessons').value = opt.dataset.nbrLesson || '';
        document.getElementById('planned_lessons_dig').value = opt.dataset.nbrLessonDig || '';
        document.getElementById('planned_tp').value = opt.dataset.nbrTp || '';
    }
    select.addEventListener('change', updatePlanned);
    updatePlanned();
});
</script>
<script>
// Add refresh capability to program select
document.addEventListener('DOMContentLoaded', function(){
    const refreshBtn = document.createElement('button');
    refreshBtn.type = 'button';
    refreshBtn.className = 'btn btn-sm btn-outline-secondary ms-2';
    refreshBtn.textContent = 'Actualiser';
    const programSelect = document.getElementById('program_select');
    if (programSelect && programSelect.parentNode) {
        programSelect.parentNode.appendChild(refreshBtn);
    }
    refreshBtn.addEventListener('click', function(){
        fetch('<?php echo url('programs/list'); ?>').then(r=>r.json()).then(data=>{
            const sel = document.getElementById('program_select');
            if (!sel) return;
            const cur = sel.value;
            sel.innerHTML = '<option value="">-- Sélectionner un programme --</option>';
            data.forEach(function(p){
                const o = document.createElement('option');
                o.value = p.id;
                o.text = (p.class_name || 'Classe') + ' - ' + (p.subject_name || 'Matière');
                o.dataset.nbrHours = p.nbr_hours || 0;
                o.dataset.nbrLesson = p.nbr_lesson || 0;
                o.dataset.nbrLessonDig = p.nbr_lesson_dig || 0;
                o.dataset.nbrTp = p.nbr_tp || 0;
                o.dataset.nbrTpDig = p.nbr_tp_dig || 0;
                sel.appendChild(o);
            });
            // restore previous value if exists
            if (cur) sel.value = cur;
            sel.dispatchEvent(new Event('change'));
        }).catch(err => { console.error(err); alert('Erreur chargement programmes'); });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const programForm = document.getElementById('programCreateFormModal');
    if (!programForm) return;
    programForm.addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(programForm);
        fetch(programForm.action, { method: 'POST', body: formData, headers: {'X-Requested-With': 'XMLHttpRequest'} })
        .then(resp => resp.json())
                    .then(data => {
            if (data.success) {
                // Add to program selects
                const newOpt = document.createElement('option');
                newOpt.value = data.id;
                // Fetch class and subject name via a query or build minimal label
                // We'll query program list via a quick fetch (not implemented here), fallback to id
                newOpt.text = (data.class_name || 'Classe') + ' - ' + (data.subject_name || 'Matière');
                newOpt.dataset.nbrHours = data.nbr_hours || 0;
                newOpt.dataset.nbrLesson = data.nbr_lesson || 0;
                newOpt.dataset.nbrLessonDig = data.nbr_lesson_dig || 0;
                newOpt.dataset.nbrTp = data.nbr_tp || 0;
                newOpt.dataset.nbrTpDig = data.nbr_tp_dig || 0;
                const programSelect = document.getElementById('program_select');
                const programSelectModal = document.getElementById('program_select_modal_create');
                if (programSelect) { programSelect.appendChild(newOpt.cloneNode(true)); programSelect.value = data.id; programSelect.dispatchEvent(new Event('change')); }
                if (programSelectModal) { programSelectModal.appendChild(newOpt.cloneNode(true)); }
                // Hide modal
                const modalEl = document.getElementById('modalProgramCreateSmall');
                const bs = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                bs.hide();
            } else {
                alert(data.error || 'Erreur création programme');
            }
        }).catch(err => {
            console.error(err);
            alert('Erreur réseau lors de la création du programme.');
        });
    });
});
</script>
