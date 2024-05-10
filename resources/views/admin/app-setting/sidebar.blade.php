<div class="email-leftbar card">
    <div class="mail-list">
        @can('general-setting.list')
            <a href="{{ route('admin.settings.general') }}"
                class="{{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                <i class="ri ri-arrow-right-s-line me-2"></i> General
            </a>
        @endcan
        @can('registration-setting.list')
        <a href="{{ route('admin.settings.registration') }}"
            class="{{ request()->routeIs('admin.settings.registration') ? 'active' : '' }}">
            <i class="ri ri-arrow-right-s-line me-2"></i> Registration
        </a>
        @endcan
    </div>
</div>
{{-- email-leftbar --}}
