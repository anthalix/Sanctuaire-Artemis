export async function getApiUrl() {
	const ports = [8000, 8001];

	for (const p of ports) {
		try {
			const response = await fetch(`http://localhost:${p}/`, { method: 'GET' });

			if (response.ok) {
				return `http://localhost:${p}/api`;
			}
		} catch (error) {
			// On ignore l'erreur et on teste le port suivant
		}
	}

	throw new Error('Impossible de détecter le backend sur les ports 8000 ou 8001.');
}
export const API_URL = await getApiUrl();
