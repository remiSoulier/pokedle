import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    const input = document.getElementById('pokemon-input');
    const suggestions = document.getElementById('suggestions');

    if (!input) return;

    input.addEventListener('input', async () => {

        const query = input.value;

        if (query.length < 2) {
            suggestions.classList.add('hidden');
            return;
        }

        const response = await fetch(`/pokemon-search?q=${query}`);
        const data = await response.json();

        suggestions.innerHTML = '';

        if (data.length === 0) {
            suggestions.classList.add('hidden');
            return;
        }

        data.forEach(name => {
            const div = document.createElement('div');
            div.textContent = name;
            div.className = "px-3 py-2 cursor-pointer hover:bg-gray-100";

            div.addEventListener('click', () => {
                input.value = name;
                suggestions.classList.add('hidden');
            });

            suggestions.appendChild(div);
        });

        suggestions.classList.remove('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!input.contains(e.target)) {
            suggestions.classList.add('hidden');
        }
    });

});
