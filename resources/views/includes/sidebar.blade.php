<!-- Sidebar -->
<div class="sidebar sidebar-style-3">
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-primary">
                    <li class="nav-item active">
                        <a href="/">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>{{ __('sidebar.Home') }}</p>
                        </a>
                    </li>

                    @if ( $AuthUserType === 'consultant')
                    <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
                        <h4 class="text-section">{{ trans('sidebar.Create') }}</h4>
                    </li>
                    <li class="nav-item">
                        <a href="/habit-builder-wizard">
                            <i class="fas fa-plus"></i>
                            <p>{{ trans('sidebar.Create New Habit Builder') }}</p>
                        </a>
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
<!-- End Sidebar -->
