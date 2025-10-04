<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctxTotal = document.getElementById('chartTotal').getContext('2d');
    const ctxToday = document.getElementById('chartToday').getContext('2d');

    const totalData = {
        labels: ['Propiedades', 'Vendedores', 'Usuarios', 'Auditorías'],
        datasets: [{
            label: 'Total',
            data: [
                {{ $stats['total_properties'] }},
                {{ $stats['total_sellers'] }},
                {{ $stats['total_users'] }},
                {{ $stats['total_audits'] }}
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    };

    const todayData = {
        labels: ['Propiedades', 'Vendedores', 'Usuarios', 'Auditorías'],
        datasets: [{
            label: 'Hoy',
            data: [
                {{ $stats['properties_today'] }},
                {{ $stats['sellers_today'] }},
                {{ $stats['users_today'] }},
                {{ $stats['audits_today'] }}
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    };

    const configTotal = {
        type: 'bar',
        data: totalData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    };

    const configToday = {
        type: 'bar',
        data: todayData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    };

    new Chart(ctxTotal, configTotal);
    new Chart(ctxToday, configToday);
});
</script>
