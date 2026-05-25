import './bootstrap';
import { animate, svg, stagger } from 'animejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);
const { createMotionPath, createDrawable } = svg;

document.addEventListener('DOMContentLoaded', () => {
    // --- Loader Animations ---
    const loader = document.getElementById('lux-loader');
    if (loader) {
        // SVG Loader replaced with Anime.js Creature
    }


    // Reveal Animations using Intersection Observer
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => {
        observer.observe(el);
    });

    // GSAP Scroll Journey Line Animation
    const journeyTrack = document.querySelector('.gsap-journey-track');
    if (journeyTrack) {
        // Draw the line down the screen
        gsap.to('.gsap-journey-progress', {
            scaleY: 1,
            ease: "none",
            scrollTrigger: {
                trigger: document.documentElement,
                start: "top top",
                end: "bottom bottom",
                scrub: true
            }
        });

        // Move the glowing node along with the end of the line
        gsap.to('.gsap-journey-node', {
            y: () => window.innerHeight,
            ease: "none",
            scrollTrigger: {
                trigger: document.documentElement,
                start: "top top",
                end: "bottom bottom",
                scrub: true
            }
        });
        
        // Fade in the node as soon as user starts scrolling
        gsap.to('.gsap-journey-node', {
            opacity: 1,
            duration: 0.3,
            scrollTrigger: {
                trigger: document.documentElement,
                start: "100px top",
                toggleActions: "play none none reverse"
            }
        });
    }

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 150,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Theme Toggle Logic
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    const themeIcon = themeToggle ? themeToggle.querySelector('i') : null;

    if (themeToggle) {
        const currentTheme = localStorage.getItem('theme') || 'dark';
        html.setAttribute('data-theme', currentTheme);
        updateThemeIcon(currentTheme);

        themeToggle.addEventListener('click', () => {
            const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }

    function updateThemeIcon(theme) {
        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            } else {
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
        }
    }

    // Custom Cursor Logic
    const dot = document.querySelector('.cursor-dot');
    const outline = document.querySelector('.cursor-outline');

    if (dot && outline) {
        window.addEventListener('mousemove', (e) => {
            const posX = e.clientX;
            const posY = e.clientY;

            dot.style.left = `${posX}px`;
            dot.style.top = `${posY}px`;

            outline.animate({
                left: `${posX}px`,
                top: `${posY}px`
            }, { duration: 500, fill: "forwards" });
        });

        // Cursor Hover Effect
        const interactables = document.querySelectorAll('a, button, .card');
        interactables.forEach(el => {
            el.addEventListener('mouseenter', () => outline.classList.add('cursor-hover'));
            el.addEventListener('mouseleave', () => outline.classList.remove('cursor-hover'));
        });
    }

    // Hide Loader when page is fully loaded
    window.addEventListener('load', () => {
        const luxLoader = document.getElementById('lux-loader');
        if (luxLoader) {
            setTimeout(() => {
                // Fade out content
                animate('.lux-loader-content', {
                    opacity: 0,
                    scale: 0.9,
                    filter: 'blur(10px)'
                }, {
                    duration: 600,
                    ease: 'in-out-sine'
                });

                // Open curtains
                animate('.curtain-top', {
                    translateY: '-100%'
                }, {
                    duration: 1000,
                    delay: 300,
                    ease: 'in-out-expo'
                });

                animate('.curtain-bottom', {
                    translateY: '100%'
                }, {
                    duration: 1000,
                    delay: 300,
                    ease: 'in-out-expo'
                }).then(() => {
                    luxLoader.remove();
                    document.body.style.overflow = '';
                });
            }, 1000);
        }
    });

    // Mobile Menu Toggle
    const mobileToggle = document.getElementById('mobile-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            const icon = mobileToggle.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.replace('fa-bars', 'fa-times');
            } else {
                icon.classList.replace('fa-times', 'fa-bars');
            }
        });

        // Close menu when clicking a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                mobileToggle.querySelector('i').classList.replace('fa-times', 'fa-bars');
            });
        });
    }
});

