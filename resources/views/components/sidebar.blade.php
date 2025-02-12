<div class="d-flex">
    <!-- Sidebar untuk layar besar -->
    <div class="bg-light border-end vh-100 p-3 d-none d-xl-block" style="width: 250px;">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard') ? 'background-color: #0059AB; color: white;' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('gamteks.index') }}" 
                    class="nav-link {{ request()->routeIs('gamteks.*') ? 'active' : '' }}" 
                    style="{{ request()->routeIs('gamteks.*') ? 'background-color: #0059AB; color: white;' : '' }}">
                    <i class="bi bi-file-earmark-image"></i> Gambar Teknik
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('qcs.index') }}" 
                class="nav-link {{ request()->routeIs('qcs.*') ? 'active' : '' }}" 
                style="{{ request()->routeIs('qcs.*') ? 'background-color: #0059AB; color: white;' : '' }}">
                    <i class="bi bi-check2-square"></i> Quality Checksheet
                </a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('datatrials.index') }}" 
                class="nav-link {{ request()->routeIs('datatrials.*') ? 'active' : '' }}" 
                style="{{ request()->routeIs('datatrials.*') ? 'background-color: #0059AB; color: white;' : '' }}">
                <i class="bi bi-database"></i> Data Trial
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}" style="{{ request()->routeIs('projects.index') ? 'background-color: #0059AB; color: white;' : '' }}">
                    <i class="bi bi-folder"></i> Detail Proyek (SPK)
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('actual_plan.index') }}" class="nav-link {{ request()->routeIs('actual_plan.index') ? 'active' : '' }}" style="{{ request()->routeIs('actual_plan.index') ? 'background-color: #0059AB; color: white;' : '' }}">
                    <i class="bi bi-calendar-check"></i> Actual Plan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bom.index') }}" class="nav-link {{ request()->routeIs('bom.index') ? 'active' : '' }}" style="{{ request()->routeIs('bom.index') ? 'background-color: #0059AB; color: white;' : '' }}">
                    <i class="bi bi-list"></i> BOM & BOT
                </a>
            </li>
           
            <li class="nav-item">
                <a href="{{ route('picas.index') }}" 
                class="nav-link {{ request()->routeIs('picas.*') ? 'active' : '' }}" 
                style="{{ request()->routeIs('picas.*') ? 'background-color: #0059AB; color: white;' : '' }}">
                <i class="bi bi-exclamation-triangle"></i> PICA
                </a>
            </li>--}}
            {{-- <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>  --}}
        </ul>
    </div>

    <!-- Sidebar Offcanvas (untuk layar kecil) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
        <div class="offcanvas-header" style="background-color: #0059AB; font-weight: bold;">
            <h5 class="offcanvas-title" style="color: #ffffff;">Menu</h5>
            <button type="button" class="btn" data-bs-dismiss="offcanvas">
                <i class="bi bi-arrow-left text-white"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard') ? 'background-color: #0059AB; color: white;' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('gamteks.index') }}" 
                    class="nav-link {{ request()->routeIs('gamteks.*') ? 'active' : '' }}" 
                    style="{{ request()->routeIs('gamteks.*') ? 'background-color: #0059AB; color: white;' : '' }}">
                    <i class="bi bi-file-earmark-image"></i> Gambar Teknik
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('qcs.index') }}" 
                class="nav-link {{ request()->routeIs('qcs.*') ? 'active' : '' }}" 
                style="{{ request()->routeIs('qcs.*') ? 'background-color: #0059AB; color: white;' : '' }}">
                <i class="bi bi-check2-square"></i> Quality Checksheet
            </a>
        </li> 
        <li class="nav-item">
            <a href="{{ route('datatrials.index') }}" 
            class="nav-link {{ request()->routeIs('datatrials.*') ? 'active' : '' }}" 
            style="{{ request()->routeIs('datatrials.*') ? 'background-color: #0059AB; color: white;' : '' }}">
            <i class="bi bi-database"></i> Data Trial
         </a>
        </li>
            {{-- <li class="nav-item">
                    <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}" style="{{ request()->routeIs('projects.index') ? 'background-color: #0059AB; color: white;' : '' }}">
                        <i class="bi bi-folder"></i> Detail Proyek (SPK)
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('actual_plan.index') }}" class="nav-link {{ request()->routeIs('actual_plan.index') ? 'active' : '' }}" style="{{ request()->routeIs('actual_plan.index') ? 'background-color: #0059AB; color: white;' : '' }}">
                        <i class="bi bi-calendar-check"></i> Actual Plan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('bom.index') }}" class="nav-link {{ request()->routeIs('bom.index') ? 'active' : '' }}" style="{{ request()->routeIs('bom.index') ? 'background-color: #0059AB; color: white;' : '' }}">
                        <i class="bi bi-list"></i> BOM & BOT
                    </a>
                </li>
               
                <li class="nav-item">
                    <a href="{{ route('picas.index') }}" 
                    class="nav-link {{ request()->routeIs('picas.*') ? 'active' : '' }}" 
                    style="{{ request()->routeIs('picas.*') ? 'background-color: #0059AB; color: white;' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i> PICA
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
