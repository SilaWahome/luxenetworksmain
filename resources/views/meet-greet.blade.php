<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Meet & Greet | Luxenet</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { background-color: #060d14; color: white; }
        .event-container { max-width: 1200px; margin: 0 auto; padding: 120px 5% 60px; }
        .glass-card { 
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 24px;
            padding: 40px;
        }
        .announcement-item {
            border-left: 3px solid var(--primary);
            padding-left: 20px;
            margin-bottom: 24px;
            background: rgba(184, 150, 42, 0.05);
            padding: 20px;
            border-radius: 0 12px 12px 0;
        }
    </style>
</head>
<body>

    <nav>
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('images/logo-light.png') }}" alt="Luxenet" style="height: 36px;">
        </a>
        <div class="nav-links hide-tablet">
            <a href="{{ url('/') }}">Home</a>
            <a href="#about">About</a>
            <a href="#announcements">Updates</a>
            <a href="{{ route('meet-greet.register') }}">Register</a>
        </div>
        <a href="{{ route('meet-greet.register') }}" class="btn-login">Register Now</a>
    </nav>

    <div class="event-container">
        
        <!-- PenguinUI Style Slider -->
        <section class="mb-20 overflow-hidden rounded-3xl" x-data="{ 
            activeSlide: 0, 
            slides: {{ $slides->map(fn($s) => ['img' => asset('storage/'.$s->image), 'title' => $s->title, 'desc' => $s->description])->toJson() }},
            next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
            prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length }
        }" x-init="if(slides.length > 1) setInterval(() => next(), 5000)">
            <div class="relative aspect-video w-full max-w-[1440px] mx-auto bg-slate-900 shadow-2xl">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index" 
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 scale-105"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute inset-0">
                        <img :src="slide.img" class="h-full w-full object-cover opacity-60" alt="">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#060d14] via-transparent to-transparent"></div>
                        <div class="absolute bottom-12 left-12 right-12">
                            <h2 class="text-4xl font-extrabold mb-2" x-text="slide.title"></h2>
                            <p class="text-lg text-gray-300 max-w-2xl mb-6" x-text="slide.desc"></p>
                            <a href="{{ route('meet-greet.register') }}" class="inline-block bg-primary text-white font-bold px-8 py-3 rounded-xl hover:scale-105 transition-all">Claim Your Invite</a>
                        </div>
                    </div>
                </template>

                <div class="absolute top-1/2 -translate-y-1/2 left-4 right-4 flex justify-between pointer-events-none" x-show="slides.length > 1">
                    <button @click="prev()" class="pointer-events-auto size-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center hover:bg-white/20 transition-all">
                        <i class="fas fa-chevron-left text-white"></i>
                    </button>
                    <button @click="next()" class="pointer-events-auto size-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center hover:bg-white/20 transition-all">
                        <i class="fas fa-chevron-right text-white"></i>
                    </button>
                </div>

                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2" x-show="slides.length > 1">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                :class="activeSlide === index ? 'w-8 bg-primary' : 'w-2 bg-white/30'"
                                class="h-1.5 rounded-full transition-all duration-500"></button>
                    </template>
                </div>
            </div>
        </section>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Announcements -->
            <section id="announcements">
                <h3 class="text-2xl font-bold mb-8 flex items-center gap-3">
                    <i class="fas fa-bullhorn text-primary"></i> Latest Announcements
                </h3>
                @forelse($announcements as $announcement)
                    <div class="announcement-item">
                        <div class="text-xs text-primary font-bold uppercase tracking-widest mb-2">
                            {{ $announcement->created_at->format('M d, Y') }}
                        </div>
                        <p class="text-gray-300 leading-relaxed">{{ $announcement->content }}</p>
                    </div>
                @empty
                    <div class="glass-card text-center py-10">
                        <p class="text-gray-500 italic">No active announcements at the moment.</p>
                    </div>
                @endforelse
            </section>

            <!-- Call to Action -->
            <section id="apply">
                <div class="glass-card h-full flex flex-col justify-center text-center">
                    <div class="mb-8">
                        <div class="size-20 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-primary text-3xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Limited Slots Available</h3>
                        <p class="text-gray-400 max-w-md mx-auto mb-6">We curate our guest list to ensure high-quality networking and meaningful connections. Request your invitation today.</p>
                        
                        <!-- Premium Curtain Glass Countdown Timer -->
                        <div class="grid grid-cols-4 gap-3 max-w-sm mx-auto mb-8">
                            <div class="bg-white/5 border border-white/10 rounded-xl p-3 backdrop-blur-md shadow-lg shadow-black/20">
                                <span id="days" class="block text-2xl font-black text-primary">00</span>
                                <span class="text-[9px] uppercase tracking-widest text-gray-500 font-bold">Days</span>
                            </div>
                            <div class="bg-white/5 border border-white/10 rounded-xl p-3 backdrop-blur-md shadow-lg shadow-black/20">
                                <span id="hours" class="block text-2xl font-black text-primary">00</span>
                                <span class="text-[9px] uppercase tracking-widest text-gray-500 font-bold">Hours</span>
                            </div>
                            <div class="bg-white/5 border border-white/10 rounded-xl p-3 backdrop-blur-md shadow-lg shadow-black/20">
                                <span id="minutes" class="block text-2xl font-black text-primary">00</span>
                                <span class="text-[9px] uppercase tracking-widest text-gray-500 font-bold">Mins</span>
                            </div>
                            <div class="bg-white/5 border border-white/10 rounded-xl p-3 backdrop-blur-md shadow-lg shadow-black/20 animate-pulse">
                                <span id="seconds" class="block text-2xl font-black text-primary">00</span>
                                <span class="text-[9px] uppercase tracking-widest text-gray-500 font-bold">Secs</span>
                            </div>
                        </div>

                        <a href="{{ route('meet-greet.register') }}" class="block w-full bg-primary text-white font-extrabold py-5 rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-lg uppercase tracking-wider">
                            Register for Event
                        </a>
                        <a href="{{ url('Techmeet/index.php') }}" class="block mt-4 text-sm text-gray-500 hover:text-primary transition-all">
                            <i class="fas fa-ticket-alt mr-2"></i> Already registered? Get my ticket
                        </a>
                    </div>
                    <p class="text-xs text-gray-600 uppercase tracking-widest">Next event: {{ $settings['event_location'] ?? 'Nairobi, Kenya' }} • {{ $settings['event_date'] ?? 'Q3 2026' }}</p>
                </div>
            </section>
        </div>
    </div>

    <footer class="py-12 border-t border-white/5 mt-20 text-center">
        <p class="text-gray-600 text-sm">© 2026 Luxenet Tech Community. All rights reserved.</p>
    </footer>

    <!-- Safe Dynamic Countdown Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const eventDateStr = "{{ $settings['event_date'] ?? 'Apr 06, 2026' }}";
            const eventTimeStr = "{{ $settings['event_time'] ?? '2:30 PM' }}";
            
            let targetDate;
            try {
                targetDate = new Date(`${eventDateStr} ${eventTimeStr}`).getTime();
                if (isNaN(targetDate)) {
                    // Fallback target date if parse fails
                    targetDate = new Date("2026-12-31T23:59:59").getTime();
                }
            } catch (e) {
                targetDate = new Date("2026-12-31T23:59:59").getTime();
            }

            function updateCountdown() {
                const now = new Date().getTime();
                const difference = targetDate - now;

                if (difference < 0) {
                    document.getElementById('days').innerText = "00";
                    document.getElementById('hours').innerText = "00";
                    document.getElementById('minutes').innerText = "00";
                    document.getElementById('seconds').innerText = "00";
                    return;
                }

                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                document.getElementById('days').innerText = String(days).padStart(2, '0');
                document.getElementById('hours').innerText = String(hours).padStart(2, '0');
                document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
                document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
</body>
</html>
