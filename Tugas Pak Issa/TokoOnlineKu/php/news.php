<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epic Games News</title>
    <style>
        .container-news {
            height: 50vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .title-container{
            margin-bottom: 100px;
        }
        .title{
            margin-top: 45px;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0A0A0A] text-white">
    <div class=" max-w-4xl mx-auto space-y-8">
        <div class="title-container text-center">
            <h1 class=" title text-4xl font-bold text-[#E0E0E0] mb-4 
                       bg-gradient-to-r from-[#4A90E2] to-[#6AB0FF] 
                       bg-clip-text text-transparent 
                       drop-shadow-[0_4px_6px_rgba(74,144,226,0.3)]">
                Our News
            </h1>
            <p class="text-[#A0A0A0] max-w-xl mx-auto">
                Dive into the latest gaming insights, upcoming releases, and groundbreaking developments in the world of interactive entertainment.
            </p>
        </div>
        <div  class="container-news grid grid-cols-2 gap-4">
                
        <div class="bg-[#121212] rounded-lg overflow-hidden shadow-2xl border border-[#1E1E1E] relative 
                         before:absolute before:inset-0 before:bg-gradient-to-br before:from-[#1A1A1A] 
                         before:to-[#0C0C0C] before:opacity-50 before:pointer-events-none">
                <div class="relative z-10">
                    <div class="bg-[#1E1E1E] h-1 w-full"></div>
                    <img src="./assets/gamenews.webp" alt="Game News 1" class="w-full h-48 object-cover filter brightness-75 contrast-125">
                    <div class="p-4 bg-gradient-to-r from-[#0F0F0F] to-[#1A1A1A]">
                        <h2 class="text-xl font-bold mb-2 text-[#E0E0E0] border-l-4 border-[#2A2A2A] pl-3">Discover the future of gaming: Epic Games Store's 2025 release preview</h2>
                        <p class="text-[#A0A0A0] mb-4 ml-3">From brand-new games to sequels to your existing favorites, 2025 showcases the future of gaming.</p>
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-[#707070] mb-2 ml-3">8d AGO</div>
                            <a href="?menu=news1" class="mt-2 inline-block text-[#4A90E2] hover:text-[#6AB0FF] hover:underline bg-[#1A1A1A] px-3 py-1 rounded-full">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-[#121212] rounded-lg overflow-hidden shadow-2xl border border-[#1E1E1E] relative 
                         before:absolute before:inset-0 before:bg-gradient-to-br before:from-[#1A1A1A] 
                         before:to-[#0C0C0C] before:opacity-50 before:pointer-events-none">
                <div class="relative z-10">
                    <div class="bg-[#1E1E1E] h-1 w-full"></div>
                    <img src="./assets/gamenews2.avif" alt="Game News 2" class="w-full h-48 object-cover filter brightness-75 contrast-125">
                    <div class="p-4 bg-gradient-to-r from-[#0F0F0F] to-[#1A1A1A]">
                        <h2 class="text-xl font-bold mb-2 text-[#E0E0E0] border-l-4 border-[#2A2A2A] pl-3">Seven ways Assassin's Creed Shadows shakes up the series' formula</h2>
                        <p class="text-[#A0A0A0] mb-4 ml-3">Ubisoft's latest historical murder holiday makes the most significant changes to the series since 2017's Assassin's Creed Origins.</p>
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-[#707070] mb-2 ml-3">14d AGO</div>
                            <a href="?menu=news2" class="mt-2 inline-block text-[#4A90E2] hover:text-[#6AB0FF] hover:underline bg-[#1A1A1A] px-3 py-1 rounded-full">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>