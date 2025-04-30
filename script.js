
function updateDateTime() {
    const dateDisplay = document.querySelector('.date-display');
    const timeDisplay = document.querySelector('.time-display');

    const now = new Date();
    const date = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
    const time = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });

    if (dateDisplay) {
        dateDisplay.textContent = date; // Tampilkan tanggal
    }
    if (timeDisplay) {
        timeDisplay.textContent = time; // Tampilkan waktu
    }
}

