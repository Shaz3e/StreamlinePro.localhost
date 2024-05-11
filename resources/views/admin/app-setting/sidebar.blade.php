<div class="email-leftbar card">
    <div class="mail-list">
        @can('general-setting.list')
            <a href="{{ route('admin.settings.general') }}"
                class="{{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                <i class="ri ri-arrow-right-s-line me-2"></i> General
            </a>
        @endcan
        @can('authentication-setting.list')
        <a href="{{ route('admin.settings.authentication') }}"
            class="{{ request()->routeIs('admin.settings.authentication') ? 'active' : '' }}">
            <i class="ri ri-arrow-right-s-line me-2"></i> Authentication
        </a>
        @endcan
    </div>
</div>
{{-- email-leftbar --}}
