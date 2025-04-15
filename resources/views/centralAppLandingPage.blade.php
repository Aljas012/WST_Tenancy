<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>A.P.S_ONE</title>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="dist/css/customStyle.css">
    <script src="https://unpkg.com/animejs@3.0.1/lib/anime.min.js"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="is-boxed has-animations">

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            showConfirmButton: true,
            timer: 3000,
            background: '#242830',
            color: '#fff',

        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: "{{ $errors->first() }}", // Show the first error message
            showConfirmButton: true,
            timer: 3000,
            background: '#242830',
            color: '#fff',
        });
    </script>
    @endif

    <div class="body-wrap">
        <header class="site-header">
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">
                        <h1 class="m-0">
                            <a href="{{ route('login') }}">
                                <img class="header-logo-image" src="dist/images/logo.svg" alt="Logo">
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="container">
                    <div class="hero-inner">
                        <div class="hero-copy">
                            <h1 class="hero-title mt-0">Auto Parts <br>One Digital Garage</h1>
                            <p class="hero-paragraph" style="text-align: justify;">
                                A.P.S_ONE is a cloud-based platform that empowers mechanics by tracking incentives and ensuring timely rewards.
                            </p>

                            <div class="hero-cta">
                                <a class="button button-primary" href="" id="tenantButton">Apply Now!</a>
                            </div>
                        </div>
                        <div class="hero-figure anime-element">
                            <svg class="placeholder" width="528" height="396" viewBox="0 0 528 396">
                                <rect width="528" height="396" style="fill:transparent;" />
                            </svg>
                            <div class="hero-figure-box hero-figure-box-01" data-rotation="45deg"></div>
                            <div class="hero-figure-box hero-figure-box-02" data-rotation="-45deg"></div>
                            <div class="hero-figure-box hero-figure-box-03" data-rotation="0deg"></div>
                            <div class="hero-figure-box hero-figure-box-04" data-rotation="-135deg"></div>
                            <div class="hero-figure-box hero-figure-box-05"></div>
                            <div class="hero-figure-box hero-figure-box-06"></div>
                            <div class="hero-figure-box hero-figure-box-07"></div>
                            <div class="hero-figure-box hero-figure-box-08" data-rotation="-22deg"></div>
                            <div class="hero-figure-box hero-figure-box-09" data-rotation="-52deg"></div>
                            <div class="hero-figure-box hero-figure-box-10" data-rotation="-50deg"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="features section">
                <div class="container">
                    <div class="features-inner section-inner has-bottom-divider">
                        <div class="features-wrap">
                            <div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <img src="dist/images/feature-icon-01.svg" alt="Feature 01">
                                    </div>
                                    <h4 class="feature-title mt-24">Incentives Analytic</h4>
                                    <p class="text-sm mb-0">Track and analyze mechanics' incentives to ensure fair, timely rewards, optimize growth, and boost performance.</p>
                                </div>
                            </div>
                            <div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <img src="dist/images/feature-icon-02.svg" alt="Feature 02">
                                    </div>
                                    <h4 class="feature-title mt-24">Salary Computation</h4>
                                    <p class="text-sm mb-0">Accurately calculate and manage mechanics' salaries, ensuring timely and correct payments based on performance and incentives.</p>
                                </div>
                            </div>
                            <div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <img src="dist/images/feature-icon-03.svg" alt="Feature 03">
                                    </div>
                                    <h4 class="feature-title mt-24">Report Generation</h4>
                                    <p class="text-sm mb-0">Easily generate detailed reports on mechanics' performance, incentives, and salary, helping you make data-driven decisions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pricing section">
                <div class="container-sm  has-bottom-divider">
                    <div class="pricing-inner section-inner ">
                        <div class="pricing-header text-center">
                            <h2 class="section-title mt-0">Our Service!</h2>

                            <p class="section-paragraph mb-0">
                                A.P.S_ONE enhances mechanics' earnings by accurately tracking incentives and ensuring timely rewards, all while providing a seamless experience.
                            </p>
                        </div>
                        <div class="pricing-tables-wrap">
                            <div class="pricing-table">
                                <div class="pricing-table-inner is-revealing">
                                    <div class="pricing-table-main">
                                        <div class="pricing-table-header pb-24">
                                            <div class="pricing-table-price pb-24">
                                                <span class="pricing-table-price-currency h2">₱</span>
                                                <span class="pricing-table-price-amount h1">999</span>
                                                <span class="text-xs">/month</span>
                                                <div class="pricing-table-message text-xs">
                                                    <span>Fixed Price</span>
                                                </div>
                                            </div>

                                            <div class="pricing-table-price">
                                                <span class="pricing-table-price-currency h2">₱</span>
                                                <span class="pricing-table-price-amount h1">8,391.60</span>
                                                <span class="text-xs">/year</span>
                                                <div class="pricing-table-price-discount text-xs">
                                                    <span><s>₱11,988</s> <span class="discount-text">(30% off)</span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pricing-table-features-title text-xs pt-24 pb-24">What you will get</div>
                                        <ul class="pricing-table-features list-reset text-xs">
                                            <li>
                                                <span>Incentives Analytic</span>
                                            </li>
                                            <li>
                                                <span>Salary Computation</span>
                                            </li>
                                            <li>
                                                <span>Report Generation</span>
                                            </li>
                                            <li>
                                                <span>UI Customization</span>
                                            </li>
                                            <li>
                                                <span>Customer Support</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pricing-table-cta mb-8">
                                        <a class="button button-primary button-shadow button-block" href="#">Apply Now!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="developer section">
                <div class="container">
                    <div class="features-inner section-inner has-bottom-divider">
                        <div class="text-center">
                            <h2 class="section-title mt-0">SmartCrew Developer!</h2>
                        </div>

                        <div class="features-wrap">
                            <div>
                                <div class="feature text-center is-revealing">
                                    <div class="feature-inner">
                                        <div class="feature-icon">
                                            <img class="rounded-img" src="dist/images/dawgs.jpg" alt="dev">
                                        </div>
                                        <h4 class="feature-title mt-24">Davy Jones Locker Mercado</h4>
                                        <p class="text-sm mb-0">UI/UX Designer</p>
                                    </div>
                                </div>

                                <div class="feature text-center is-revealing">
                                    <div class="feature-inner">
                                        <div class="feature-icon">
                                            <img class="rounded-img" src="dist/images/dawgs.jpg" alt="dev">
                                        </div>
                                        <h4 class="feature-title mt-24">John Symaiah Dagooc</h4>
                                        <p class="text-sm mb-0">AI Trainer / Documentary</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="feature text-center is-revealing">
                                    <div class="feature-inner">
                                        <div class="feature-icon">
                                            <img class="rounded-img" src="dist/images/mart.jpg" alt="dev">
                                        </div>
                                        <h4 class="feature-title mt-24">Mart Ervin Dahao</h4>
                                        <p class="text-sm mb-0">Full Stack</p>
                                    </div>
                                </div>

                                <div class="feature text-center is-revealing">
                                    <div class="feature-inner">
                                        <div class="feature-icon">
                                            <img class="rounded-img" src="dist/images/gerome.jpg" alt="dev">
                                        </div>
                                        <h4 class="feature-title mt-24">Gerome Aljas</h4>
                                        <p class="text-sm mb-0">Web Frontend</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="site-footer-inner">
                    <div class="brand footer-brand">
                        <a href="#">
                            <img class="header-logo-image" src="dist/images/logo.svg" alt="Logo">
                        </a>
                    </div>
                    <ul class="footer-links list-reset">
                        <li>
                            <a href="#">Contact</a>
                        </li>
                        <li>
                            <a href="#">About us</a>
                        </li>
                        <li>
                            <a href="#">FAQ's</a>
                        </li>
                        <li>
                            <a href="#">Support</a>
                        </li>
                    </ul>
                    <ul class="footer-social-links list-reset">
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Facebook</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.023 16L6 9H3V6h3V4c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V6H13l-1 3H9.28v7H6.023z" fill="#0270D7" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Twitter</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 3c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4C.7 7.7 1.8 9 3.3 9.3c-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H0c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4C15 4.3 15.6 3.7 16 3z" fill="#0270D7" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Google</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.9 7v2.4H12c-.2 1-1.2 3-4 3-2.4 0-4.3-2-4.3-4.4 0-2.4 2-4.4 4.3-4.4 1.4 0 2.3.6 2.8 1.1l1.9-1.8C11.5 1.7 9.9 1 8 1 4.1 1 1 4.1 1 8s3.1 7 7 7c4 0 6.7-2.8 6.7-6.8 0-.5 0-.8-.1-1.2H7.9z" fill="#0270D7" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <div class="footer-copyright">&copy; 2019 Solid, all rights reserved</div>
                </div>
            </div>
        </footer>
    </div>

    <script src="dist/js/main.min.js"></script>

    <script>
        window.routes = {
            tenantApplicationStore: "{{ route('tenant_application.store') }}"
        };
    </script>
    <script src="dist/js/applyForm.js"></script>
</body>

</html>