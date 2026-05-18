<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodDetect - Sistem Deteksi Kontaminasi Makanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brandGreen: '#8DC63F',
                        brandDark: '#1A1A1A',
                    }
                }
            }
        }
    </script>
    <style>
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url("{{ asset('assets/hero_bg.png') }}");
            background-size: cover;
            background-position: center;
        }
        .card-bg-1 {
            background-image: linear-gradient(rgba(0,0,0,0.1) 40%, rgba(0,0,0,0.8)), url("{{ asset('assets/pizza_card.png') }}");
            background-size: cover;
            background-position: center;
        }
        .card-bg-2 {
            background-image: linear-gradient(rgba(0,0,0,0.1) 40%, rgba(0,0,0,0.8)), url("{{ asset('assets/chicken_card.png') }}");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased bg-white">

    <div class="bg-brandDark text-white text-xs py-2 px-6 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <i class="fa-regular fa-envelope"></i>
            <span>Support@fooddetect.id</span>
        </div>
        <div class="flex items-center space-x-4">
            <span>Pemantauan cerdas berbasis IoT</span>
            <a href="{{ route('login') }}" class="bg-brandGreen text-white px-3 py-1 rounded font-semibold hover:bg-green-600 transition">Detail</a>
        </div>
    </div>

    <div class="hero-bg pb-48 pt-6">
        <nav class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="text-3xl font-serif font-bold text-white">FoodDetect</div>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-white/90">
                <a href="#" class="hover:text-white transition">Beranda</a>
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">Dashboard</a>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('login') }}" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition">
                    <i class="fa-regular fa-user"></i>
                </a>
            </div>
        </nav>

        <div class="max-w-3xl mx-auto text-center mt-20 mb-10 px-4">
            <h1 class="text-5xl md:text-6xl font-serif font-bold text-white mb-6 leading-tight">
                Sistem Deteksi <br> Kontaminasi Makanan
            </h1>
            <p class="text-white/80 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Menggunakan Multi-Sensor dan Machine Learning Berbasis IoT.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 -mt-32 relative z-10">
        <div class="bg-white rounded-t-3xl p-4 shadow-xl flex flex-col md:flex-row gap-6">
            <div class="flex-1 card-bg-1 rounded-2xl h-80 relative overflow-hidden group cursor-pointer shadow-md">
                <div class="absolute bottom-0 left-0 right-0 p-6 flex flex-col justify-end h-full">
                    <h3 class="text-xl font-serif font-bold text-white mb-2 group-hover:text-brandGreen transition">Deteksi Bakteri E. Coli</h3>
                    <p class="text-white/80 text-xs line-clamp-2">Sistem sensor mendeteksi tingkat anomali gas secara real-time.</p>
                </div>
            </div>
            <div class="flex-1 card-bg-2 rounded-2xl h-80 relative overflow-hidden group cursor-pointer shadow-md">
                <div class="absolute bottom-0 left-0 right-0 p-6 flex flex-col justify-end h-full">
                    <h3 class="text-xl font-serif font-bold text-white mb-2 group-hover:text-brandGreen transition">Monitor Suhu & Kelembapan</h3>
                    <p class="text-white/80 text-xs line-clamp-2">Pemantauan gudang penyimpanan bahan mentah secara aktif.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-20 text-center">
        <h2 class="text-4xl font-serif font-bold text-brandDark mb-4">Monitor Kualitas Makanan</h2>
        <div class="flex flex-wrap justify-center gap-8 md:gap-12 mt-12">
            <div class="group flex flex-col items-center">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden shadow-lg mb-4">
                    <img src="{{ asset('assets/cat_appetizer.png') }}" class="w-full h-full object-cover">
                </div>
                <span class="text-sm font-bold text-brandDark uppercase">Daging & Olahan</span>
            </div>
            <div class="group flex flex-col items-center">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden shadow-lg mb-4">
                    <img src="{{ asset('assets/cat_salad.png') }}" class="w-full h-full object-cover">
                </div>
                <span class="text-sm font-bold text-brandDark uppercase">Sayur & Buah</span>
            </div>
            <div class="group flex flex-col items-center">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden shadow-lg mb-4">
                    <img src="{{ asset('assets/cat_pasta.png') }}" class="w-full h-full object-cover">
                </div>
                <span class="text-sm font-bold text-brandDark uppercase">Makanan Siap Saji</span>
            </div>
        </div>
    </div>

</body>
</html>
