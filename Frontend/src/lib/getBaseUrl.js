export async function getBaseUrl() {
	const ports = [8000, 8001];

	for (const p of ports) {
		try {
			const res = await fetch(`http://localhost:${p}/`, { method: 'GET' });
			if (res.ok) {
				return `http://localhost:${p}`;
			}
		} catch (e) {}
	}

	throw new Error('Impossible de détecter le backend.');
}
export const BASE_URL = await getBaseUrl();
