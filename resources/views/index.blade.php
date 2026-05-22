<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodDetect - IoT Food Contamination Detection System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        outfit: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        brandGreen: '#8DC63F',
                        brandGreenHover: '#7CB532',
                        brandDark: '#0D0E12',
                        brandGray: '#7E8B9B',
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, rgba(13, 14, 18, 0.95) 0%, rgba(26, 28, 35, 0.98) 100%);
        }
        .hero-pattern {
            background-image: radial-gradient(rgba(141, 198, 63, 0.15) 1px, transparent 0);
            background-size: 24px 24px;
        }
        .glass-nav {
            background: rgba(13, 14, 18, 0.75);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(141, 198, 63, 0.1);
        }
        .glow-green:hover {
            box-shadow: 0 10px 30px -10px rgba(141, 198, 63, 0.4);
        }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased bg-[#F8F9FB] overflow-x-hidden">

    <!-- Top Floating Navbar (Glassmorphism) -->
    <header class="fixed top-0 left-0 right-0 z-50 glass-nav transition duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 rounded-full bg-brandGreen flex items-center justify-center font-bold text-white text-base font-outfit shadow-md shadow-brandGreen/25 group-hover:scale-105 transition duration-300">
                    Fd
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight font-outfit leading-tight text-white group-hover:text-brandGreen transition duration-300">FoodDetect</h1>
                    <p class="text-[9px] font-bold text-brandGreen uppercase tracking-widest mt-0.5">IoT Monitoring</p>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-bold text-white/70">
                <a href="#" class="hover:text-brandGreen transition relative after:content-[''] after:absolute after:bottom-[-6px] after:left-0 after:w-0 after:h-[2px] after:bg-brandGreen hover:after:w-full after:transition-all">Beranda</a>
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brandGreen transition relative after:content-[''] after:absolute after:bottom-[-6px] after:left-0 after:w-0 after:h-[2px] after:bg-brandGreen hover:after:w-full after:transition-all">Dashboard Admin</a>
            </nav>

            <!-- Actions / Auth Button -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="group relative inline-flex items-center justify-center px-5 py-2.5 text-xs font-bold text-white rounded-xl bg-brandGreen hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 gap-2">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center px-5 py-2.5 text-xs font-extrabold text-white rounded-xl bg-brandGreen hover:bg-brandGreenHover hover:shadow-lg hover:shadow-brandGreen/25 transition duration-300 gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Parallax Hero Section -->
    <section class="relative hero-gradient pt-40 pb-56 overflow-hidden flex items-center min-h-[90vh]">
        <div class="absolute inset-0 hero-pattern opacity-40"></div>
        <div class="absolute top-0 right-0 w-[45%] h-full bg-gradient-to-l from-brandGreen/10 to-transparent blur-3xl rounded-full"></div>
        
        <!-- Glowing Ambient Dots -->
        <div class="absolute w-72 h-72 bg-brandGreen/20 blur-[120px] rounded-full top-1/4 left-10 animate-pulse"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Hero Left: Text content -->
                <div class="lg:col-span-7 space-y-6 text-left" data-aos="fade-right" data-aos-duration="1200">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brandGreen/15 border border-brandGreen/20 text-xs font-bold text-brandGreen tracking-wide uppercase">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brandGreen opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brandGreen"></span>
                        </span>
                        Multi-Sensor & Machine Learning
                    </span>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-outfit text-white leading-[1.1] tracking-tight">
                        Sistem Deteksi <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brandGreen to-[#A2DC4E]">Kontaminasi Pangan</span> <br>
                        Berbasis IoT
                    </h1>
                    
                    <p class="text-gray-400 text-sm sm:text-base max-w-xl leading-relaxed">
                        Lindungi konsumen Anda dengan pemantauan suhu, kelembapan, kadar gas, dan keasaman (pH) secara real-time langsung dari gudang penyimpanan dan dapur produksi Anda.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('login') }}" class="px-6 py-3.5 bg-brandGreen hover:bg-brandGreenHover text-white rounded-2xl font-extrabold text-sm transition duration-300 hover:shadow-lg hover:shadow-brandGreen/25 flex items-center gap-2">
                            <i class="fa-solid fa-rocket"></i> Mulai Pemantauan
                        </a>
                        <a href="#kategori" class="px-6 py-3.5 bg-white/5 hover:bg-white/10 text-white rounded-2xl font-bold text-sm border border-white/10 transition duration-300 flex items-center gap-2">
                            Pelajari Komoditas
                        </a>
                    </div>
                </div>

                <!-- Hero Right: Interactive Dashboard Mockup Card -->
                <div class="lg:col-span-5 relative" data-aos="fade-left" data-aos-duration="1200">
                    <div class="relative overflow-hidden rounded-3xl bg-brandDark/85 border border-white/10 p-6 shadow-2xl backdrop-blur-md">
                        <!-- Top header -->
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            </div>
                            <span class="text-[9px] font-bold font-mono tracking-widest text-brandGreen bg-brandGreen/10 px-2 py-1 rounded border border-brandGreen/20">LIVE METRIC</span>
                        </div>
                        
                        <!-- Mini analytics grid -->
                        <div class="space-y-4">
                            <!-- Temp -->
                            <div class="bg-white/5 rounded-2xl p-4 border border-white/5 flex items-center justify-between hover:bg-white/10 transition duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-brandGreen/15 flex items-center justify-center text-brandGreen text-lg">
                                        <i class="fa-solid fa-temperature-half"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Suhu Gudang</p>
                                        <p class="text-sm font-extrabold text-white">Cold Storage A</p>
                                    </div>
                                </div>
                                <p class="text-2xl font-black text-white font-outfit">4.2°C</p>
                            </div>

                            <!-- Gas -->
                            <div class="bg-white/5 rounded-2xl p-4 border border-white/5 flex items-center justify-between hover:bg-white/10 transition duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-yellow-500/15 flex items-center justify-center text-yellow-500 text-lg">
                                        <i class="fa-solid fa-smog"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Kadar Gas NH3</p>
                                        <p class="text-sm font-extrabold text-white">Daging Sapi Lot B</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-black text-yellow-500 font-outfit">85 ppm</p>
                                    <span class="text-[8px] font-bold text-yellow-400 uppercase tracking-widest">Waspada</span>
                                </div>
                            </div>

                            <!-- Security Status -->
                            <div class="bg-brandGreen/10 rounded-2xl p-4 border border-brandGreen/25 text-center mt-2">
                                <p class="text-[10px] font-bold text-brandGreen uppercase tracking-widest mb-1">Status Keamanan Pangan</p>
                                <p class="text-base font-extrabold text-white flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-shield-halved text-brandGreen"></i> Pangan Steril & Aman
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section (Glass Cards Overlap) -->
    <section class="relative z-20 max-w-7xl mx-auto px-6 -mt-24">
        <div class="glass-card rounded-3xl p-6 shadow-xl flex flex-col md:flex-row gap-6">
            <!-- Card 1 -->
            <div class="flex-1 bg-white rounded-2xl p-6 relative overflow-hidden group cursor-pointer shadow-sm border border-gray-150/50 transition duration-500 hover:-translate-y-2 hover:shadow-2xl glow-green" data-aos="zoom-in" data-aos-duration="1000">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-brandGreen flex items-center justify-center text-2xl mb-5 shadow-sm border border-green-100/50 group-hover:scale-110 transition duration-300">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <h3 class="text-xl font-bold font-outfit text-gray-900 group-hover:text-brandGreen transition">Deteksi Bakteri E. Coli</h3>
                <p class="text-gray-500 text-xs mt-2.5 leading-relaxed pr-6">Sistem sensor multi-node mendeteksi perubahan kadar gas metana dan amonia secara presisi untuk memprediksi pertumbuhan bakteri E. Coli.</p>
                <div class="mt-5 text-xs font-bold text-brandGreen flex items-center gap-1 opacity-0 group-hover:opacity-100 transition duration-300">
                    Pelajari Selengkapnya <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="flex-1 bg-white rounded-2xl p-6 relative overflow-hidden group cursor-pointer shadow-sm border border-gray-150/50 transition duration-500 hover:-translate-y-2 hover:shadow-2xl glow-green" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="1000">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-2xl mb-5 shadow-sm border border-blue-100/50 group-hover:scale-110 transition duration-300">
                    <i class="fa-solid fa-temperature-half"></i>
                </div>
                <h3 class="text-xl font-bold font-outfit text-gray-900 group-hover:text-brandGreen transition">Monitor Suhu & Kelembapan</h3>
                <p class="text-gray-500 text-xs mt-2.5 leading-relaxed pr-6">Pantau suhu dan kelembapan secara konstan di gudang beku (*cold storage*) untuk memastikan rantai pendingin bahan makanan tidak terputus.</p>
                <div class="mt-5 text-xs font-bold text-brandGreen flex items-center gap-1 opacity-0 group-hover:opacity-100 transition duration-300">
                    Pelajari Selengkapnya <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Food Category Circular Section -->
    <section id="kategori" class="max-w-7xl mx-auto px-6 py-24 text-center">
        <div class="max-w-2xl mx-auto space-y-4 mb-16" data-aos="fade-up" data-aos-duration="1000">
            <span class="px-3.5 py-1.5 rounded-full bg-brandGreen/10 text-brandGreen text-xs font-bold uppercase tracking-wider">Komoditas Terproteksi</span>
            <h2 class="text-3xl sm:text-4xl font-black font-outfit text-brandDark">Kategori Pangan Utama</h2>
            <p class="text-gray-500 text-xs sm:text-sm leading-relaxed">
                Pemetaan parameter tingkat anomali yang disesuaikan secara khusus berdasarkan struktur kimiawi setiap kategori pangan.
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-8 md:gap-16">
            <!-- Category Item 1 -->
            <div class="group flex flex-col items-center cursor-pointer" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden shadow-lg mb-4 border-4 border-white group-hover:border-brandGreen group-hover:rotate-6 group-hover:scale-105 transition duration-500 shadow-brandGreen/10">
                    <img src="{{ asset('assets/cat_appetizer.png') }}" class="w-full h-full object-cover">
                </div>
                <span class="text-xs md:text-sm font-extrabold text-brandDark uppercase tracking-wider group-hover:text-brandGreen transition">Daging & Olahan</span>
            </div>

            <!-- Category Item 2 -->
            <div class="group flex flex-col items-center cursor-pointer" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden shadow-lg mb-4 border-4 border-white group-hover:border-brandGreen group-hover:rotate-6 group-hover:scale-105 transition duration-500 shadow-brandGreen/10">
                    <img src="{{ asset('assets/cat_salad.png') }}" class="w-full h-full object-cover">
                </div>
                <span class="text-xs md:text-sm font-extrabold text-brandDark uppercase tracking-wider group-hover:text-brandGreen transition">Sayur & Buah</span>
            </div>

            <!-- Category Item 3 -->
            <div class="group flex flex-col items-center cursor-pointer" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden shadow-lg mb-4 border-4 border-white group-hover:border-brandGreen group-hover:rotate-6 group-hover:scale-105 transition duration-500 shadow-brandGreen/10">
                    <img src="{{ asset('assets/cat_pasta.png') }}" class="w-full h-full object-cover">
                </div>
                <span class="text-xs md:text-sm font-extrabold text-brandDark uppercase tracking-wider group-hover:text-brandGreen transition">Makanan Siap Saji</span>
            </div>
        </div>
    </section>

    <!-- Gorgeous Premium Footer -->
    <footer class="bg-brandDark text-gray-400 py-12 border-t border-white/5 relative z-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-brandGreen flex items-center justify-center font-bold text-white text-xs font-outfit">
                    Fd
                </div>
                <span class="font-outfit font-bold text-white tracking-wide">FoodDetect IoT</span>
            </div>
            
            <p class="text-xs text-gray-500">© 2026 FoodDetect. Hak Cipta Dilindungi Undang-Undang. Pemantauan cerdas berkualitas industri.</p>
            
            <div class="flex gap-4">
                <a href="#" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/10 text-white flex items-center justify-center text-xs transition duration-300">
                    <i class="fa-brands fa-github"></i>
                </a>
                <a href="#" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/10 text-white flex items-center justify-center text-xs transition duration-300">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- Initialize AOS -->
    <script>
        AOS.init({
            once: true,
            duration: 800,
        });
    </script>
</body>
</html>
