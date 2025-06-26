// ------------------ Haftalık Randevu Grafiği (Bar Chart) ------------------
const ctx1 = document.getElementById('haftalikRandevu').getContext('2d'); // Canvas elemanının 2D çizim bağlamını alır
const haftalikRandevu = new Chart(ctx1, { // Yeni bir Chart (grafik) nesnesi oluşturulur
    type: 'bar', // Grafik tipi çubuk grafik
    data: {
        labels: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'], // X eksenindeki günler
        datasets: [{
            label: 'Randevu Sayısı', // Grafiğin başlığı/etiketi
            data: [12, 19, 3, 5, 2, 3, 7], // Günlere karşılık gelen randevu sayıları
            backgroundColor: [ // Her çubuğun dolgu rengi
                'rgba(54, 75, 99, 1)',
                'rgba(88, 129, 87, 1)',
                'rgba(198, 151, 66, 1)',
                'rgba(110, 110, 110, 1)',
                'rgba(38, 38, 38, 1)',
                'rgba(167, 83, 32, 1)',
                'rgba(255, 111, 0, 1)'
            ],
            borderColor: [ // Her çubuğun kenar çizgi rengi
                'rgba(44, 61, 79, 1)',
                'rgba(68, 99, 67, 1)',
                'rgba(168, 121, 36, 1)',
                'rgba(80, 80, 80, 1)',
                'rgba(20, 20, 20, 1)',
                'rgba(137, 53, 2, 1)',
                'rgba(225, 81, 0, 1)'
            ],
            borderWidth: 1 // Kenar çizgi kalınlığı
        }]
    },
    options: {
        responsive: true, // Grafik ekran boyutuna göre otomatik uyum sağlar
        plugins: {
            legend: { position: 'top' }, // Grafik başlığının yeri (üstte)
            title: {
                display: true, // Başlık gösterilsin mi?
                text: 'Haftalık Randevu Sayısı' // Başlık metni
            }
        },
        scales: {
            y: {
                beginAtZero: true // Y ekseni sıfırdan başlasın
            }
        }
    }
});




// ------------------ Traktör Markaları Donut (Halka) Grafiği ------------------
const ctx2 = document.getElementById('traktorMarkaDonut').getContext('2d'); // Canvas bağlamı
const traktorMarkaDonut = new Chart(ctx2, {
    type: 'doughnut', // Grafik tipi: halka grafik
    data: {
        labels: ['New Holland', 'John Deere', 'Massey Ferguson', 'Case IH', 'Deutz-Fahr'], // Marka isimleri
        datasets: [{
            label: 'Kayıtlı Traktör Markaları',
            data: [10, 7, 5, 8, 4], // Her markaya ait traktör sayısı
            backgroundColor: [ // Dilimlerin rengi
                'rgb(9, 42, 205)',
                'rgb(6, 146, 1)',
                'rgb(192, 0, 0)',
                'rgb(255, 0, 0)',
                'rgb(74, 250, 47)'
            ],
            borderColor: [ // Dilim kenarlığı (genellikle aynıdır)
                'rgb(9, 42, 205)',
                'rgb(6, 146, 1)',
                'rgb(192, 0, 0)',
                'rgb(255, 0, 0)',
                'rgb(74, 250, 47)'
            ],
            borderWidth: 1 // Kenarlık kalınlığı
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }, // Açıklama alt kısımda gösterilir
            title: {
                display: true,
                text: 'Servise Kayıtlı Traktör Markaları' // Grafik başlığı
            }
        }
    }
});





// ------------------ Haftalık Kazanç Grafiği (Line) ------------------
new Chart(document.getElementById('haftalikKazanc').getContext('2d'), {
    type: 'line', // Çizgi grafik
    data: {
        labels: ['Pzt', 'Salı', 'Çarş', 'Perş', 'Cuma', 'Ctesi', 'Pazar'], // Günler
        datasets: [{
            label: 'Haftalık Kazanç (₺)',
            data: [800, 950, 700, 900, 1200, 1100, 600], // Günlük kazanç verileri
            borderColor: 'rgba(255, 99, 132, 1)', // Çizgi rengi
            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Dolgu rengi (altı)
            tension: 0.3 // Çizgilerin kıvrıklığı (0 = köşeli, 1 = yumuşak)
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Haftalık Kazanç'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});




// ------------------ Aylık Kazanç Grafiği ------------------
new Chart(document.getElementById('aylikKazanc').getContext('2d'), {
    type: 'line',
    data: {
        labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: 'Aylık Kazanç (₺)',
            data: [4500, 5200, 6100, 7000, 6750, 6900, 7200, 8000, 8500, 9000, 9500, 10000, 11000], // Her aya ait gelir
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            tension: 0.3
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Aylık Kazanç'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});





// ------------------ Yıllık Kazanç Grafiği ------------------
new Chart(document.getElementById('yillikKazanc').getContext('2d'), {
    type: 'line',
    data: {
        labels: ['2024', '2025', '2026', '2027', '2028'], // Yıllar
        datasets: [{
            label: 'Yıllık Kazanç (₺)',
            data: [42000, 48000, 51000, 58000, 62000], // Yıllık gelir verileri
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.3
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Yıllık Kazanç'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});






// ------------------ Kritik Stok Grafiği (Yatay Bar) ------------------
const ctx = document.getElementById('kritikStokChart').getContext('2d'); // Canvas bağlamı
const kritikStokChart = new Chart(ctx, {
    type: 'bar', // Grafik tipi çubuk (ama yatay olarak ayarlanacak)
    data: {
        labels: ['Yağ Filtresi', 'Hava Filtresi', 'Debriyaj Balatası', 'Hidrolik Yağ', 'Mazot Filtresi'], // Parça isimleri
        datasets: [{
            label: 'Stok Adedi', // Y ekseni başlığı
            data: [2, 1, 3, 0, 1], // Parçaların stok miktarı
            backgroundColor: 'rgba(194, 1, 1, 0.95)', // Kırmızımsı dolgu: kritik seviyeyi vurgular
            borderColor: 'rgb(4, 57, 101)', // Çerçeve rengi
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y', // Bu ayar sayesinde grafik yatay çubuk haline gelir
        responsive: true,
        plugins: {
            legend: { display: false }, // Açıklama gösterilmez çünkü tek veri kümesi var
            title: {
                display: true,
                text: 'Kritik Stok Seviyesindeki Yedek Parçalar'
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Stok Adedi' // X eksenine başlık
                }
            }
        }
    }
});
