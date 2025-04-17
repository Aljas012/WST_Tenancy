<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tenant->domain }}</title>
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
        <main>
            <section class="hero ">
                <div class="container" style="height: 30rem; padding-top:3rem">
                    <div class="hero-inner ">
                        <div class="hero-copy">
                            <h1 class="hero-title mt-0">Welcome, <br>{{$tenant->business}}</h1>
                            <p class="hero-paragraph" style="text-align: justify;">Tenant ID: {{ $tenant->id }}</p>

                            <div class="hero-cta">
                                <a class="button button-primary" href="" id="signUpButton">Sign Up</a>
                                <a class="button" style="border: 2px solid rgb(80, 161, 243); color:rgb(210, 232, 255)!important" href="" id="signInButton">Sign In</a>
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

            <section class="developer section">
                <div class="container">
                    <div class="features-inner section-inner has-bottom-divider">
                        <div class="text-center">
                            <h2 class="section-title mt-0">SmartCrew Devs!</h2>
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
    </div>

    <script src="dist/js/main.min.js"></script>

    <script>
        var tenantStoreRoute = "{{ route('tenant_app.store') }}";
        var signInRoute = "{{ route('tenant_login') }}";

        var heroCopy = document.querySelector('.hero-copy');
        var originalHeroContent = heroCopy.innerHTML;

        // Function to create and show the form (signup or signin)
        function buildForm(type) {
            var form = document.createElement('form');
            form.classList.add('tenant-form');
            form.method = 'POST';
            form.action = (type === 'signup') ? tenantStoreRoute : signInRoute;

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;

            form.appendChild(csrfInput);

            var heading = document.createElement('h4');
            heading.textContent = type === 'signup' ? 'Sign Up' : 'Sign In';
            heading.style.marginTop = '0';
            form.appendChild(heading);


            // Shared inputs for both sign-up and sign-in forms
            var emailInput = document.createElement('input');
            emailInput.type = 'email';
            emailInput.className = 'form-control';
            emailInput.placeholder = 'Email Address';
            emailInput.name = 'email';
            emailInput.required = true;
            form.appendChild(emailInput);

            var passwordInput = document.createElement('input');
            passwordInput.type = 'password';
            passwordInput.className = 'form-control';
            passwordInput.placeholder = 'Password';
            passwordInput.name = 'password';
            passwordInput.required = true;
            form.appendChild(passwordInput);

            // Only for Sign Up
            if (type === 'signup') {
                var fullNameInput = document.createElement('input');
                fullNameInput.type = 'text';
                fullNameInput.className = 'form-control';
                fullNameInput.placeholder = 'Full Name';
                fullNameInput.name = 'name';
                fullNameInput.required = true;
                fullNameInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^a-zA-Z\s.]/g, '');
                });

                var confirmPasswordInput = document.createElement('input');
                confirmPasswordInput.type = 'password';
                confirmPasswordInput.className = 'form-control';
                confirmPasswordInput.placeholder = 'Confirm Password';
                confirmPasswordInput.name = 'password_confirmation';
                confirmPasswordInput.required = true;

                // Add these fields before the email
                form.insertBefore(fullNameInput, emailInput);
                form.appendChild(confirmPasswordInput);
            }

            var submitButton = document.createElement('button');
            submitButton.className = 'button button-primary';
            submitButton.type = 'submit';
            submitButton.textContent = type === 'signup' ? 'Sign Up' : 'Sign In';

            form.appendChild(submitButton);

            form.addEventListener('submit', function() {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="loading-spinner"></span> Submitting...';
            });

            heroCopy.innerHTML = '';
            heroCopy.appendChild(form);
        }




        document.addEventListener('click', function(event) {
            var form = document.querySelector('.tenant-form');
            if (form && !form.contains(event.target) && !event.target.matches('#signUpButton, #signInButton')) {
                heroCopy.innerHTML = originalHeroContent;
                attachEventListeners();
            }
        });

        function attachEventListeners() {
            document.getElementById('signUpButton').addEventListener('click', function(e) {
                e.preventDefault();
                buildForm('signup');
            });

            document.getElementById('signInButton').addEventListener('click', function(e) {
                e.preventDefault();
                buildForm('signin');
            });
        }

        attachEventListeners();
    </script>

</body>

</html>