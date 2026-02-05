<aside class="left-sidebar with-vertical">
    <div>
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./main/index.html" class="text-nowrap logo-img">
                <img src="{{asset('assets/backend/images/logos/dark-logo.svg')}}" class="dark-logo" alt="Logo-Dark" />
                <img src="{{asset('assets/backend/images/logos/light-logo.svg')}}" class="light-logo"
                    alt="Logo-light" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <!-- ---------------------------------- -->
                <!-- Home -->
                <!-- ---------------------------------- -->
                 <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('backend.dashboard.index')}}" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <defs>
                                <path id="solarHomeBoldDuotone0"
                                    d="M10.75 9.5a1.25 1.25 0 1 1 2.5 0a1.25 1.25 0 0 1-2.5 0" />
                            </defs>
                            <path fill="currentColor" fill-rule="evenodd"
                                d="m21.532 11.586l-.782-.626v10.29H22a.75.75 0 0 1 0 1.5H2a.75.75 0 1 1 0-1.5h1.25V10.96l-.781.626a.75.75 0 1 1-.937-1.172l8.125-6.5a3.75 3.75 0 0 1 4.686 0l8.125 6.5a.75.75 0 1 1-.936 1.172M12 6.75a2.75 2.75 0 1 0 0 5.5a2.75 2.75 0 0 0 0-5.5m1.746 6.562c-.459-.062-1.032-.062-1.697-.062h-.098c-.665 0-1.238 0-1.697.062c-.491.066-.963.215-1.345.597s-.531.854-.597 1.345c-.062.459-.062 1.032-.062 1.697v4.299h7.5v-4.423c0-.612-.004-1.143-.062-1.573c-.066-.491-.215-.963-.597-1.345s-.853-.531-1.345-.597"
                                clip-rule="evenodd" />
                            <g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" opacity="0.5">
                                <use href="#solarHomeBoldDuotone0" />
                                <use href="#solarHomeBoldDuotone0" />
                            </g>
                            <path fill="currentColor"
                                d="M12.05 13.25c.664 0 1.237 0 1.696.062c.492.066.963.215 1.345.597s.531.853.597 1.345c.058.43.062.96.062 1.573v4.423h-7.5v-4.3c0-.664 0-1.237.062-1.696c.066-.492.215-.963.597-1.345s.854-.531 1.345-.597c.459-.062 1.032-.062 1.697-.062zM16 3h2.5a.5.5 0 0 1 .5.5v4.14l-3.5-2.8V3.5A.5.5 0 0 1 16 3"
                                opacity="0.5" />
                          </svg>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>
                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->
                <li class="sidebar-item">
    <a class="sidebar-link" href="{{ route('backend.users.index')}}" aria-expanded="false">
        <span>
            <i class="ti ti-user"></i>
        </span>
        <span class="hide-menu">User</span> 
    </a>
</li>

            </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="{{asset('assets/backend/images/profile/user-1.jpg')}}" class="rounded-circle" width="40"
                        height="40" alt="modernize-img" />
                </div>
                <div class="john-title">
                    <h6 class="mb-0 fs-4 fw-semibold">{{Auth::user()->name}}</h6>
                    <span class="fs-2">{{Auth::user()->isAdmin == 1 ? 'admin': ''}}</span>
                </div>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                    <i class="ti ti-power fs-6"></i>
                </a>

                <form action="{{ route('logout') }}" method="post" id="logout-form">
                    @csrf
                </form>

            </div>
        </div>

        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
    </div>
</aside>