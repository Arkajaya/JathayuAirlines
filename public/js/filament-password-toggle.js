document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input[data-password-toggle]');
    let uid = 0;

    inputs.forEach((input) => {
        uid += 1;
        if (!input.id) {
            input.id = `filament-password-${uid}`;
        }
        // create toggle button
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.setAttribute('aria-label', 'Toggle password visibility');
        btn.className = 'filament-password-toggle';
        btn.style.border = 'none';
        btn.style.background = 'transparent';
        btn.style.cursor = 'pointer';
        btn.style.padding = '0';
        btn.style.marginLeft = '-2.5rem';
        btn.style.marginTop = '0.4rem';
        btn.style.display = 'inline-flex';
        btn.style.alignItems = 'center';
        btn.style.justifyContent = 'center';
        btn.style.width = '1.25rem';
        btn.style.height = '1.25rem';

        // eye open
        const svgOpen = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svgOpen.setAttribute('viewBox', '0 0 20 20');
        svgOpen.setAttribute('fill', 'currentColor');
        svgOpen.setAttribute('width', '20');
        svgOpen.setAttribute('height', '20');
        svgOpen.innerHTML = '<path d="M10 3C6 3 2.73 5.11 1 8.5 2.73 11.89 6 14 10 14s7.27-2.11 9-5.5C17.27 5.11 14 3 10 3zM10 12a2 2 0 110-4 2 2 0 010 4z" />';

        // eye closed
        const svgClosed = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svgClosed.setAttribute('viewBox', '0 0 20 20');
        svgClosed.setAttribute('fill', 'currentColor');
        svgClosed.setAttribute('width', '20');
        svgClosed.setAttribute('height', '20');
        svgClosed.style.display = 'none';
        svgClosed.innerHTML = '<path d="M3.172 3.172a4 4 0 015.656 0L10 4.343l1.172-1.171a4 4 0 115.656 5.656L10 16.657 3.172 9.83a4 4 0 010-5.657z" />';

        btn.appendChild(svgOpen);
        btn.appendChild(svgClosed);

        // try to place button after input
        if (input.parentNode) {
            // make parent relative to position absolute elements if not already
            const parent = input.parentNode;
            const computed = window.getComputedStyle(parent);
            if (computed.position === 'static') {
                parent.style.position = 'relative';
            }
            btn.style.position = 'absolute';
            btn.style.right = '0.75rem';
            btn.style.top = '0.9rem';
            parent.appendChild(btn);
        } else {
            input.insertAdjacentElement('afterend', btn);
        }

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (input.type === 'password') {
                input.type = 'text';
                svgOpen.style.display = 'none';
                svgClosed.style.display = '';
            } else {
                input.type = 'password';
                svgOpen.style.display = '';
                svgClosed.style.display = 'none';
            }
        });
    });
});
