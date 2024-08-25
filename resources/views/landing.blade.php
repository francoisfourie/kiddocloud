<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiddoCloud - Nursery Management SaaS</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <nav>
            <div class="logo">KiddoCloud</div>
            <ul>
                <li><a href="#features">Features</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#register">Register</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="hero">
            <h1>Simplify Your Nursery Management</h1>
            <p>KiddoCloud: The all-in-one solution for efficient nursery operations</p>
            <a href="#register" class="cta-button">Get Started</a>
        </section>

        <section id="features">
            <h2>Features</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <h3>Attendance Tracking</h3>
                    <p>Easily manage and track children's attendance with our intuitive system.</p>
                </div>
                <div class="feature-item">
                    <h3>Parent Communication</h3>
                    <p>Stay connected with parents through our integrated messaging platform.</p>
                </div>
                <div class="feature-item">
                    <h3>Activity Planning</h3>
                    <p>Plan and organize daily activities for children with our user-friendly tools.</p>
                </div>
                <div class="feature-item">
                    <h3>Financial Management</h3>
                    <p>Streamline billing and payment processes for hassle-free operations.</p>
                </div>
            </div>
        </section>

        <section id="about">
            <h2>About KiddoCloud</h2>
            <p>KiddoCloud is a comprehensive nursery management system designed to simplify the day-to-day operations of childcare centers. Our platform offers a range of tools to help nursery managers, staff, and parents collaborate effectively, ensuring the best care for children.</p>
        </section>

        <section id="register">
            <h2>Register for KiddoCloud</h2>
            <form id="registration-form">
                @csrf
                <input type="text" name="nursery_name" placeholder="Nursery Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                <button type="submit">Sign Up</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 KiddoCloud. All rights reserved.</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>