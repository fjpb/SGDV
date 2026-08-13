import Chart from 'chart.js/auto';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './tabler';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    if (calendarEl) {

        const calendar = new Calendar(calendarEl, {

            plugins: [dayGridPlugin],

            initialView: 'dayGridMonth',

            locale: 'es',

            height: 700,

            events: '/calendar/events'

        });

        calendar.render();

    }

    const chartElement = document.getElementById('documentStatusChart');

    if (chartElement) {

        new Chart(chartElement, {

            type: 'doughnut',

            data: {

                labels: [
                    'Vigentes',
                    'Por vencer',
                    'Vencidos'
                ],

                datasets: [{

                    data: [
                        window.documentStatus.vigentes,
                        window.documentStatus.porVencer,
                        window.documentStatus.vencidos
                    ],

                    backgroundColor: [
                        '#2fb344',
                        '#f59f00',
                        '#d63939'
                    ]

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        position: 'bottom'

                    }

                }

            }

        });

    }

});

/*
|--------------------------------------------------------------------------
| SGDV PWA
|--------------------------------------------------------------------------
*/

if ('serviceWorker' in navigator) {

    window.addEventListener('load', async () => {

        try {

            const registration = await navigator.serviceWorker.register('/sw.js');

            console.log('SGDV PWA registrada', registration.scope);

        } catch (error) {

            console.error('No fue posible registrar el Service Worker', error);

        }

    });

}
