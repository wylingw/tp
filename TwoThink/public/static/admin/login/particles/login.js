document.onreadystatechange = function () {
    particlesJS('particles-js', {
        particles: {
            color: '#FFF',
            shape: 'triangle', // "circle", "edge" or "triangle"
            opacity: 1,
            size: 4,
            size_random: true,
            nb: 150,
            line_linked: {
                enable_auto: true,
                distance: 180,
                color: '#FFF',
                opacity: 1,
                width: 1,
                condensed_mode: {
                    enable: false,
                    rotateX: 600,
                    rotateY: 600
                }
            },
            anim: {
                enable: true,
                speed: 1
            }
        },
        interactivity: {
            enable: true,
            mouse: {
                distance: 250
            },
            detect_on: 'window', // "canvas" or "window"
            mode: 'grab',
            line_linked: {
                opacity: .5
            },
            events: {
                onclick: {
                    enable: true,
                    mode: 'push', // "push" or "remove" (particles)
                    nb: 4
                }
            }
        },
        /* Retina Display Support */
        retina_detect: true
    });
};