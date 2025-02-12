@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        {{-- Gantt Chart Area --}}
        <div class="col-12">
            <div class="d-flex justify-content-between mb-3 gap-3">
                <a href="{{ route('tasks.create', $aktualPlan->ap_id) }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Buat Task Baru
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" data-view="Day">Harian</button>
                    <button type="button" class="btn btn-outline-primary" data-view="Week">Mingguan</button>
                    <button type="button" class="btn btn-outline-primary" data-view="Month">Bulanan</button>
                </div>
            </div>
            <div id="gantt"></div>
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
            language: 'id'
        });
    }

    // View mode buttons handler
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            initGantt(currentTasks, this.dataset.view);
        });
    });

    // Load initial data
    fetch(`/ap/data/{{ $aktualPlan->ap_id }}`)
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
