const calendar = document.getElementById('calendar');
const currentMonthYear = document.getElementById('currentMonthYear');
const prevMonthBtn = document.getElementById('prevMonth');
const nextMonthBtn = document.getElementById('nextMonth');

const today = new Date();
const initialMonth = today.getMonth();
const initialYear = today.getFullYear();

let currentMonth = initialMonth;
let currentYear = initialYear;
let selectedDay = { day: today.getDate(), month: currentMonth, year: currentYear };

const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];


// Al volver desde el historial del navegador, forzar la inicialización correcta
window.addEventListener("pageshow", function () {
    currentMonth = initialMonth;
    currentYear = initialYear;
    renderCalendar(currentMonth, currentYear);
});

function copiarFecha(fecha){
    let c_dia = selectedDay.day;
    let c_mes = selectedDay.month;
    let c_ano= selectedDay.year;
    let copia = {day: c_dia, month: c_mes, year: c_ano};
    return copia;
}

function formatDate(selectedDay) {
    const year = selectedDay.year;
    const month = String(selectedDay.month).padStart(2, '0'); // Asegura que el mes tenga dos dígitos
    const day = String(selectedDay.day).padStart(2, '0'); // Asegura que el día tenga dos dígitos
    return `${year}-${month}-${day}`; // Formato YYYY-MM-DD
}

function renderCalendar(month, year) {
    calendar.innerHTML = '';

    currentMonthYear.textContent = `${months[month]} ${year}`;

    const firstDay = new Date(year, month).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    const dayLabels = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
    dayLabels.forEach(label => {
        const dayLabelElement = document.createElement('div');
        dayLabelElement.className = 'day-label';
        dayLabelElement.textContent = label;
        calendar.appendChild(dayLabelElement);
    });

    for (let i = 0; i < firstDay; i++) {
        const emptyDiv = document.createElement('div');
        calendar.appendChild(emptyDiv);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.className = 'day';
        dayElement.textContent = day;

        if (day === selectedDay.day && month === selectedDay.month && year === selectedDay.year) {
            dayElement.classList.add('selected-day');
        }

        dayElement.addEventListener('click', () => {
            updateSelectedDay(day, month, year);
        });

        calendar.appendChild(dayElement);
    }
}

function updateSelectedDay(day, month, year) {
    selectedDay = { day, month, year };
    console.log("Se actualizo el dia a: " + day+month + year);
    renderCalendar(currentMonth, currentYear);
}

prevMonthBtn.addEventListener('click', () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    renderCalendar(currentMonth, currentYear);
});

nextMonthBtn.addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar(currentMonth, currentYear);
});
renderCalendar(currentMonth, currentYear);