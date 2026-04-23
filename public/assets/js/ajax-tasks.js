/* =====================================================
   SmartTrack — AJAX Task Operations
   Uses jQuery + PHP endpoints in /ajax/
   ===================================================== */

$(document).ready(function () {

    /* ── AJAX: Update Task Status (Kanban dropdown) ── */
    $(document).on('change', '.task-status-select', function () {
        const taskId   = $(this).data('task-id');
        const newStatus = $(this).val();
        const $card    = $(this).closest('.task-card');
        const $badge   = $card.find('.status-badge');

        // Show spinner
        $badge.html('<i class="bi bi-arrow-repeat" style="animation:spin .6s linear infinite;"></i>');

        $.ajax({
            url:  BASE_URL + '/ajax/update_task_status.php',
            type: 'POST',
            data: { task_id: taskId, status: newStatus },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    // Update badge
                    const labels = { todo:'To Do', in_progress:'In Progress', done:'Done' };
                    const classes = { todo:'todo', in_progress:'in-progress', done:'completed' };
                    $badge.attr('class', 'status-badge ' + (classes[newStatus]||'todo'));
                    $badge.html(`<span class="status-dot"></span>${labels[newStatus]||newStatus}`);

                    // Strike-through if done
                    if (newStatus === 'done') {
                        $card.find('.task-card-title').css('text-decoration', 'line-through');
                        $card.css('opacity', '0.75');
                    } else {
                        $card.find('.task-card-title').css('text-decoration', '');
                        $card.css('opacity', '1');
                    }

                    Toast.show('Task status updated!', 'success');
                } else {
                    Toast.show(res.message || 'Update failed.', 'error');
                }
            },
            error: function () {
                Toast.show('Server error. Please try again.', 'error');
                $badge.html('<span class="status-dot"></span>Error');
            }
        });
    });

    /* ── AJAX: Delete Task (no page reload) ── */
    $(document).on('click', '.ajax-delete-task', function (e) {
        e.preventDefault();
        const taskId = $(this).data('task-id');
        const $row   = $(this).closest('tr, .task-card');

        if (!confirm('Delete this task? This cannot be undone.')) return;

        $.ajax({
            url:  BASE_URL + '/ajax/delete_task.php',
            type: 'POST',
            data: { task_id: taskId },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $row.css({ transition:'opacity 0.3s,transform 0.3s', opacity:'0', transform:'translateX(20px)' });
                    setTimeout(() => { $row.remove(); Toast.show('Task deleted.', 'success'); }, 300);
                } else {
                    Toast.show(res.message || 'Delete failed.', 'error');
                }
            },
            error: function () { Toast.show('Server error.', 'error'); }
        });
    });

    /* ── AJAX: Delete Project (no page reload) ── */
    $(document).on('click', '.ajax-delete-project', function (e) {
        e.preventDefault();
        const projectId = $(this).data('project-id');
        const $row      = $(this).closest('tr');

        if (!confirm('Delete this project and all its tasks? This cannot be undone.')) return;

        $.ajax({
            url:  BASE_URL + '/ajax/delete_project.php',
            type: 'POST',
            data: { project_id: projectId },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $row.css({ transition:'opacity 0.3s', opacity:'0' });
                    setTimeout(() => { $row.remove(); Toast.show('Project deleted.', 'success'); }, 300);
                } else {
                    Toast.show(res.message || 'Delete failed.', 'error');
                }
            },
            error: function () { Toast.show('Server error.', 'error'); }
        });
    });

});

/* Spin keyframe (for loading indicator) */
const styleEl = document.createElement('style');
styleEl.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
document.head.appendChild(styleEl);
