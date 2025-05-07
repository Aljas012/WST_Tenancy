<!--
=========================================================
* Material Dashboard Dark Edition - v2.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard-dark
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        @yield('title')
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="../assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
    <link href="../assets/css/custom.css" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Poppins&family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            @if($settings && $settings->font =='poppins') font-family: 'Poppins';
            @elseif($settings && $settings->font =='roboto') font-family: 'Roboto';
            @elseif($settings && $settings->font =='lora') font-family: 'Lora';
            @elseif($settings && $settings->font =='opensans') font-family: 'Open Sans';
            @elseif($settings && $settings->font =='tahoma') font-family: 'Tahoma';
            @else font-family: 'Poppins', sans-serif;
            @endif
        }
    </style>
</head>


<body class="dark-edition">
    <div class="wrapper ">
        <div class="sidebar {{ $settings && $settings->layout === 1 ? 'sidebar-right' : 'sidebar-left' }}"
            data-color="{{ $settings->color ?? 'purple' }}"
            data-background-color="black"
            data-image="../assets/img/sidebar-2.jpg">

            <div class="logo">
                <a href="" class="simple-text logo-normal">
                    {{ $tenant->domain }}
                </a>
            </div>
            <div class="sidebar-wrapper">
                @php
                $menuOrder = $settings->menu_order ?? ['dashboard', 'mechanic', 'vehicle', 'maintenance', 'inventory', 'settings'];
                @endphp

                <ul class="nav" id="sidebar-menu">
                    @foreach ($menuOrder as $item)
                    @include('partials.' . $item)
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand" href="javascript:void(0)">@yield('title')</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" id="navbarDropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="text-transform: none; font-size: 13px">
                                        {{ Auth::user()->name }}
                                        <br>
                                        {{ Auth::user()->email }}
                                    </div>

                                    <i class="material-icons" style="font-size: 26px;">person</i>
                                    <p class="d-lg-none d-md-block mb-0">
                                        Account
                                    </p>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" style="margin-right: 2rem; background-color:rgb(40, 50, 75);">
                                    <a id="logoutLink" class="dropdown-item" href="" style="color:rgb(200, 200, 200)!important;">Sign Out </a>

                                    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->

            <!-- CONTENT  -->

            @yield('content')
            <!-- END OF CONTENT  -->


        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="https://unpkg.com/default-passive-events"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Chartist JS -->
    <script src="../assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.js?v=2.1.0"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="../assets/demo/demo.js"></script>

    <script>
        document.getElementById('logoutLink').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Sign Out?',
                icon: 'warning',
                background: '#242830',
                color: '#fff',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                confirmButtonText: 'Yes, log me out!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var savedColor = <?php echo json_encode($settings->color ?? 'default-color'); ?>;

            $().ready(function() {

                $sidebar = $('.sidebar');
                $sidebar_img_container = $sidebar.find('.sidebar-background');
                $full_page = $('.full-page');
                $sidebar_responsive = $('body > .navbar-collapse');

                window_width = $(window).width();

                if (savedColor && savedColor !== 'default-color') {
                    // Apply color to sidebar
                    $('.sidebar').attr('data-color', savedColor);

                    // Apply color to full page background
                    $('.full-page').attr('filter-color', savedColor);

                    // Apply color to responsive sidebar
                    $('body > .navbar-collapse').attr('data-color', savedColor);
                }



                $('.fixed-plugin .active-color span').click(function() {
                    $full_page_background = $('.full-page-background');

                    var new_color = $(this).data('color');

                    $.ajax({
                        url: '/settings/color', // Your endpoint where the color is saved
                        type: 'POST',
                        data: {
                            color: new_color,
                            _token: '{{ csrf_token() }}' // CSRF token for Laravel (if you're using Laravel)
                        },
                        success: function(response) {
                            // Optionally handle the response
                            console.log('Color saved successfully:', response);
                        },
                        error: function(error) {
                            console.log('Error saving color:', error);
                        }
                    });


                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    $('.sidebar').attr('data-color', new_color);
                    $('.full-page').attr('filter-color', new_color);
                    $('body > .navbar-collapse').attr('data-color', new_color);
                });



                $('.fixed-plugin a').click(function(event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });


                $('.fixed-plugin .background-color .badge').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });




                $('.fixed-plugin .img-holder').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });

                $('.switch-sidebar-image input').change(function() {
                    $full_page_background = $('.full-page-background');

                    $input = $(this);

                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                    }
                });

                $('.switch-sidebar-mini input').change(function() {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fontBadges = document.querySelectorAll('.active-font .badge');

            fontBadges.forEach(function(badge) {
                badge.addEventListener('click', function() {
                    const selectedFont = this.getAttribute('data-font');

                    $.ajax({
                        url: '/settings/font',
                        type: 'POST',
                        data: {
                            font: selectedFont,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Font saved successfully:', response);

                            $('.active-font .badge').removeClass('active');
                            $(badge).addClass('active');

                            document.body.style.fontFamily = selectedFont === 'poppins' ? "'Poppins', sans-serif" :
                                selectedFont === 'roboto' ? "'Roboto', sans-serif" :
                                selectedFont === 'lora' ? "'Lora', serif" :
                                selectedFont === 'opensans' ? "'Open Sans', sans-serif" :
                                selectedFont === 'tahoma' ? "'Tahoma', sans-serif" : '';
                        },
                        error: function(error) {
                            console.log('Error saving font:', error);
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const layoutBadges = document.querySelectorAll('.active-layout .badge');

            layoutBadges.forEach(function(badge) {
                badge.addEventListener('click', function() {
                    const selectedLayout = this.getAttribute('data-layout'); // Get the selected layout value

                    $.ajax({
                        url: '/settings/layout',
                        type: 'POST',
                        data: {
                            layout: selectedLayout,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Layout saved successfully:', response);

                            // Update the active state of badges
                            $('.active-layout .badge').removeClass('active');
                            $(badge).addClass('active');

                            // Toggle the sidebar layout without page reload
                            if (selectedLayout === 'left-sidebar') {
                                // Remove the right sidebar class and apply left sidebar
                                document.body.classList.remove('right-sidebar');
                                document.body.classList.add('left-sidebar');

                                // Adjust the main panel's margin for the left sidebar
                                document.querySelector('.main-panel').style.marginLeft = '260px';
                                document.querySelector('.main-panel').style.marginRight = '0';
                            } else if (selectedLayout === 'right-sidebar') {
                                // Remove the left sidebar class and apply right sidebar
                                document.body.classList.remove('left-sidebar');
                                document.body.classList.add('right-sidebar');

                                // Adjust the main panel's margin for the right sidebar
                                document.querySelector('.main-panel').style.marginLeft = '0';
                                document.querySelector('.main-panel').style.marginRight = '260px';
                            }

                            // Show SweetAlert2 confirmation
                            Swal.fire({
                                title: 'Layout Changed!',
                                text: 'Click OK to reload the page.',
                                icon: 'success',
                                background: '#242830',
                                color: '#fff',
                                showConfirmButton: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reload the page after the user clicks OK
                                    location.reload();
                                }
                            });
                        },
                        error: function(error) {
                            console.log('Error saving layout:', error);
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Sortable(document.getElementById('sidebar-menu'), {
                animation: 100,
                ghostClass: 'sortable-ghost',
                onEnd: function(evt) {
                    const order = [...document.querySelectorAll('#sidebar-menu .nav-item')].map(item => item.dataset.id);

                    $.ajax({
                        url: '/settings/menuItem',
                        type: 'POST',
                        data: {
                            order: order,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Order saved:', response);
                        },
                        error: function(xhr) {
                            console.error('Error saving order:', xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();

        });
    </script>
</body>

</html>