document.getElementById('weatherForm').addEventListener('submit', function (event) {
    event.preventDefault();

    let location = document.getElementById('locationInput').value.trim();

    let apiKey = 'VWPQUA956H2DT9WQA8T9SV9LF';
    let apiUrl = `https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${encodeURIComponent(location)}?unitGroup=metric&key=${apiKey}&include=current`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {

            let weatherDiv = document.getElementById('weather');
            if (data && data.currentConditions) {
                let currentConditions = data.currentConditions;
                let currentWeatherHtml = `
                    <h3>El tiempo actual en ${location}:</h3>
                    <p>Temperatura: ${currentConditions.temp} °C</p>
                    <p>Condiciones: ${currentConditions.conditions}</p>
                    <p>Viento: ${currentConditions.windspeed} km/h</p>
                    <p>Humedad: ${currentConditions.humidity}%</p>
                    <p>Presión Atmosférica: ${currentConditions.pressure} hPa</p>
                `;
                weatherDiv.innerHTML = currentWeatherHtml;

                if (currentConditions.temp < 15) {
                    currentWeatherHtml += `<p style="color: red;">No recomendado: Hace demasiado frío como para nadar, incluso con neopreno.</p>`;
                } else if (currentConditions.temp >= 15 && (currentConditions.temp < 20)){
                    currentWeatherHtml += `<p style="color: blue;">Recomendado: Solo se recomienda nadar usando neopreno.</p>`;
                }else{
                    currentWeatherHtml += `<p style="color: green;">Recomendado: Tiempo perfecto para entrenar aguas abiertas, con o sin neopreno.</p>`;
                }

                weatherDiv.innerHTML = currentWeatherHtml;
            } else {
                weatherDiv.innerHTML = `<p>No se encontraron datos de clima para ${location}</p>`;
            }
        })
        .catch(error => {
            console.error('Error al obtener los datos del clima:', error);
            let weatherDiv = document.getElementById('weather');
            weatherDiv.innerHTML = `<p>Error al obtener datos de clima. Por favor, intenta nuevamente más tarde.</p>`;
        });
});