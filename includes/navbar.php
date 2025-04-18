   <style>
        /* Header & Navigation */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: var(--white);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .header-scrolled {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            transition: var(--transition);
        }

        .logo {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            margin-right: 8px;
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 25px;
            position: relative;
        }

        .nav-links a {
            font-weight: 500;
            transition: var(--transition);
            padding: 5px 0;
            display: inline-block;
        }

        .nav-links a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary);
            bottom: 0;
            left: 0;
            transition: var(--transition);
        }

        .nav-links a:hover:after {
            width: 100%;
            color: black;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-icon {
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
            padding: 5px;
        }

        .nav-icon:hover {
            color: var(--primary);
            transform: translateY(-2px);
        }

        .hamburger {
            display: none;
            cursor: pointer;
            font-size: 24px;
            padding: 5px;
        }
   </style>



    <header id="header">
        <div class="container">
            <nav>
                <div class="hamburger">
                    <i class="fas fa-bars"></i>
                </div>
                <a href="#" class="logo"><i class="fas fa-couch logo-icon"></i>Sabali Furnitures</a>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#couches">Couches</a></li>
                    <li><a href="#beds">Beds</a></li>
                    <li><a href="#tables">Tables</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <div class="nav-actions">
                    <a href="#" class="nav-icon"><i class="fas fa-search"></i></a>
                    <a href="panel/login.php" class="nav-icon"><i class="fas fa-user"></i></a>
                    <a href="#" class="nav-icon"><i class="fas fa-shopping-cart"></i></a>
                </div>
            </nav>
        </div>
    </header>



