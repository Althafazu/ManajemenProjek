@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        {{-- Gantt Chart Area --}}
        <div class="col-12 mb-5">
            <div class="d-flex justify-content-between mb-3 gap-3">
                <a href="{{ route('tasks.create', $aktualPlan->ap_id) }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Buat Task Baru
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" data-view="Day">Harian</button>
                    <button type="button" class="btn btn-outline-primary active" data-view="Week">Mingguan</button>
                    <button type="button" class="btn btn-outline-primary" data-view="Month">Bulanan</button>
                </div>
            </div>
            <div id="gantt"></div>
        </div>

        {{-- Task List Area --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Daftar Task</h6>
                </div>
                <div class="card-body p-0" id="taskList">
                </div>
            </div>
        </div>
    </div>
    
</div>
{{-- Load Frappe Gantt --}}
<script src="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.css">

{{-- Gantt Chart Script --}}
<script> 
const apId = {{ $aktualPlan->ap_id }};

const ganttChart = {
    instance: null,
    tasks: [],

    init() {
        this.setupEventListeners();
        this.fetchData();
    },

    setupEventListeners() {
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
                e.target.classList.add('active');
                this.render(this.tasks, e.target.dataset.view);
            });
        });
    },

    render(tasks, viewMode = 'Week') {
        if (this.instance) document.querySelector('#gantt').innerHTML = '';
        
        this.instance = new Gantt("#gantt", tasks, {
            view_mode: viewMode,
            date_format: "DD-MMM-YYYY",
            readonly: true,
            language: 'id'
        });
    },

    fetchData() {
        fetch(`/ap/data/${apId}`)
            .then(response => response.json())
            .then(tasks => {
                this.tasks = tasks;
                this.render(tasks);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data gantt.');
            });
    },


};
// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (typeof apId !== 'undefined') {
        ganttChart.init(); 
    }
});
</script>

{{-- script taskLists --}}
<script>
const taskList = {
    init() {
        this.fetchTasks();
    },

    formatDate(dateString) {
        if (!dateString) return '-';
        return new Date(dateString).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    },

    renderTaskList(tasks) {
        const taskListHtml = tasks.map(task => `
            <div class="border-bottom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="mb-0">${task.nama_fase}</h6>
                            <small class="text-muted">(PIC: ${task.usr_name})</small>
                        </div>
                        <div class="small text-muted">
                            <div>Plan: ${this.formatDate(task.plan_start)} - ${this.formatDate(task.plan_end)}</div>
                            ${task.actual_start ? 
                                `<div>Actual: ${this.formatDate(task.actual_start)} - ${this.formatDate(task.actual_end) || 'Ongoing'}</div>` 
                                : ''}
                            ${task.keterangan ? `<div class="mt-1">Keterangan: ${task.keterangan}</div>` : ''}
                        </div>
                    </div>
                    <a href="/tasks/${apId}/${task.tsk_id}/edit" 
                       class="btn btn-sm btn-outline-secondary">
                        Edit
                    </a>
                </div>
            </div>
        `).join('');
        
        document.getElementById('taskList').innerHTML = taskListHtml;
    },

    fetchTasks() {
        fetch(`/ap/getAll/${apId}`)
            .then(response => response.json())
            .then(tasks => {
                this.renderTaskList(tasks);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat daftar task.');
            });
    }
};

// Initialize Task List
document.addEventListener('DOMContentLoaded', () => {
    if (typeof apId !== 'undefined') {
        taskList.init();
    }
});
</script>
@endsection