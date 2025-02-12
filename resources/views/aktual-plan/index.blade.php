@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        {{-- Gantt Chart Area --}}
        <div class="col-lg-9">
            <div class="d-flex justify-content-end mb-3 gap-3">
                <a href="{{ route('aktual-plan.create', ['id' => $aktualPlan->ap_id]) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Task
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" data-view="Day">Harian</button>
                    <button type="button" class="btn btn-outline-primary" data-view="Week">Mingguan</button>
                    <button type="button" class="btn btn-outline-primary" data-view="Month">Bulanan</button>
                </div>
            </div>

            <div id="gantt"></div>
        </div>

        {{-- Task Details Sidebar --}}
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detail Task</h5>
                </div>
                <div class="card-body">
                    {{-- Initial State Message --}}
                    <div id="initialMessage" class="text-center text-muted py-3">
                        Pilih task untuk melihat detail
                    </div>

                    {{-- Task Form - Hidden initially --}}
                    <form id="taskForm" style="display: none;">
                        <input type="hidden" id="taskId">
                        
                        {{-- Plan Dates (Read-only) --}}
                        <div class="alert alert-danger mb-3" id="planAlert" style="display: none;">
                            Plan tidak bisa diedit!
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Plan Start Date</label>
                            <input type="date" class="form-control" id="planStart" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Plan End Date</label>
                            <input type="date" class="form-control" id="planEnd" disabled>
                        </div>

                        <hr>

                        {{-- Actual Dates (Editable) --}}
                        <div class="alert alert-info mb-3">
                            Anda dapat mengubah actual date dan progress
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Actual Start Date</label>
                            <input type="date" class="form-control" id="actualStart">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Actual End Date</label>
                            <input type="date" class="form-control" id="actualEnd">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Progress (%)</label>
                            <input type="number" class="form-control" id="progress" min="0" max="100">
                        </div>

                        <button type="button" class="btn btn-primary w-100" id="saveButton">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Load Frappe Gantt --}}
<script src="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.css">

<script>
document.addEventListener("DOMContentLoaded", function () {
    let gantt = null;
    let currentTasks = [];

    // Initialize Gantt Chart
    function initGantt(tasks, viewMode="Week") {
        if (gantt) document.querySelector('#gantt').innerHTML = '';
        
        gantt = new Gantt("#gantt", tasks, {
            view_mode: viewMode,
            date_format: "DD-MMM-YYYY",
            readonly: true,
            language: 'id',
            on_click: loadTaskDetails
        });
    }

    // Load task details into sidebar
    function loadTaskDetails(task) {
        // Hide initial message and show form
        document.getElementById('initialMessage').style.display = 'none';
        document.getElementById('taskForm').style.display = 'block';
        
        // Populate form fields
        document.getElementById('taskId').value = task.id;
        document.getElementById('planStart').value = formatDate(task.start);
        document.getElementById('planEnd').value = formatDate(task.end);
        document.getElementById('actualStart').value = task.actualStart || '';
        document.getElementById('actualEnd').value = task.actualEnd || '';
        document.getElementById('progress').value = task.progress || 0;
    }

    // Helper function to format date for input
    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }

    // Save button handler
    document.getElementById('saveButton').addEventListener('click', function() {
        const taskId = document.getElementById('taskId').value;
        const formData = {
            actualStartDate: document.getElementById('actualStart').value,
            actualEndDate: document.getElementById('actualEnd').value,
            progress: document.getElementById('progress').value
        };

        // Send update to server
        fetch(`/gantt/update-actual/${taskId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update local data
                currentTasks = currentTasks.map(task => {
                    if (task.id === taskId) {
                        return {
                            ...task,
                            actualStart: formData.actualStartDate,
                            actualEnd: formData.actualEndDate,
                            progress: parseInt(formData.progress)
                        };
                    }
                    return task;
                });

                // Refresh chart
                const currentView = document.querySelector('.btn-group .btn.active')?.dataset.view || 'Week';
                initGantt(currentTasks, currentView);
                
                alert('Data berhasil disimpan!');
            } else {
                alert('Gagal menyimpan data!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data.');
        });
    });

    // View mode buttons handler
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            initGantt(currentTasks, this.dataset.view);
        });
    });

    // Load initial data
    fetch(`/gantt/data/{{ $aktualPlan->ap_id }}`)
        .then(response => response.json())
        .then(tasks => {
            currentTasks = tasks;
            initGantt(tasks);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data Gantt Chart.');
        });
});
</script>
@endsection