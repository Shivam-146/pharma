<?php
require_once __DIR__ . '/products_data.php';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaasCure Pharmaceutical Private Limited | Committed to Quality Healthcare</title>
    <meta name="description"
        content="MaasCure Pharmaceutical Private Limited is a leading healthcare provider committed to innovation, quality, and healthcare solutions.">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/main.css?v=1.0.2">
</head>

<body class="bg-slate-50 text-slate-900 overflow-x-hidden min-h-screen flex flex-col">
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader-brand">
            MaasCure<span>.</span>
        </div>
        <div class="capsule-loader">
            <div class="capsule-half-1"></div>
            <div class="capsule-half-2"></div>
        </div>
    </div>

    <!-- Header Placeholder -->
    <div id="header-placeholder"></div>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen lg:h-screen flex items-center justify-center overflow-hidden">

        <!-- Background Video + Overlays -->
        <!-- Video Source: https://www.pexels.com/video/a-man-and-a-woman-working-in-a-laboratory-8381416/ -->
        <div class="absolute inset-0 z-0">
            <video autoplay loop muted playsinline class="w-full h-full object-cover">
                <source src="assets/laboratory.mp4" type="video/mp4">
                <img src="assets/hero_bg.png" alt="Pharma Hero" class="w-full h-full object-cover" fetchpriority="high">
            </video>
            <!-- Dark gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-black/80"></div>
            <!-- Radial center glow -->
            <div class="absolute inset-0" style="background: radial-gradient(ellipse 80% 55% at 50% 50%, rgba(255,255,255,0.05) 0%, transparent 70%);"></div>
        </div>

        <!-- Decorative pulsing rings -->
        <div class="absolute inset-0 z-[1] flex items-center justify-center pointer-events-none">
            <div class="absolute w-[500px] h-[500px] rounded-full border border-blue-500/20 animate-pulse"></div>
            <div class="absolute w-[750px] h-[750px] rounded-full border border-blue-500/10" style="animation: pulse 4s ease-in-out 1s infinite;"></div>
            <div class="absolute w-[1050px] h-[1050px] rounded-full border border-blue-500/5" style="animation: pulse 5s ease-in-out 2s infinite;"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 flex flex-col items-center text-center px-6 max-w-5xl mx-auto">

            <!-- Badge -->
            <div class="flex items-center gap-3 bg-white/5 border border-white/10 backdrop-blur-md px-5 py-2 rounded-full mb-10">
                <span class="w-2 h-2 rounded-full bg-green-400 shadow-[0_0_10px_rgba(74,222,128,0.5)] animate-pulse"></span>
                <span class="text-white/60 text-xs font-semibold tracking-[0.22em] uppercase">Committed to Quality Healthcare</span>
            </div>

            <!-- Brand Name -->
            <h1 class="flex flex-col items-center gap-1 mb-0 text-center">
                <span class="text-white font-black leading-none tracking-tight"
                    style="font-size: clamp(1.75rem, 6vw, 5.5rem); text-shadow: 0 0 80px rgba(255,255,255,0.1);">
                    MaasCure Pharmaceutical
                </span>
                <span class="font-extrabold leading-none tracking-tight bg-clip-text text-transparent"
                    style="font-size: clamp(1.5rem, 4.8vw, 4.2rem);
                           background-image: linear-gradient(90deg, #fff, #34d399, #fff);
                           background-size: 200% auto;
                           -webkit-background-clip: text;
                           animation: heroShimmer 4s linear infinite;">
                    Private Limited
                </span>
            </h1>

            <!-- Animated Divider -->
            <div class="mt-7 mb-6 h-[3px] rounded-full w-32"
                style="background: linear-gradient(90deg, transparent, #fff, #22c55e, transparent);"></div>

            <!-- Tagline -->
            <p class="text-white/70 font-light italic tracking-widest mb-10"
                style="font-size: clamp(1.1rem, 2.5vw, 1.75rem); letter-spacing: 0.12em;">
                Care Beyond Cure
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="products.php"
                    class="px-9 py-4 rounded-full font-bold text-white text-sm tracking-wider transition-all duration-300 hover:-translate-y-1 hover:scale-105"
                    style="background: linear-gradient(135deg, #2563eb, #1d4ed8); box-shadow: 0 8px 32px rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1);">
                    Explore Products
                </a>
                <a href="about.html"
                    class="px-9 py-4 rounded-full font-bold text-white text-sm tracking-wider border border-white/20 bg-white/7 backdrop-blur-md transition-all duration-300 hover:bg-white/15 hover:border-white/35 hover:-translate-y-1 hover:scale-105"
                    style="background: rgba(255,255,255,0.07);">
                    Our Story
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2">
            <span class="text-white/30 text-[10px] tracking-[0.3em] uppercase font-medium">Scroll</span>
            <a href="#welcome"
                class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white/40 hover:text-white hover:border-white/50 hover:bg-white/10 transition-all duration-300 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </a>
        </div>
    </section>


    <!-- Welcome Summary -->
    <section id="welcome" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-blue-600 font-bold tracking-widest uppercase mb-4">Welcome to MaasCure</h3>
            <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8 leading-tight">
                Your Health, Our <span class="text-green-500">Mission</span>
            </h2>
            <p class="text-lg text-slate-600 leading-relaxed mb-12 max-w-3xl mx-auto">
                We are a leading pharmaceutical company dedicated to providing high-quality medical solutions. Explore
                our journey, our products, and our commitment to a healthier India.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Card 1: Innovation -->
                <div class="group relative bg-white border border-slate-100 rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-[0_30px_70px_rgba(37,99,235,0.06)] hover:border-blue-500/10 transition-all duration-500 hover:-translate-y-3 flex flex-col items-center text-center overflow-hidden">
                    <div class="absolute -inset-px rounded-[2.5rem] bg-gradient-to-br from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center mb-8 text-blue-600 shadow-sm transition-all duration-500 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 group-hover:rotate-6">
                            <svg xmlns="http://www.w3.org/2003/svg" class="h-8 w-8 transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a2 2 0 00-1.96 1.414l-.727 2.903a2 2 0 01-1.558 1.456l-2.31.462a2 2 0 01-1.995-1.446l-.72-2.88a2 2 0 00-1.503-1.455l-2.454-.512a2 2 0 01-1.516-1.516l-.512-2.454a2 2 0 00-1.455-1.503l-2.88-.72a2 2 0 01-1.446-1.995l.462-2.31a2 2 0 011.456-1.558l2.903-.727a2 2 0 001.414-1.96l-.477-2.387a2 2 0 01.547-1.022L7.05 2.05a2 2 0 011.022-.547l2.387.477a2 2 0 001.96-1.414l.727-2.903a2 2 0 011.558-1.456l2.31-.462a2 2 0 011.995 1.446l.72 2.88a2 2 0 00-1.503 1.455l-2.454-.512a2 2 0 01-1.516-1.516l-.512-2.454a2 2 0 00-1.455-1.503l-2.88-.72a2 2 0 01-1.446-1.995l-.462 2.31a2 2 0 01-1.456 1.558l-2.903.727a2 2 0 00-1.414 1.96l.477 2.387a2 2 0 01-.547 1.022L12 10z" />
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-slate-800 mb-4">Innovation</h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 max-w-sm">
                            Leveraging modern formulation techniques and scientific advancements to build highly effective healthcare products. Our progressive R&D mindset helps deliver next-generation treatment options.
                        </p>
                        <a href="about.html" class="inline-flex items-center gap-2 text-blue-600 font-bold text-sm tracking-wide group/btn hover:text-blue-700">
                            <span>Read More</span>
                            <span class="transition-transform duration-300 group-hover/btn:translate-x-1.5">&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Quality -->
                <div class="group relative bg-white border border-slate-100 rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-[0_30px_70px_rgba(16,185,129,0.06)] hover:border-emerald-500/10 transition-all duration-500 hover:-translate-y-3 flex flex-col items-center text-center overflow-hidden">
                    <div class="absolute -inset-px rounded-[2.5rem] bg-gradient-to-br from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-16 h-16 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-center mb-8 text-emerald-600 shadow-sm transition-all duration-500 group-hover:bg-emerald-600 group-hover:text-white group-hover:scale-105 group-hover:rotate-6">
                            <svg xmlns="http://www.w3.org/2003/svg" class="h-8 w-8 transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29-9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-slate-800 mb-4">Quality</h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 max-w-sm">
                            Adhering to strict WHO-GMP protocols and quality workflows. Every batch is rigorously audited and certified to assure consistent purity, stability, and therapeutic compliance.
                        </p>
                        <a href="about.html" class="inline-flex items-center gap-2 text-emerald-600 font-bold text-sm tracking-wide group/btn hover:text-emerald-700">
                            <span>Read More</span>
                            <span class="transition-transform duration-300 group-hover/btn:translate-x-1.5">&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Card 3: Affordability -->
                <div class="group relative bg-white border border-slate-100 rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-[0_30px_70px_rgba(37,99,235,0.06)] hover:border-blue-500/10 transition-all duration-500 hover:-translate-y-3 flex flex-col items-center text-center overflow-hidden">
                    <div class="absolute -inset-px rounded-[2.5rem] bg-gradient-to-br from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center mb-8 text-blue-600 shadow-sm transition-all duration-500 group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 group-hover:rotate-6">
                            <svg xmlns="http://www.w3.org/2003/svg" class="h-8 w-8 transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-slate-800 mb-4">Affordability</h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 max-w-sm">
                            Committed to bridging premium medical science and accessibility. By optimizing supply channels and manufacturing efficiency, we ensure vital treatments are widely affordable.
                        </p>
                        <a href="about.html" class="inline-flex items-center gap-2 text-blue-600 font-bold text-sm tracking-wide group/btn hover:text-blue-700">
                            <span>Read More</span>
                            <span class="transition-transform duration-300 group-hover/btn:translate-x-1.5">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Certifications & Compliance Badges -->
            <div class="mt-20 pt-16 border-t border-slate-100 flex flex-wrap justify-center items-center gap-6 md:gap-10">
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-2xl px-6 py-3 transition-all hover:bg-white hover:shadow-md hover:border-blue-500/20">
                    <span class="text-blue-600 text-xl font-bold">✓</span>
                    <span class="text-xs font-bold text-slate-600 tracking-wide uppercase">WHO-GMP Compliant</span>
                </div>
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-2xl px-6 py-3 transition-all hover:bg-white hover:shadow-md hover:border-green-500/20">
                    <span class="text-green-500 text-xl font-bold">✓</span>
                    <span class="text-xs font-bold text-slate-600 tracking-wide uppercase">ISO 9001:2015 Certified</span>
                </div>
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-2xl px-6 py-3 transition-all hover:bg-white hover:shadow-md hover:border-blue-500/20">
                    <span class="text-blue-600 text-xl font-bold">✓</span>
                    <span class="text-xs font-bold text-slate-600 tracking-wide uppercase">FDA Standards</span>
                </div>
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-2xl px-6 py-3 transition-all hover:bg-white hover:shadow-md hover:border-green-500/20">
                    <span class="text-green-500 text-xl font-bold">✓</span>
                    <span class="text-xs font-bold text-slate-600 tracking-wide uppercase">GLP Certified Labs</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section id="why-choose-us" class="relative py-16 md:py-32 bg-white overflow-hidden">
        <!-- Clinic Background Scene -->
        <div class="absolute right-0 top-0 w-full h-full z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent z-10"></div>
            <img src="assets/vision_hero.png" alt="Lab Scene" class="w-full h-full object-cover object-right opacity-40" loading="lazy">
        </div>

        <div class="container mx-auto px-6 relative z-20 reveal">
            <div class="flex flex-col lg:flex-row items-center">
                <!-- Left Column: Content -->
                <div class="lg:w-1/2 mb-16 lg:mb-0">
                    <span class="text-teal-500 font-bold tracking-widest uppercase text-sm mb-6 block">Why Choose Us</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-6xl font-bold text-slate-800 mb-8 leading-[1.1]">
                        MaasCure : Your Pathway <br> to Total Wellness
                    </h2>

                    <!-- Key Highlights List -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 mb-16 max-w-xl">
                        <div class="flex items-center space-x-3 group">
                            <div class="w-6 h-6 bg-teal-50 rounded-full flex items-center justify-center shrink-0 group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-3.5 h-3.5 text-teal-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="font-bold text-slate-700">High-quality & reliable products</span>
                        </div>
                        <div class="flex items-center space-x-3 group">
                            <div class="w-6 h-6 bg-teal-50 rounded-full flex items-center justify-center shrink-0 group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-3.5 h-3.5 text-teal-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="font-bold text-slate-700">Strict quality control</span>
                        </div>
                        <div class="flex items-center space-x-3 group">
                            <div class="w-6 h-6 bg-teal-50 rounded-full flex items-center justify-center shrink-0 group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-3.5 h-3.5 text-teal-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="font-bold text-slate-700">Focus on innovation</span>
                        </div>
                        <div class="flex items-center space-x-3 group">
                            <div class="w-6 h-6 bg-teal-50 rounded-full flex items-center justify-center shrink-0 group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-3.5 h-3.5 text-teal-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="font-bold text-slate-700">Affordable solutions</span>
                        </div>
                        <div class="flex items-center space-x-3 group sm:col-span-2">
                            <div class="w-6 h-6 bg-teal-50 rounded-full flex items-center justify-center shrink-0 group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-3.5 h-3.5 text-teal-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="font-bold text-slate-700">Customer-centric approach</span>
                        </div>
                    </div>

                    <!-- Features List -->
                    <div class="space-y-12">
                        <!-- Feature 1 -->
                        <div class="flex items-center gap-8">
                            <div class="w-20 h-20 rounded-full border border-slate-200 shadow-sm flex items-center justify-center shrink-0 bg-white">
                                <svg class="w-10 h-10 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M3 18v-6a9 9 0 0118 0v6M3 18a2 2 0 002 2h1a2 2 0 002-2v-4a2 2 0 00-2-2H3M21 18a2 2 0 01-2 2h-1a2 2 0 01-2-2v-4a2 2 0 012-2h3" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-slate-700 mb-2">Priority Customer Support</h4>
                                <p class="text-slate-400 text-lg leading-snug">
                                    your well-being is our priority. Benefit from high-level customer support to address any concerns or inquiries promptly.
                                </p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="flex items-center gap-8">
                            <div class="w-20 h-20 rounded-full border border-slate-200 shadow-sm flex items-center justify-center shrink-0 bg-white">
                                <svg class="w-10 h-10 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v1m0 0v1m0-1h1m-1 0H11" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-slate-700 mb-2">Continuous Innovation and Growth</h4>
                                <p class="text-slate-400 text-lg leading-snug">
                                    we're committed to constant improvement. Expect regular updates, new features, and ongoing innovations to enhance your health experience
                                </p>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="flex items-center gap-8">
                            <div class="w-20 h-20 rounded-full border border-slate-200 shadow-sm flex items-center justify-center shrink-0 bg-white">
                                <svg class="w-10 h-10 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-slate-700 mb-2">National Community of Wellness</h4>
                                <p class="text-slate-400 text-lg leading-snug">
                                    Join a diverse and supportive community of users across India, sharing a commitment to healthier living through MaasCure.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Doctor Cutout -->
                <div class="lg:w-1/2 flex justify-end items-end relative min-h-[300px] lg:min-h-[600px]">
                    <img src="assets/doctor_nurse.png" alt="MaasCure Health Professional" class="w-full h-auto drop-shadow-[-30px_30px_60px_rgba(0,0,0,0.1)] transition-transform duration-700 hover:scale-[1.03] z-20" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Product Highlights -->
    <section class="relative py-16 md:py-32 overflow-hidden border-t border-slate-200">
        <!-- Background Video -->
        <div class="absolute inset-0 z-0">
            <video autoplay loop muted playsinline class="w-full h-full object-cover">
                <source src="assets/product.mp4" type="video/mp4">
            </video>
            <!-- Dark overlay for readability -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/60 to-black/85"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 reveal">
            <div class="text-center mb-20">
                <h3 class="text-blue-300 font-bold tracking-widest uppercase mb-4">Product Highlights</h3>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Our Product Range</h2>
                <div class="w-24 h-1 bg-blue-400 mx-auto rounded mb-8"></div>
                <p class="text-lg text-blue-100 max-w-2xl mx-auto">We offer a diverse portfolio of pharmaceutical
                    products designed to meet various healthcare needs.</p>
            </div>
            <?php if (!empty($categories)): ?>
            <!-- Infinite Marquee Scrolling Categories -->
            <div class="animate-marquee-container relative overflow-hidden w-full select-none mb-16 py-4 flex">
                <div class="animate-marquee flex gap-8">
                    <!-- Group 1 -->
                    <?php foreach ($categories as $idx => $cat): ?>
                        <?php 
                        $isEven = ($idx % 2 === 0);
                        $overlayClass = $isEven ? 'bg-blue-950/75 group-hover:bg-blue-900/65' : 'bg-emerald-950/75 group-hover:bg-emerald-900/65';
                        $borderClass = $isEven ? 'bg-blue-400' : 'bg-emerald-400';
                        
                        // Category Image fallback check
                        $catImage = 'assets/hero_bg.png';
                        if (!empty($cat['image'])) {
                            $catImage = htmlspecialchars($cat['image']);
                        } else {
                            $slug = strtolower($cat['slug']);
                            if (strpos($slug, 'tablet') !== false) {
                                $catImage = 'assets/cat_tablets.jpeg';
                            } elseif (strpos($slug, 'capsule') !== false) {
                                $catImage = 'assets/cat_capsules.jpeg';
                            } elseif (strpos($slug, 'syrup') !== false || strpos($slug, 'liquid') !== false) {
                                $catImage = 'assets/cat_syrups.jpeg';
                            } elseif (strpos($slug, 'inject') !== false || strpos($slug, 'vial') !== false || strpos($slug, 'ampoule') !== false) {
                                $catImage = 'assets/cat_injections.jpeg';
                            }
                        }
                        ?>
                        <a href="products.php?cat=<?= $cat['id'] ?>"
                            class="w-[280px] sm:w-[320px] shrink-0 block relative overflow-hidden p-6 sm:p-10 rounded-3xl text-center group hover:-translate-y-1.5 transition-all duration-300 border border-white/10 shadow-lg min-h-[220px] flex flex-col justify-center items-center">
                            <!-- Background Image -->
                            <img src="<?= $catImage ?>" alt="<?= htmlspecialchars($cat['name']) ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 z-0" loading="lazy">
                            <!-- Overlay -->
                            <div class="absolute inset-0 <?= $overlayClass ?> transition-colors duration-300 z-10"></div>
                            <!-- Foreground Content -->
                            <div class="relative z-20 flex flex-col items-center">
                                <h4 class="text-lg sm:text-2xl font-extrabold text-white tracking-wider uppercase mb-3 whitespace-normal">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </h4>
                                <span class="inline-block w-8 h-[2px] <?= $borderClass ?> rounded transition-all duration-300 group-hover:w-16"></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                    
                    <!-- Group 2 (Duplicate clone for seamless infinite scrolling) -->
                    <?php foreach ($categories as $idx => $cat): ?>
                        <?php 
                        $isEven = ($idx % 2 === 0);
                        $overlayClass = $isEven ? 'bg-blue-950/75 group-hover:bg-blue-900/65' : 'bg-emerald-950/75 group-hover:bg-emerald-900/65';
                        $borderClass = $isEven ? 'bg-blue-400' : 'bg-emerald-400';
                        
                        // Category Image fallback check
                        $catImage = 'assets/hero_bg.png';
                        if (!empty($cat['image'])) {
                            $catImage = htmlspecialchars($cat['image']);
                        } else {
                            $slug = strtolower($cat['slug']);
                            if (strpos($slug, 'tablet') !== false) {
                                $catImage = 'assets/cat_tablets.jpeg';
                            } elseif (strpos($slug, 'capsule') !== false) {
                                $catImage = 'assets/cat_capsules.jpeg';
                            } elseif (strpos($slug, 'syrup') !== false || strpos($slug, 'liquid') !== false) {
                                $catImage = 'assets/cat_syrups.jpeg';
                            } elseif (strpos($slug, 'inject') !== false || strpos($slug, 'vial') !== false || strpos($slug, 'ampoule') !== false) {
                                $catImage = 'assets/cat_injections.jpeg';
                            }
                        }
                        ?>
                        <a href="products.php?cat=<?= $cat['id'] ?>"
                            class="w-[280px] sm:w-[320px] shrink-0 block relative overflow-hidden p-6 sm:p-10 rounded-3xl text-center group hover:-translate-y-1.5 transition-all duration-300 border border-white/10 shadow-lg min-h-[220px] flex flex-col justify-center items-center">
                            <!-- Background Image -->
                            <img src="<?= $catImage ?>" alt="<?= htmlspecialchars($cat['name']) ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 z-0" loading="lazy">
                            <!-- Overlay -->
                            <div class="absolute inset-0 <?= $overlayClass ?> transition-colors duration-300 z-10"></div>
                            <!-- Foreground Content -->
                            <div class="relative z-20 flex flex-col items-center">
                                <h4 class="text-lg sm:text-2xl font-extrabold text-white tracking-wider uppercase mb-3 whitespace-normal">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </h4>
                                <span class="inline-block w-8 h-[2px] <?= $borderClass ?> rounded transition-all duration-300 group-hover:w-16"></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
                <div class="text-center py-10 text-white/50 mb-16">No categories found.</div>
            <?php endif; ?>

            <div
                class="bg-white/10 backdrop-blur-md border-l-4 border-blue-400 p-6 md:p-8 rounded-r-2xl max-w-4xl mx-auto flex flex-col md:flex-row items-center md:items-start text-center md:text-left gap-4 md:gap-0 shadow-lg mb-12">
                <svg class="w-10 h-10 text-blue-300 mb-4 md:mb-0 md:mr-6 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg text-blue-100 italic leading-relaxed">
                    "Each product is developed with precision and care to ensure safety, effectiveness, and absolute
                    consistency from our labs to your hands."
                </p>
            </div>

            <div class="text-center">
                <a href="products.php"
                    class="group inline-flex items-center gap-3 px-10 py-4 rounded-full font-bold text-white text-sm tracking-wider transition-all duration-300 hover:-translate-y-1 hover:scale-105 shadow-[0_8px_32px_rgba(37,99,235,0.25)] border border-white/10"
                    style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                    <span>Explore All Products</span>
                    <svg class="w-4 h-4 text-white transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Quality Assurance -->
    <section class="py-16 md:py-32 bg-white overflow-hidden">
        <div class="container mx-auto px-6 reveal flex flex-col md:flex-row items-center gap-10 md:gap-16">
            <div class="md:w-1/2">
                <h3 class="text-green-500 font-bold tracking-widest uppercase mb-4">Quality Assurance</h3>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 mb-6">Quality You Can Trust</h2>
                <div class="w-20 h-1 bg-blue-600 mb-8 rounded"></div>
                <p class="text-xl text-slate-600 leading-relaxed mb-8">
                    At MaasCure Pharmaceutical Private Limited, quality is at the core of everything we do.
                </p>
                <p class="text-lg text-slate-500 leading-relaxed">
                    We follow stringent manufacturing practices and rigorous testing procedures to ensure that every
                    product meets the highest standards of safety and efficacy. Nothing leaves our facility without
                    multiple layers of verification.
                </p>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-slate-200 to-green-100 rounded-3xl blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                    <img src="assets/hero_banner.png" alt="Quality Assurance Executive" class="relative rounded-2xl shadow-2xl border border-white/20 max-w-full h-auto transform transition-all duration-500 hover:scale-105 hover:-rotate-1" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Preview -->
    <section class="py-16 md:py-32 bg-slate-50 relative overflow-hidden border-t border-slate-200">
        <div class="container mx-auto px-6 relative z-10 reveal">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <div
                    class="bg-white p-6 sm:p-12 lg:p-16 rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl transition-all group relative overflow-hidden">
                    <div
                        class="absolute -right-10 -top-10 w-40 h-40 bg-blue-50 rounded-full opacity-50 group-hover:scale-[2.5] transition-transform duration-700">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-blue-600/30">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-900 mb-6 italic">Our Vision</h3>
                        <p class="text-slate-600 text-xl leading-relaxed">
                            To be a trusted name in the pharmaceutical industry, delivering excellence in healthcare
                            solutions across India.
                        </p>
                    </div>
                </div>
                <div
                    class="bg-white p-6 sm:p-12 lg:p-16 rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl transition-all group relative overflow-hidden">
                    <div
                        class="absolute -right-10 -top-10 w-40 h-40 bg-green-50 rounded-full opacity-50 group-hover:scale-[2.5] transition-transform duration-700">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 bg-green-500 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-green-500/30">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-900 mb-6 italic">Our Mission</h3>
                        <ul class="space-y-4 text-slate-600 text-lg">
                            <li class="flex items-start"><span class="text-green-500 mr-4 font-bold text-xl">✔</span> To
                                provide safe and effective medicines</li>
                            <li class="flex items-start"><span class="text-green-500 mr-4 font-bold text-xl">✔</span> To
                                ensure affordability and accessibility</li>
                            <li class="flex items-start"><span class="text-green-500 mr-4 font-bold text-xl">✔</span> To
                                maintain the highest quality standards</li>
                            <li class="flex items-start"><span class="text-green-500 mr-4 font-bold text-xl">✔</span> To
                                continuously innovate for better healthcare</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Science & Innovation Section: The Nexus of Innovation -->
    <section id="science" class="relative py-20 md:py-28 bg-slate-950 overflow-hidden text-white border-t border-slate-900">
        <!-- Ambient Video Background -->
        <div class="absolute inset-0 z-0">
            <video autoplay loop muted playsinline class="w-full h-full object-cover opacity-30">
                <source src="assets/laboratory.mp4" type="video/mp4">
            </video>
            <!-- Overlay and radial spotlight -->
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950 via-slate-950/90 to-slate-950"></div>
            <div class="absolute inset-0" style="background: radial-gradient(circle at center, rgba(13,148,136,0.1) 0%, transparent 70%);"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                <span class="inline-block px-4 py-1.5 rounded-full bg-teal-500/10 border border-teal-500/20 text-teal-400 font-extrabold tracking-[0.2em] uppercase text-[10px] mb-4">
                    Research & Development
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-white mb-6 tracking-tight italic">
                    Science & <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-blue-400">Innovation</span>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-teal-500 to-blue-500 mx-auto rounded mb-6"></div>
                <p class="text-slate-400 text-lg leading-relaxed font-medium">
                    Advancing healthcare through cutting-edge research, scientific excellence, and continuous innovation.
                </p>
            </div>

            <!-- Innovation Cards (4 Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16 reveal">
                <!-- Card 1 -->
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 transition-all duration-500 hover:scale-[1.03] hover:bg-white/10 hover:border-teal-500/30 group hover:shadow-[0_15px_30px_rgba(13,148,136,0.1)]">
                    <div class="w-12 h-12 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center text-2xl font-bold mb-5 transition-transform duration-500 group-hover:scale-115 group-hover:bg-teal-500 group-hover:text-white">
                        🧪
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3 transition-colors duration-300 group-hover:text-teal-400">Advanced Research</h4>
                    <p class="text-slate-400 text-sm leading-relaxed group-hover:text-slate-300 transition-colors">
                        Developing innovative pharmaceutical formulations through scientific expertise.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 transition-all duration-500 hover:scale-[1.03] hover:bg-white/10 hover:border-blue-500/30 group hover:shadow-[0_15px_30px_rgba(59,130,246,0.1)]">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-2xl font-bold mb-5 transition-transform duration-500 group-hover:scale-115 group-hover:bg-blue-500 group-hover:text-white">
                        🔬
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3 transition-colors duration-300 group-hover:text-blue-400">Modern Laboratories</h4>
                    <p class="text-slate-400 text-sm leading-relaxed group-hover:text-slate-300 transition-colors">
                        Equipped with advanced testing and quality assurance technologies.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 transition-all duration-500 hover:scale-[1.03] hover:bg-white/10 hover:border-teal-500/30 group hover:shadow-[0_15px_30px_rgba(13,148,136,0.1)]">
                    <div class="w-12 h-12 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center text-2xl font-bold mb-5 transition-transform duration-500 group-hover:scale-115 group-hover:bg-teal-500 group-hover:text-white">
                        ⚙️
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3 transition-colors duration-300 group-hover:text-teal-400">Smart Manufacturing</h4>
                    <p class="text-slate-400 text-sm leading-relaxed group-hover:text-slate-300 transition-colors">
                        Precision-driven production processes ensuring consistency and safety.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 transition-all duration-500 hover:scale-[1.03] hover:bg-white/10 hover:border-blue-500/30 group hover:shadow-[0_15px_30px_rgba(59,130,246,0.1)]">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-2xl font-bold mb-5 transition-transform duration-500 group-hover:scale-115 group-hover:bg-blue-500 group-hover:text-white">
                        ❤️
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3 transition-colors duration-300 group-hover:text-blue-400">Patient-Focused Innovation</h4>
                    <p class="text-slate-400 text-sm leading-relaxed group-hover:text-slate-300 transition-colors">
                        Creating healthcare solutions that improve lives and patient outcomes.
                    </p>
                </div>
            </div>

            <!-- Highlights / Statistics Section -->
            <div class="bg-gradient-to-r from-slate-900 via-white/5 to-slate-900 border border-white/5 rounded-3xl p-8 md:p-12 mb-16 reveal shadow-xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-white/5">
                    <!-- Stat 1 -->
                    <div class="pt-6 md:pt-0">
                        <span class="block text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-blue-400 tracking-tight mb-2 sci-counter" data-target="50">0</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Innovative Formulations</span>
                    </div>
                    <!-- Stat 2 -->
                    <div class="pt-6 md:pt-0">
                        <span class="block text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-blue-400 tracking-tight mb-2 sci-counter-decimal" data-target="99.9">0</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Quality Accuracy</span>
                    </div>
                    <!-- Stat 3 -->
                    <div class="pt-6 md:pt-0">
                        <span class="block text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-blue-400 tracking-tight mb-2 sci-counter" data-target="25">0</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Therapeutic Solutions</span>
                    </div>
                </div>
            </div>

            <!-- Mini Process Timeline Section -->
            <div class="reveal">
                <h3 class="text-center text-xs font-bold text-teal-400 tracking-widest uppercase mb-12">Innovation Journey</h3>
                
                <!-- Horizontal/Vertical Timeline Wrapper -->
                <div class="relative max-w-5xl mx-auto px-4">
                    <!-- Progress Connecting Line (Desktop Only) -->
                    <div class="hidden lg:block absolute top-[27px] left-8 right-8 h-1 bg-gradient-to-r from-teal-500/25 via-blue-500/25 to-teal-500/25 z-0 rounded-full">
                        <div class="h-full bg-gradient-to-r from-teal-500 via-blue-500 to-teal-500 rounded-full animate-pulse" style="width: 100%;"></div>
                    </div>
                    
                    <div class="flex flex-col lg:flex-row justify-between gap-10 lg:gap-4 relative z-10">
                        <!-- Step 1 -->
                        <div class="flex-1 flex flex-row lg:flex-col items-center lg:items-center text-left lg:text-center group">
                            <!-- Node Circle -->
                            <div class="w-14 h-14 rounded-full bg-slate-900 border-2 border-teal-500 text-teal-400 flex items-center justify-center text-xl font-bold shrink-0 shadow-lg shadow-teal-500/10 z-10 transition-all duration-300 group-hover:scale-110 group-hover:border-white group-hover:shadow-white/20">
                                01
                            </div>
                            <!-- Text Block -->
                            <div class="ml-6 lg:ml-0 lg:mt-6">
                                <h5 class="font-extrabold text-white text-base tracking-wide group-hover:text-teal-400 transition-colors">Research</h5>
                                <p class="text-slate-400 text-xs mt-1 leading-relaxed max-w-xs mx-auto">Identifying molecule targets & potential solutions.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex-1 flex flex-row lg:flex-col items-center lg:items-center text-left lg:text-center group">
                            <div class="w-14 h-14 rounded-full bg-slate-900 border-2 border-blue-500 text-blue-400 flex items-center justify-center text-xl font-bold shrink-0 shadow-lg shadow-blue-500/10 z-10 transition-all duration-300 group-hover:scale-110 group-hover:border-white group-hover:shadow-white/20">
                                02
                            </div>
                            <div class="ml-6 lg:ml-0 lg:mt-6">
                                <h5 class="font-extrabold text-white text-base tracking-wide group-hover:text-blue-400 transition-colors">Development</h5>
                                <p class="text-slate-400 text-xs mt-1 leading-relaxed max-w-xs mx-auto">Synthesizing formulations & chemical prototypes.</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex-1 flex flex-row lg:flex-col items-center lg:items-center text-left lg:text-center group">
                            <div class="w-14 h-14 rounded-full bg-slate-900 border-2 border-teal-500 text-teal-400 flex items-center justify-center text-xl font-bold shrink-0 shadow-lg shadow-teal-500/10 z-10 transition-all duration-300 group-hover:scale-110 group-hover:border-white group-hover:shadow-white/20">
                                03
                            </div>
                            <div class="ml-6 lg:ml-0 lg:mt-6">
                                <h5 class="font-extrabold text-white text-base tracking-wide group-hover:text-teal-400 transition-colors">Testing</h5>
                                <p class="text-slate-400 text-xs mt-1 leading-relaxed max-w-xs mx-auto">Pre-clinical evaluations & trial validation.</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex-1 flex flex-row lg:flex-col items-center lg:items-center text-left lg:text-center group">
                            <div class="w-14 h-14 rounded-full bg-slate-900 border-2 border-blue-500 text-blue-400 flex items-center justify-center text-xl font-bold shrink-0 shadow-lg shadow-blue-500/10 z-10 transition-all duration-300 group-hover:scale-110 group-hover:border-white group-hover:shadow-white/20">
                                04
                            </div>
                            <div class="ml-6 lg:ml-0 lg:mt-6">
                                <h5 class="font-extrabold text-white text-base tracking-wide group-hover:text-blue-400 transition-colors">Validation</h5>
                                <p class="text-slate-400 text-xs mt-1 leading-relaxed max-w-xs mx-auto">Rigorous audits & standard compliance checks.</p>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="flex-1 flex flex-row lg:flex-col items-center lg:items-center text-left lg:text-center group">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-r from-teal-500 to-blue-500 text-white flex items-center justify-center text-xl font-bold shrink-0 shadow-lg shadow-teal-500/20 z-10 transition-all duration-300 group-hover:scale-110 group-hover:border-white group-hover:shadow-white/30">
                                05
                            </div>
                            <div class="ml-6 lg:ml-0 lg:mt-6">
                                <h5 class="font-extrabold text-white text-base tracking-wide group-hover:text-teal-400 transition-colors">Solutions</h5>
                                <p class="text-slate-400 text-xs mt-1 leading-relaxed max-w-xs mx-auto">Releasing patient-centric, reliable healthcare.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Interactive functions for Science Section Counters
        document.addEventListener('DOMContentLoaded', () => {
            const animateCounters = () => {
                const counters = document.querySelectorAll('.sci-counter');
                const decimalCounters = document.querySelectorAll('.sci-counter-decimal');

                const observerOptions = {
                    root: null,
                    threshold: 0.3
                };

                const startCounting = (counter, target, isDecimal = false) => {
                    let start = 0;
                    const duration = 2000;
                    const stepTime = 30;
                    const steps = duration / stepTime;
                    const increment = target / steps;

                    const timer = setInterval(() => {
                        start += increment;
                        if (start >= target) {
                            clearInterval(timer);
                            counter.innerText = isDecimal ? target.toFixed(1) + '%' : Math.floor(target) + '+';
                        } else {
                            counter.innerText = isDecimal ? start.toFixed(1) + '%' : Math.floor(start) + '+';
                        }
                    }, stepTime);
                };

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const counter = entry.target;
                            const target = parseFloat(counter.getAttribute('data-target'));
                            const isDecimal = counter.classList.contains('sci-counter-decimal');
                            startCounting(counter, target, isDecimal);
                            observer.unobserve(counter);
                        }
                    });
                }, observerOptions);

                counters.forEach(counter => observer.observe(counter));
                decimalCounters.forEach(counter => observer.observe(counter));
            };

            animateCounters();
        });
    </script>


    <!-- Call to Action (Card Layout) -->
    <section class="py-16 md:py-24 bg-slate-50 relative overflow-hidden border-t border-slate-200/50">
        <div class="container mx-auto px-6 max-w-6xl relative z-10 reveal">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.03)] overflow-hidden grid grid-cols-1 lg:grid-cols-12 items-stretch">
                <!-- Left Column: Content Info -->
                <div class="lg:col-span-6 p-8 sm:p-12 lg:p-16 flex flex-col justify-center text-left">
                    <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mb-6 leading-tight tracking-tight">
                        Join us, <br>fuel the future.
                    </h2>
                    <p class="text-base text-slate-500 leading-relaxed mb-8">
                        MaasCure is not just a workplace. It's a frontier of innovation. And by joining us, you will be one of the trailblazers using science to shape a healthier Bharat.
                    </p>
                    
                    <!-- Checklist -->
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-start space-x-4 text-slate-700">
                            <span class="w-6 h-6 rounded-full bg-[#008be5] flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span class="font-medium text-sm md:text-base text-slate-600">Nurturing growth in a national-class environment</span>
                        </li>
                        <li class="flex items-start space-x-4 text-slate-700">
                            <span class="w-6 h-6 rounded-full bg-[#008be5] flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span class="font-medium text-sm md:text-base text-slate-600">Industry-leading compensation and perks</span>
                        </li>
                        <li class="flex items-start space-x-4 text-slate-700">
                            <span class="w-6 h-6 rounded-full bg-[#008be5] flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span class="font-medium text-sm md:text-base text-slate-600">Innovation that impacts Indian healthcare</span>
                        </li>
                    </ul>
                    
                    <div>
                        <a href="contact.html"
                            class="inline-block px-8 py-4 bg-[#001894] hover:bg-[#001270] text-white rounded-full font-bold text-xs uppercase tracking-wider transition-all duration-300 hover:shadow-xl hover:shadow-[#001894]/20 hover:-translate-y-0.5 active:translate-y-0 shadow-md">
                            GET IN TOUCH
                        </a>
                    </div>
                </div>

                <!-- Right Column: Video Container -->
                <div class="lg:col-span-6 relative min-h-[350px] lg:min-h-full overflow-hidden rounded-b-[2rem] lg:rounded-r-[2rem] lg:rounded-bl-none">
                    <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover rounded-b-[2rem] lg:rounded-r-[2rem] lg:rounded-bl-none">
                        <source src="assets/experiment.mp4" type="video/mp4">
                        <source src="assets/laboratory.mp4" type="video/mp4">
                        <img src="assets/contact.png" alt="Partner With Us" class="w-full h-full object-cover rounded-b-[2rem] lg:rounded-r-[2rem] lg:rounded-bl-none">
                    </video>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder" class="mt-auto w-full"></div>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
</body>

</html>