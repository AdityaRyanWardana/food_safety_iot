<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FoodDetect</title>
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
        .login-bg {
            background-image: linear-gradient(rgba(26, 26, 26, 0.8), rgba(26, 26, 26, 0.9)), url("{{ asset('assets/hero_bg.png') }}");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased h-screen flex login-bg">

    <div class="m-auto w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-serif font-bold text-white tracking-tight">FoodDetect</h1>
            <p class="text-white/60 text-sm mt-2">Buat Akun Baru</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-brandDark mb-6 text-center">Daftar Akun</h2>
            
            <form action="{{ url('/register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brandGreen outline-none" placeholder="Masukkan nama Anda" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brandGreen outline-none" placeholder="email@contoh.com" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brandGreen outline-none" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-brandGreen text-white font-bold py-3 rounded-lg hover:bg-green-600 shadow-md mt-4">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-500">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-brandGreen font-semibold hover:underline">Masuk di sini</a>
            </div>
        </div>
    </div>

</body>
</html>
