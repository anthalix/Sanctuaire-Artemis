
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch }) => {
	const res = await fetch('http://localhost:8000/api/adopted');

	if (!res.ok) {
		return {
			adoptes: [],
			error: 'Impossible de charger les animaux adoptés'
		};
	}

	const adoptes = await res.json();

	return {
		adoptes
	};
};