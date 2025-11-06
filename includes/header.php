<?php
ob_start();
$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
include_once "models.php"; 

$contact = getContactInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- SEO: Meta Description (Dynamic per page but falls back to default) -->
    <meta name="description" 
          content="<?php echo isset($pageDescription) ? $pageDescription : 'ACK All Saints Maseno Parish is a Christian community dedicated to worship, discipleship, fellowship and service in Maseno, Kenya.'; ?>">

    <!-- SEO: Keywords -->
    <meta name="keywords" content="ACK, All Saints Maseno, Church Maseno, Anglican Church, Christian Fellowship, Worship, Parish">

    <!-- SEO: Canonical URL -->
    <link rel="canonical" href="https://<?php echo $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">

    <!-- Mobile Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title><?php echo isset($pageTitle) ? $pageTitle.' - ACK All Saints Maseno Parish' : "ACK All Saints Maseno Parish"; ?></title>

    <!-- OpenGraph Social Sharing -->
    <meta property="og:title" content="<?php echo isset($pageTitle) ? $pageTitle : 'ACK All Saints Maseno Parish'; ?>">
    <meta property="og:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Welcome to ACK All Saints Maseno Parish'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://<?php echo $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:image" content="https://<?php echo $_SERVER['SERVER_NAME']; ?>/public/images/ack_logo.png">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="public/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="public/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="public/images/favicon-16x16.png">
    <link rel="manifest" href="public/images/site.webmanifest">
    <link rel="icon" type="image/x-icon" href="public/images/favicon.ico">

    <!-- Structured Data (Local Church / Organization) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Church",
      "name": "ACK All Saints Maseno Parish",
      "image": "https://<?php echo $_SERVER['SERVER_NAME']; ?>/public/images/ack_logo.png",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Maseno",
        "addressCountry": "Kenya"
      },
      "telephone": "<?php echo isset($contact['phone']) ? $contact['phone'] : ''; ?>"
    }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="public/css/index.css">

    <!-- Custom Scripts -->
    <script defer src="public/js/index.js"></script>
    <script defer src="public/js/announcements.js"></script>
</head>

<body class="bg-[#ffffff]">

    <!-- Top Contact Bar -->
    <div class="bg-[#D18C7C] text-black py-2 z-[50]">
        <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center px-4 sm:px-6 space-y-1 sm:space-y-0">
            <span class="text-xs sm:text-sm leading-tight"><strong>Location: </strong><?= htmlspecialchars($contact['location']) ?></span>
            <span class="text-xs sm:text-sm leading-tight"><strong>Need Assistance? Contact:</strong> <?= htmlspecialchars($contact['phone']) ?></span>
        </div>
    </div>

    <header class="bg-[#D18C7C]/30 lg:bg-[#D18C7C]/30 lg:backdrop-blur-sm shadow-md relative z-[9999]">

        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo & Title -->
            <div class="flex items-center">
                <img src="public/images/ack_logo.png" alt="Church Logo" class="h-16 lg:h-20 w-auto object-contain">
                <h1 class="text-lg lg:text-xl font-bold text-[#6C8BC9] ml-1">ACK ALL SAINTS MASENO PARISH</h1>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:block">
                <ul class="flex space-x-4 items-center">
                    <li>
                        <a href="?page=home" 
                        class="text-base leading-normal <?= $current_page == 'home' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#6C8BC9]">
                        Home
                        </a>
                    </li>

                    <li class="group relative">
                        <!-- Button -->
                        <button id="about-btn" 
                            class="text-base leading-normal <?= in_array($current_page, ['who-we-are','history','administration','governance','departments','activities']) ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#6C8BC9] focus:outline-none flex items-center gap-1">
                            About
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" 
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <ul id="about-dropdown" 
                            class="absolute left-0 mt-2 hidden w-56 bg-white shadow-lg rounded-lg border border-gray-200 p-2 space-y-1 transition-all duration-300">
                            
                            <li>
                                <a href="?page=who-we-are" 
                                class="block px-4 py-2 text-sm text-black rounded-md hover:bg-[#6C8BC9] hover:text-white transition">
                                Who We Are
                                </a>
                            </li>
                            <li>
                                <a href="?page=history" 
                                class="block px-4 py-2 text-sm text-black rounded-md hover:bg-[#6C8BC9] hover:text-white transition">
                                History
                                </a>
                            </li>
                            <li>
                                <a href="?page=administration" 
                                class="block px-4 py-2 text-sm text-black rounded-md hover:bg-[#6C8BC9] hover:text-white transition">
                                Administration
                                </a>
                            </li>
                            <li>
                                <a href="?page=governance" 
                                class="block px-4 py-2 text-sm text-black rounded-md hover:bg-[#6C8BC9] hover:text-white transition">
                                Governance
                                </a>
                            </li>
                            <li>
                                <a href="?page=departments" 
                                class="block px-4 py-2 text-sm text-black rounded-md hover:bg-[#6C8BC9] hover:text-white transition">
                                Departments
                                </a>
                            </li>
                            <li>
                                <a href="?page=activities" 
                                class="block px-4 py-2 text-sm text-black rounded-md hover:bg-[#6C8BC9] hover:text-white transition">
                                Activities
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="?page=resources" 
                        class="text-base leading-normal <?= $current_page == 'resources' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#6C8BC9]">
                        Resources
                        </a>
                    </li>
                    <li>
                        <a href="?page=get-involved" 
                        class="text-base leading-normal <?= $current_page == 'get-involved' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#6C8BC9]">
                        Get Involved
                        </a>
                    </li>
                    <li>
                        <a href="?page=contact-us" 
                        class="text-base leading-normal <?= $current_page == 'contact-us' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#6C8BC9]">
                        Contact
                        </a>
                    </li>
                    <li>
                        <a href="?page=become-member" 
                        class="text-base leading-normal <?= $current_page == 'become-member' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#6C8BC9]">
                        Join
                        </a>
                    </li>

                    <!-- Admin Login -->
                    <li class="relative flex items-center">
                        <a href="?page=admin-login" class="text-base leading-normal text-black hover:text-[#6C8BC9]">
                            Admin
                        </a>
                        <span class="relative flex ml-1">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#6C8BC9] opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 bg-[#6C8BC9] rounded-full"></span>
                        </span>
                    </li>
                </ul>
            </nav>


            <!-- Mobile Menu Toggle -->
            <button id="menu-toggle" 
                class="lg:hidden flex items-center justify-center 
                    w-12 h-12 rounded-full 
                    bg-gradient-to-r from-[#D18C7C]/20 to-[#6C8BC9]/20 
                    text-[#6C8BC9] shadow-md 
                    transition transform hover:scale-110 hover:shadow-lg active:scale-95 focus:outline-none">

                <!-- Hamburger Icon (kept same ID for JS compatibility) -->
                <svg id="menu-icon" xmlns="http://www.w3.org/2000/svg" 
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                    class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

        </div>

        <!-- Mobile Menu -->
        <nav id="mobile-menu" 
            class="lg:hidden z-[30] fixed top-0 right-0 h-full w-3/4 max-w-sm 
                bg-white text-black shadow-2xl border-l border-gray-200 
                transform translate-x-full transition-transform duration-300 overflow-y-auto">

            <!-- Close Button -->
            <button id="close-icon" 
                class="absolute top-4 left-4 flex items-center justify-center 
                    w-12 h-12 rounded-full 
                    bg-gradient-to-r from-[#D18C7C]/20 to-[#6C8BC9]/20 
                    text-[#6C8BC9] shadow-md 
                    transition transform hover:scale-110 hover:shadow-lg active:scale-95 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Menu Items -->
            <ul class="p-6 space-y-4 mt-24"> <!-- increased from mt-10 to mt-24 -->
                <li>
                    <a href="?page=home" 
                        class="mobile-link2 <?= $current_page == 'home' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#D18C7C]">
                        Home
                    </a>
                </li>
                
                <!-- About Dropdown -->
                <li>
                    <button id="about-toggle" 
                        class="mobile-link2 w-full text-left flex justify-between items-center hover:text-[#6C8BC9] <?= in_array($current_page, ['who-we-are','history','administration','governance','departments','activities']) ? 'text-[#6C8BC9] font-bold' : 'text-black' ?>">
                        About <span>▾</span>
                    </button>
                    <ul id="about-dropdown-mobile" class="mobile-submenu hidden">
                        <li><a href="?page=who-we-are" class="block px-4 py-2 <?= $current_page == 'who-we-are' ? 'bg-[#6C8BC9] text-white' : 'text-black' ?> rounded-md hover:bg-[#6C8BC9] hover:text-white">Who We Are</a></li>
                        <li><a href="?page=history" class="block px-4 py-2 <?= $current_page == 'history' ? 'bg-[#6C8BC9] text-white' : 'text-black' ?> rounded-md hover:bg-[#6C8BC9] hover:text-white">History</a></li>
                        <li><a href="?page=administration" class="block px-4 py-2 <?= $current_page == 'administration' ? 'bg-[#6C8BC9] text-white' : 'text-black' ?> rounded-md hover:bg-[#6C8BC9] hover:text-white">Administration</a></li>
                        <li><a href="?page=governance" class="block px-4 py-2 <?= $current_page == 'governance' ? 'bg-[#6C8BC9] text-white' : 'text-black' ?> rounded-md hover:bg-[#6C8BC9] hover:text-white">Governance</a></li>
                        <li><a href="?page=departments" class="block px-4 py-2 <?= $current_page == 'departments' ? 'bg-[#6C8BC9] text-white' : 'text-black' ?> rounded-md hover:bg-[#6C8BC9] hover:text-white">Departments</a></li>
                        <li><a href="?page=activities" class="block px-4 py-2 <?= $current_page == 'activities' ? 'bg-[#6C8BC9] text-white' : 'text-black' ?> rounded-md hover:bg-[#6C8BC9] hover:text-white">Activities</a></li>
                    </ul>
                </li>

                <li><a href="?page=resources" class="mobile-link2 <?= $current_page == 'resources' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#D18C7C]">Resources</a></li>
                <li><a href="?page=get-involved" class="mobile-link2 <?= $current_page == 'get-involved' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#D18C7C]">Get Involved</a></li>
                <li><a href="?page=contact-us" class="mobile-link2 <?= $current_page == 'contact-us' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#D18C7C]">Contact</a></li>
                <li><a href="?page=become-member" class="mobile-link2 <?= $current_page == 'become-member' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#D18C7C]">Join</a></li>

                <!-- Admin Login -->
                <li class="mobile-link2 relative flex items-center">
                    <a href="?page=admin-login" class="<?= $current_page == 'admin-login' ? 'text-[#6C8BC9] font-bold' : 'text-black' ?> hover:text-[#D18C7C]">Admin</a>
                    <span class="relative flex ml-1">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#6C8BC9] opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 bg-[#6C8BC9] rounded-full"></span>
                    </span>
                </li>
            </ul>
        </nav>




    </header>

</body>
</html>
